<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\JobApplicationResource\Pages;
use App\Models\JobApplication;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class JobApplicationResource extends Resource
{
    protected static ?string $model = JobApplication::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationGroup = 'Administration';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('job_id')
                    ->required()
                    ->relationship('job', 'title')
                    ->searchable()
                    ->preload(),
                Forms\Components\Select::make('user_id')
                    ->required()
                    ->relationship('user', 'name')
                    ->searchable()
                    ->preload(),
                Forms\Components\TextInput::make('cv_path')
                    ->maxLength(255)
                    ->nullable(),
                Forms\Components\Textarea::make('cover_letter')
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('experience_summary')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('portfolio_url')
                    ->maxLength(255)
                    ->url()
                    ->nullable(),
                Forms\Components\TextInput::make('expected_salary')
                    ->numeric()
                    ->prefix('Rp')
                    ->nullable(),
                Forms\Components\TextInput::make('match_score')
                    ->numeric()
                    ->suffix('%')
                    ->nullable(),
                Forms\Components\Select::make('status')
                    ->required()
                    ->options([
                        'pending' => 'Pending',
                        'reviewed' => 'Reviewed',
                        'shortlisted' => 'Shortlisted',
                        'accepted' => 'Accepted',
                        'rejected' => 'Rejected',
                    ])
                    ->default('pending'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Pelamar')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('job.title')
                    ->label('Lowongan')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('job.company.name')
                    ->label('Perusahaan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('match_score')
                    ->label('Match')
                    ->suffix('%')
                    ->sortable()
                    ->color(fn (int $state): string => match(true) {
                        $state >= 70 => 'success',
                        $state >= 40 => 'warning',
                        default => 'danger',
                    }),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'reviewed' => 'info',
                        'shortlisted' => 'primary',
                        'accepted' => 'success',
                        'rejected' => 'danger',
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->date()
                    ->sortable()
                    ->label('Applied'),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'reviewed' => 'Reviewed',
                        'shortlisted' => 'Shortlisted',
                        'accepted' => 'Accepted',
                        'rejected' => 'Rejected',
                    ]),
                Tables\Filters\SelectFilter::make('job_id')
                    ->relationship('job', 'title')
                    ->label('Lowongan'),
            ])
            ->actions([
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
            'index' => Pages\ListJobApplications::route('/'),
            'create' => Pages\CreateJobApplication::route('/create'),
            'edit' => Pages\EditJobApplication::route('/{record}/edit'),
        ];
    }
}
