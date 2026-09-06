<?php

namespace App\Filament\Resources\Suppliers\RelationManagers;

use App\Filament\Resources\SupplierProducts\Schemas\SupplierProductForm;
use App\Models\SupplierProduct;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\TextInputColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ProductsRelationManager extends RelationManager
{
    protected static string $relationship = 'products';

    protected static ?string $title = 'Termékek';

    public function form(Schema $schema): Schema
    {
        return SupplierProductForm::configure($schema);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                ImageColumn::make('image')
                    ->label('')
                    ->disk('public')
                    ->size(48)
                    ->square(),
                TextInputColumn::make('name')
                    ->label('Név')
                    ->rules(['required', 'string', 'max:255'])
                    ->searchable(),
                TextColumn::make('sku')
                    ->label('Cikkszám')
                    ->searchable(),
                TextInputColumn::make('category')
                    ->label('Kategória')
                    ->searchable(),
                TextColumn::make('stock_status')
                    ->label('Elérhetőség')
                    ->badge()
                    ->color(fn (?string $state): string => match (true) {
                        $state === null => 'gray',
                        str_contains(mb_strtolower($state), 'raktáron') => 'success',
                        str_contains(mb_strtolower($state), 'hiány') || str_contains(mb_strtolower($state), 'megszűnt') => 'danger',
                        default => 'warning',
                    })
                    ->placeholder('-')
                    ->wrap(),
                TextColumn::make('selling_price')
                    ->label('Eladási ár (nettó)')
                    ->money(fn ($record) => $record->currency)
                    ->sortable(),
                TextColumn::make('purchase_price')
                    ->label('Beszerzési ár')
                    ->money(fn ($record) => $record->currency)
                    ->placeholder('-')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('category')
                    ->label('Kategória')
                    ->searchable()
                    ->options(fn (): array => SupplierProduct::query()
                        ->where('supplier_id', $this->getOwnerRecord()->id)
                        ->whereNotNull('category')
                        ->where('category', '!=', '')
                        ->distinct()
                        ->orderBy('category')
                        ->pluck('category', 'category')
                        ->all()),
            ])
            ->headerActions([
                CreateAction::make(),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
