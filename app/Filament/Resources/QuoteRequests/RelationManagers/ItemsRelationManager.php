<?php

namespace App\Filament\Resources\QuoteRequests\RelationManagers;

use App\Models\BillableService;
use App\Models\SupplierProduct;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
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
                Radio::make('item_type')
                    ->label('Típus')
                    ->options([
                        'product' => 'Beszállítói termék',
                        'service' => 'Szolgáltatás',
                    ])
                    ->default('product')
                    ->live()
                    ->required(),

                Select::make('supplier_product_id')
                    ->label('Termék')
                    ->options(fn () => SupplierProduct::with('supplier')->get()
                        ->mapWithKeys(fn (SupplierProduct $product) => [
                            $product->id => "{$product->supplier?->name}: {$product->name}",
                        ]))
                    ->searchable()
                    ->visible(fn (Get $get): bool => $get('item_type') === 'product')
                    ->afterStateUpdated(function (Set $set, ?string $state): void {
                        if (! $state) {
                            return;
                        }

                        $product = SupplierProduct::find($state);

                        if ($product) {
                            $set('title', $product->name);
                            $set('unit_price', (string) ($product->selling_price ?? $product->purchase_price));
                        }
                    })
                    ->live(),

                Select::make('billable_service_id')
                    ->label('Szolgáltatás a katalógusból')
                    ->helperText('Opcionális — a katalógusból választva előtölti a nevet és az árat, de utána szabadon módosíthatod.')
                    ->options(fn () => BillableService::query()->where('is_active', true)->pluck('name', 'id'))
                    ->searchable()
                    ->visible(fn (Get $get): bool => $get('item_type') === 'service')
                    ->afterStateUpdated(function (Set $set, ?string $state): void {
                        if (! $state) {
                            return;
                        }

                        $service = BillableService::find($state);

                        if ($service) {
                            $set('title', $service->name);
                            $set('description', $service->description);
                            $set('unit_price', (string) $service->default_price);
                        }
                    })
                    ->live(),

                TextInput::make('title')
                    ->label('Megnevezés')
                    ->required(),

                Textarea::make('description')
                    ->label('Leírás')
                    ->default(null)
                    ->columnSpanFull(),

                TextInput::make('quantity')
                    ->label('Mennyiség')
                    ->numeric()
                    ->default(1)
                    ->required(),

                TextInput::make('unit_price')
                    ->label('Egységár')
                    ->numeric()
                    ->default(null),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->defaultSort('order')
            ->columns([
                TextColumn::make('item_type')
                    ->label('Típus')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'product' => 'Termék',
                        'service' => 'Szolgáltatás',
                        default => $state,
                    }),
                TextColumn::make('title')
                    ->label('Megnevezés'),
                TextColumn::make('quantity')
                    ->label('Mennyiség'),
                TextColumn::make('unit_price')
                    ->label('Egységár')
                    ->money(),
                TextColumn::make('total')
                    ->label('Összesen')
                    ->state(fn ($record) => $record->quantity * $record->unit_price)
                    ->money(),
            ])
            ->headerActions([
                CreateAction::make(),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
