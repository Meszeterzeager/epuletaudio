<?php

namespace App\Filament\Resources\PurchaseOrders\RelationManagers;

use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ItemsRelationManager extends RelationManager
{
    protected static string $relationship = 'items';

    protected static ?string $title = 'Tételek';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->label('Megnevezés')
                    ->required(),
                TextInput::make('sku')
                    ->label('Cikkszám')
                    ->default(null),
                TextInput::make('quantity')
                    ->label('Mennyiség')
                    ->numeric()
                    ->required(),
                TextInput::make('unit_price')
                    ->label('Beszerzési egységár')
                    ->numeric()
                    ->default(null),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns([
                TextColumn::make('title')
                    ->label('Megnevezés'),
                TextColumn::make('sku')
                    ->label('Cikkszám')
                    ->placeholder('-'),
                TextColumn::make('quantity')
                    ->label('Mennyiség'),
                TextColumn::make('unit_price')
                    ->label('Egységár')
                    ->money('HUF'),
                TextColumn::make('total')
                    ->label('Összesen')
                    ->state(fn ($record) => $record->quantity * (float) $record->unit_price)
                    ->money('HUF'),
            ])
            ->recordActions([
                EditAction::make(),
            ]);
    }
}
