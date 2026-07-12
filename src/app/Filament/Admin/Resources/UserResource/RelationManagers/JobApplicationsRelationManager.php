<?php

namespace App\Filament\Admin\Resources\UserResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class JobApplicationsRelationManager extends RelationManager
{
    protected static string $relationship = 'jobApplications';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('status')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('status')
            ->columns([
                Tables\Columns\TextColumn::make('job.title')
                    ->label('Lowongan')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('job.company.name')
                    ->label('Perusahaan'),
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
                    ->label('Applied'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'reviewed' => 'Reviewed',
                        'shortlisted' => 'Shortlisted',
                        'accepted' => 'Accepted',
                        'rejected' => 'Rejected',
                    ]),
            ])
            ->headerActions([])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([]);
    }
}
