<?php

namespace App\Filament\Resources\PurchaseOrders\Tables;

use App\Models\PurchaseOrder;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class PurchaseOrdersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('Azonosító')
                    ->formatStateUsing(fn (PurchaseOrder $record): string => $record->poNumber())
                    ->searchable(),
                TextColumn::make('quoteRequest.name')
                    ->label('Ügyfél')
                    ->searchable(),
                TextColumn::make('supplier.name')
                    ->label('Beszállító')
                    ->searchable(),
                TextColumn::make('items_count')
                    ->label('Tételek')
                    ->counts('items'),
                TextColumn::make('total')
                    ->label('Összeg')
                    ->state(fn (PurchaseOrder $record) => $record->totalAmount())
                    ->money('HUF'),
                TextColumn::make('status')
                    ->label('Státusz')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'sent' => 'success',
                        default => 'warning',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'sent' => 'Elküldve',
                        default => 'Piszkozat',
                    }),
                TextColumn::make('sent_at')
                    ->label('Elküldve')
                    ->dateTime('Y-m-d H:i')
                    ->placeholder('-'),
                TextColumn::make('created_at')
                    ->label('Létrehozva')
                    ->dateTime('Y-m-d H:i')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('status')
                    ->label('Státusz')
                    ->options([
                        'draft' => 'Piszkozat',
                        'sent' => 'Elküldve',
                    ]),
                SelectFilter::make('supplier_id')
                    ->label('Beszállító')
                    ->relationship('supplier', 'name'),
            ])
            ->recordActions([
                ViewAction::make(),
            ]);
    }
}
