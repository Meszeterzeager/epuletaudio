<?php

namespace App\Filament\Resources\SupplierProducts\Schemas;

use App\Services\ImageOptimizer;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
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
                    ->required()
                    ->disabled(fn (string $operation): bool => $operation === 'edit'),
                TextInput::make('name')
                    ->required()
                    ->disabled(fn (string $operation): bool => $operation === 'edit'),
                TextInput::make('sku')
                    ->label('SKU')
                    ->default(null)
                    ->disabled(fn (string $operation): bool => $operation === 'edit'),
                TextInput::make('category')
                    ->default(null)
                    ->disabled(fn (string $operation): bool => $operation === 'edit'),
                Textarea::make('description')
                    ->default(null)
                    ->columnSpanFull()
                    ->disabled(fn (string $operation): bool => $operation === 'edit'),
                FileUpload::make('image')
                    ->image()
                    ->saveUploadedFileUsing(ImageOptimizer::filamentSaveUsing(1200, 1200))
                    ->disabled(fn (string $operation): bool => $operation === 'edit'),
                TextInput::make('purchase_price')
                    ->label('Beszerzési ár')
                    ->numeric()
                    ->default(null),
                TextInput::make('selling_price')
                    ->label('Eladási ár')
                    ->numeric()
                    ->default(null),
                Select::make('currency')
                    ->label('Pénznem')
                    ->options(['HUF' => 'HUF', 'EUR' => 'EUR', 'USD' => 'USD'])
                    ->required()
                    ->default('HUF')
                    ->disabled(fn (string $operation): bool => $operation === 'edit'),
                TextInput::make('unit')
                    ->default(null)
                    ->disabled(fn (string $operation): bool => $operation === 'edit'),
                Toggle::make('is_active')
                    ->required(),
                Toggle::make('is_public_showcase')
                    ->required()
                    ->disabled(fn (string $operation): bool => $operation === 'edit'),
                DateTimePicker::make('last_price_updated_at'),
            ]);
    }
}
