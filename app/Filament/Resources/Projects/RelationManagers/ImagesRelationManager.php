<?php

namespace App\Filament\Resources\Projects\RelationManagers;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use App\Services\ImageOptimizer;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ImagesRelationManager extends RelationManager
{
    protected static string $relationship = 'images';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                FileUpload::make('path')
                    ->label('Kép')
                    ->image()
                    ->disk('public')
                    ->directory('projects')
                    ->saveUploadedFileUsing(ImageOptimizer::filamentSaveUsing(1920, 1080))
                    ->required(),
                TextInput::make('alt')
                    ->label('Alt szöveg')
                    ->required()
                    ->helperText('Rövid, leíró szöveg a képhez (akadálymentesség és SEO).')
                    ->maxLength(255),
                TextInput::make('order')
                    ->label('Sorrend')
                    ->numeric()
                    ->default(0),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('path')
            ->defaultSort('order')
            ->columns([
                ImageColumn::make('path')
                    ->label('Kép')
                    ->disk('public'),
                TextColumn::make('alt')
                    ->label('Alt szöveg'),
                TextColumn::make('order')
                    ->label('Sorrend')
                    ->sortable(),
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
