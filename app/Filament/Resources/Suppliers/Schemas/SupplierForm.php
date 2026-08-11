<?php

namespace App\Filament\Resources\Suppliers\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class SupplierForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Beszállító neve')
                    ->required(),
                TextInput::make('website')
                    ->label('Weboldal')
                    ->url()
                    ->default(null),

                Section::make('Kapcsolattartó')
                    ->description('Ide küldjük a megrendeléseket (PO-kat) — email cím nélkül nem lehet automatikusan megrendelést küldeni ennek a beszállítónak.')
                    ->columns(3)
                    ->schema([
                        TextInput::make('contact_person')
                            ->label('Ügyintéző neve')
                            ->default(null),
                        TextInput::make('email')
                            ->label('Email cím')
                            ->email()
                            ->default(null),
                        TextInput::make('phone')
                            ->label('Telefonszám')
                            ->tel()
                            ->default(null),
                    ]),

                Textarea::make('notes')
                    ->label('Megjegyzés')
                    ->default(null)
                    ->columnSpanFull(),
                Toggle::make('is_active')
                    ->label('Aktív')
                    ->required(),
            ]);
    }
}
