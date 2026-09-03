<?php

namespace App\Filament\Resources\SupplierProducts\Schemas;

use App\Services\ImageOptimizer;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
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
                    ->default(null),
                Textarea::make('description')
                    ->default(null)
                    ->columnSpanFull()
                    ->disabled(fn (string $operation): bool => $operation === 'edit'),
                FileUpload::make('image')
                    ->label('Fő kép')
                    ->image()
                    ->disk('public')
                    ->imagePreviewHeight('200')
                    ->saveUploadedFileUsing(ImageOptimizer::filamentSaveUsing(1920, 1920)),
                Repeater::make('images')
                    ->relationship()
                    ->label('Galéria (további képek)')
                    ->columnSpanFull()
                    ->reorderableWithButtons()
                    ->orderColumn('order')
                    ->grid(3)
                    ->simple(
                        FileUpload::make('path')
                            ->image()
                            ->disk('public')
                            ->directory('supplier-products')
                            ->imagePreviewHeight('150')
                            ->saveUploadedFileUsing(ImageOptimizer::filamentSaveUsing(1920, 1920))
                            ->required(),
                    )
                    ->addActionLabel('Kép hozzáadása'),
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
                TextInput::make('stock_status')
                    ->label('Elérhetőség')
                    ->default(null),
                DateTimePicker::make('last_price_updated_at'),
            ]);
    }
}
