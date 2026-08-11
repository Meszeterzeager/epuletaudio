<?php

namespace App\Filament\Resources\BillableServices\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class BillableServiceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Megnevezés')
                    ->helperText('Pl. Hangrendszer telepítés, Szerelési anyag, Hangszórókábel, Kiszállási díj, Beüzemelés.')
                    ->required(),
                Textarea::make('description')
                    ->label('Leírás')
                    ->default(null)
                    ->columnSpanFull(),
                TextInput::make('default_price')
                    ->label('Alapár')
                    ->numeric()
                    ->default(null),
                TextInput::make('unit')
                    ->label('Egység')
                    ->helperText('Pl. db, óra, m, alkalom.')
                    ->default(null),
                Toggle::make('is_active')
                    ->label('Aktív')
                    ->default(true)
                    ->required(),
            ]);
    }
}
