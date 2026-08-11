<?php

namespace App\Filament\Resources\QuoteRequests\Tables;

use App\Filament\Resources\QuoteRequests\Schemas\QuoteRequestForm;
use App\Models\QuoteRequest;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class QuoteRequestsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Név')
                    ->searchable(),
                TextColumn::make('company')
                    ->label('Cég')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('building_type')
                    ->label('Épület típusa')
                    ->formatStateUsing(fn (?string $state): string => QuoteRequestForm::BUILDING_TYPES[$state] ?? (string) $state)
                    ->searchable(),
                TextColumn::make('requested_systems')
                    ->label('Kért rendszerek')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => QuoteRequestForm::REQUESTED_SYSTEMS[$state] ?? $state),
                TextColumn::make('priority')
                    ->label('Prioritás')
                    ->formatStateUsing(fn (?string $state): string => QuoteRequestForm::PRIORITIES[$state] ?? '-')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('phone')
                    ->label('Telefon')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('status')
                    ->label('Státusz')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'new' => 'danger',
                        'quote_issued' => 'info',
                        'ordered' => 'success',
                        'postponed' => 'warning',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => QuoteRequest::STATUSES[$state] ?? $state),
                TextColumn::make('created_at')
                    ->label('Beérkezett')
                    ->dateTime('Y-m-d H:i')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('status')
                    ->label('Státusz')
                    ->options(QuoteRequest::STATUSES),
                SelectFilter::make('building_type')
                    ->label('Épület típusa')
                    ->options(QuoteRequestForm::BUILDING_TYPES),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
