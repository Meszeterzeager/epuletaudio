<?php

namespace App\Filament\Resources\SupplierProducts\Schemas;

use App\Services\ImageOptimizer;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class SupplierProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('supplier_id')
                    ->relationship('supplier', 'name')
                    ->required(),
                TextInput::make('name')
                    ->required(),
                TextInput::make('sku')
                    ->label('SKU')
                    ->default(null),
                TextInput::make('category')
                    ->default(null),
                Textarea::make('description')
                    ->default(null)
                    ->columnSpanFull(),
                FileUpload::make('image')
                    ->image()
                    ->saveUploadedFileUsing(ImageOptimizer::filamentSaveUsing(1200, 1200)),
                TextInput::make('purchase_price')
                    ->label('Beszerzési ár')
                    ->numeric()
                    ->default(null),
                Select::make('currency')
                    ->label('Pénznem')
                    ->options(['HUF' => 'HUF', 'EUR' => 'EUR', 'USD' => 'USD'])
                    ->required()
                    ->default('HUF'),
                TextInput::make('unit')
                    ->default(null),
                Toggle::make('is_active')
                    ->required(),
                Toggle::make('is_public_showcase')
                    ->required(),
                DateTimePicker::make('last_price_updated_at'),
            ]);
    }
}
