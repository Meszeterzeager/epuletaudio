<?php

namespace App\Filament\Resources\Suppliers\RelationManagers;

use App\Filament\Resources\SupplierProducts\Schemas\SupplierProductForm;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
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
                    ->label('Kép'),
                TextColumn::make('name')
                    ->label('Név')
                    ->searchable(),
                TextColumn::make('purchase_price')
                    ->label('Beszerzési ár')
                    ->money()
                    ->sortable(),
                TextColumn::make('selling_price')
                    ->label('Eladási ár')
                    ->money()
                    ->sortable(),
                IconColumn::make('is_active')
                    ->label('Aktív')
                    ->boolean(),
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
