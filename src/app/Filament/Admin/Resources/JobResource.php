<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\JobResource\Pages;
use App\Models\Job;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class JobResource extends Resource
{
    protected static ?string $model = Job::class;

    protected static ?string $navigationIcon = 'heroicon-o-briefcase';

    protected static ?string $navigationGroup = 'Administration';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('company_id')
                    ->required()
                    ->relationship('company', 'name')
                    ->searchable()
                    ->preload(),
                Forms\Components\Select::make('category_id')
                    ->relationship('category', 'name')
                    ->searchable()
                    ->preload()
                    ->nullable(),
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('slug')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('description')
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('requirements')
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('responsibilities')
                    ->columnSpanFull(),
                Forms\Components\Grid::make(2)
                    ->schema([
                        Forms\Components\TextInput::make('salary_min')
                            ->numeric()
                            ->prefix('Rp')
                            ->nullable(),
                        Forms\Components\TextInput::make('salary_max')
                            ->numeric()
                            ->prefix('Rp')
                            ->nullable(),
                    ]),
                Forms\Components\TextInput::make('location')
                    ->maxLength(255)
                    ->nullable(),
                Forms\Components\Select::make('employment_type')
                    ->required()
                    ->options([
                        'full_time' => 'Full Time',
                        'part_time' => 'Part Time',
                        'contract' => 'Contract',
                        'internship' => 'Internship',
                        'freelance' => 'Freelance',
                    ])
                    ->default('full_time'),
                Forms\Components\Select::make('experience_level')
                    ->required()
                    ->options([
                        'fresh_graduate' => 'Fresh Graduate',
                        'junior' => 'Junior',
                        'mid' => 'Mid',
                        'senior' => 'Senior',
                    ])
                    ->default('junior'),
                Forms\Components\DatePicker::make('deadline_at'),
                Forms\Components\Toggle::make('is_published')
                    ->required(),
                Forms\Components\Select::make('skills')
                    ->multiple()
                    ->relationship('skills', 'name')
                    ->searchable()
                    ->preload(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('company.name')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('category.name')
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('location')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('employment_type')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => str_replace('_', ' ', ucwords($state, '_'))),
                Tables\Columns\TextColumn::make('experience_level')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => str_replace('_', ' ', ucwords($state, '_'))),
                Tables\Columns\IconColumn::make('is_published')
                    ->boolean()
                    ->sortable(),
                Tables\Columns\TextColumn::make('deadline_at')
                    ->date()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_published')
                    ->label('Published'),
                Tables\Filters\SelectFilter::make('employment_type')
                    ->options([
                        'full_time' => 'Full Time',
                        'part_time' => 'Part Time',
                        'contract' => 'Contract',
                        'internship' => 'Internship',
                        'freelance' => 'Freelance',
                    ]),
                Tables\Filters\SelectFilter::make('experience_level')
                    ->options([
                        'fresh_graduate' => 'Fresh Graduate',
                        'junior' => 'Junior',
                        'mid' => 'Mid',
                        'senior' => 'Senior',
                    ]),
            ])
            ->actions([
                Tables\Actions\Action::make('toggle_publish')
                    ->label(fn (Job $record): string => $record->is_published ? 'Unpublish' : 'Publish')
                    ->icon(fn (Job $record): string => $record->is_published ? 'heroicon-o-eye-slash' : 'heroicon-o-eye')
                    ->action(fn (Job $record) => $record->update(['is_published' => ! $record->is_published])),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListJobs::route('/'),
            'create' => Pages\CreateJob::route('/create'),
            'edit' => Pages\EditJob::route('/{record}/edit'),
        ];
    }
}
