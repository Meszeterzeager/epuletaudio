<?php

namespace App\Filament\Resources\SupplierProducts\Schemas;

use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Storage;

class SupplierProductInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                ImageEntry::make('image')
                    ->label('')
                    ->disk('public')
                    ->columnSpanFull()
                    ->imageWidth('100%')
                    ->imageHeight(520)
                    ->extraImgAttributes([
                        'style' => 'object-fit: contain !important; background-color: #f9fafb; border-radius: 0.75rem;',
                    ])
                    ->placeholder('-'),
                TextEntry::make('supplier.name')
                    ->label('Beszállító'),
                TextEntry::make('name')
                    ->label('Név'),
                TextEntry::make('sku')
                    ->label('SKU')
                    ->placeholder('-'),
                TextEntry::make('category')
                    ->label('Kategória')
                    ->placeholder('-'),
                TextEntry::make('description')
                    ->label('Leírás')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('selling_price')
                    ->label('Eladási ár (nettó)')
                    ->money(fn ($record) => $record->currency)
                    ->placeholder('-'),
                TextEntry::make('purchase_price')
                    ->label('Beszerzési ár')
                    ->money(fn ($record) => $record->currency)
                    ->placeholder('- (nem ismert)'),
                TextEntry::make('unit')
                    ->label('Egység')
                    ->placeholder('-'),
                TextEntry::make('last_price_updated_at')
                    ->label('Ár frissítve')
                    ->dateTime()
                    ->placeholder('-'),
                RepeatableEntry::make('images')
                    ->label('Galéria')
                    ->columnSpanFull()
                    ->grid(4)
                    ->schema([
                        ImageEntry::make('path')
                            ->label('')
                            ->disk('public')
                            ->imageSize(220)
                            ->extraImgAttributes([
                                'style' => 'object-fit: cover !important; border-radius: 0.5rem;',
                            ]),
                    ])
                    ->placeholder('Nincs galériakép. A "Szerkesztés" gombbal tölthetsz fel újakat.'),
                RepeatableEntry::make('files')
                    ->label('Dokumentumok')
                    ->columnSpanFull()
                    ->schema([
                        TextEntry::make('filename')
                            ->label('')
                            ->url(fn ($record) => Storage::disk('local')->temporaryUrl($record->path, now()->addMinutes(30)))
                            ->openUrlInNewTab()
                            ->icon('heroicon-o-document-arrow-down'),
                    ])
                    ->placeholder('Nincs csatolt dokumentum.'),
                TextEntry::make('created_at')
                    ->label('Létrehozva')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->label('Frissítve')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
