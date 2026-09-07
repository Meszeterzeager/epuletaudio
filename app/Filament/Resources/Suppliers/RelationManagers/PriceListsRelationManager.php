<?php

namespace App\Filament\Resources\Suppliers\RelationManagers;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Storage;

class PriceListsRelationManager extends RelationManager
{
    protected static string $relationship = 'priceLists';
    protected static ?string $title = 'Árlisták';

    public function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('name')->label('Megnevezés')->required(),
            FileUpload::make('path')->label('Árlista fájl')->disk('public')->directory('supplier-price-lists')->required(),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('name')->label('Megnevezés')->searchable(),
            TextColumn::make('path')->label('Fájl')->formatStateUsing(fn (string $state): string => basename($state)),
            TextColumn::make('updated_at')->label('Frissítve')->dateTime('Y.m.d. H:i'),
        ])->headerActions([CreateAction::make()])
            ->recordActions([
                \Filament\Actions\Action::make('download')->label('Letöltés')->icon('heroicon-o-arrow-down-tray')
                    ->action(fn ($record) => response()->download(Storage::disk('public')->path($record->path), basename($record->path))),
                DeleteAction::make(),
            ])->toolbarActions([BulkActionGroup::make([DeleteBulkAction::make()])]);
    }
}
