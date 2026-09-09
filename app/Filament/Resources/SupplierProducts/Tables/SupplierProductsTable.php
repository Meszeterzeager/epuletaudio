<?php

namespace App\Filament\Resources\SupplierProducts\Tables;

use App\Filament\Resources\SupplierProducts\SupplierProductResource;
use App\Models\SupplierProduct;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\TextInputColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Table;

class SupplierProductsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')
                    ->label('')
                    ->disk('public')
                    ->size(80)
                    ->extraImgAttributes(['style' => 'object-fit: contain !important; background-color: #f9fafb; border-radius: 0.25rem;'])
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
                TextColumn::make('selling_price')
                    ->label('Eladási ár (nettó)')
                    ->money(fn ($record) => $record->currency)
                    ->sortable(),
                TextColumn::make('purchase_price')
                    ->label('Beszerzési ár')
                    ->money(fn ($record) => $record->currency)
                    ->placeholder('-')
                    ->sortable(),
                TextColumn::make('unit')
                    ->searchable()
                    ->placeholder('-')
                    ->toggleable(isToggledHiddenByDefault: true),
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
                TextColumn::make('last_price_updated_at')
                    ->dateTime()
                    ->placeholder('-')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->groups([
                Group::make('supplier.name')
                    ->label('Beszállító')
                    ->collapsible(),
            ])
            ->defaultGroup('supplier.name')
            ->filters([
                SelectFilter::make('supplier_id')
                    ->label('Beszállító')
                    ->relationship('supplier', 'name'),
                SelectFilter::make('category')
                    ->label('Kategória')
                    ->searchable()
                    ->options(fn (): array => SupplierProduct::query()
                        ->whereNotNull('category')
                        ->where('category', '!=', '')
                        ->distinct()
                        ->orderBy('category')
                        ->pluck('category', 'category')
                        ->all()),
            ])
            ->defaultPaginationPageOption(50)
            ->paginationPageOptions([50, 100, 'all'])
            ->recordUrl(fn ($record): string => SupplierProductResource::getUrl('edit', ['record' => $record]))
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
