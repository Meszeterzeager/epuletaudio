<?php

namespace App\Filament\Resources\PurchaseOrders\Schemas;

use App\Models\PurchaseOrder;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PurchaseOrderInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Megrendelés adatai')
                    ->columns(3)
                    ->schema([
                        TextEntry::make('id')
                            ->label('Azonosító')
                            ->formatStateUsing(fn (PurchaseOrder $record): string => $record->poNumber()),
                        TextEntry::make('status')
                            ->label('Státusz')
                            ->badge()
                            ->color(fn (string $state): string => $state === 'sent' ? 'success' : 'warning')
                            ->formatStateUsing(fn (string $state): string => $state === 'sent' ? 'Elküldve' : 'Piszkozat'),
                        TextEntry::make('sent_at')
                            ->label('Elküldve')
                            ->dateTime('Y-m-d H:i')
                            ->placeholder('Még nem lett elküldve'),
                    ]),
                Section::make('Ügyfél / ajánlat')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('quoteRequest.name')
                            ->label('Ügyfél neve'),
                        TextEntry::make('quoteRequest.company')
                            ->label('Cég')
                            ->placeholder('-'),
                    ]),
                Section::make('Beszállító')
                    ->columns(3)
                    ->schema([
                        TextEntry::make('supplier.name')
                            ->label('Beszállító neve'),
                        TextEntry::make('supplier.email')
                            ->label('Email cím')
                            ->placeholder('Nincs megadva — nem tudunk automatikusan megrendelést küldeni!')
                            ->color(fn (?string $state) => blank($state) ? 'danger' : null),
                        TextEntry::make('supplier.phone')
                            ->label('Telefon')
                            ->placeholder('-'),
                    ]),
            ]);
    }
}
