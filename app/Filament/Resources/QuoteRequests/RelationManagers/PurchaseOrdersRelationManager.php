<?php

namespace App\Filament\Resources\QuoteRequests\RelationManagers;

use App\Filament\Resources\PurchaseOrders\PurchaseOrderResource;
use App\Models\PurchaseOrder;
use Filament\Actions\Action;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PurchaseOrdersRelationManager extends RelationManager
{
    protected static string $relationship = 'purchaseOrders';

    protected static ?string $title = 'Beszerzés';

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                TextColumn::make('id')
                    ->label('Azonosító')
                    ->formatStateUsing(fn (PurchaseOrder $record): string => $record->poNumber()),
                TextColumn::make('supplier.name')
                    ->label('Beszállító'),
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
                    ->color(fn (string $state): string => $state === 'sent' ? 'success' : 'warning')
                    ->formatStateUsing(fn (string $state): string => $state === 'sent' ? 'Elküldve' : 'Piszkozat'),
            ])
            ->headerActions([
                //
            ])
            ->recordActions([
                Action::make('view')
                    ->label('Megnyitás')
                    ->icon('heroicon-o-arrow-top-right-on-square')
                    ->color('gray')
                    ->url(fn (PurchaseOrder $record): string => PurchaseOrderResource::getUrl('view', ['record' => $record])),
                PurchaseOrderResource::sendAction(),
            ]);
    }
}
