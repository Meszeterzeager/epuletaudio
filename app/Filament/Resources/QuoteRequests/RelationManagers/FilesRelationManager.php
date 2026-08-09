<?php

namespace App\Filament\Resources\QuoteRequests\RelationManagers;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class FilesRelationManager extends RelationManager
{
    protected static string $relationship = 'files';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('type')
                    ->label('Típus')
                    ->options([
                        'floor_plan' => 'Alaprajz',
                        'photo' => 'Fotó',
                        'video' => 'Videó',
                    ])
                    ->required(),
                FileUpload::make('path')
                    ->label('Fájl')
                    ->directory('quote-requests')
                    ->visibility('private'),
                TextInput::make('url')
                    ->label('Videó link')
                    ->url(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('type')
            ->columns([
                TextColumn::make('type')
                    ->label('Típus')
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'floor_plan' => 'Alaprajz',
                        'photo' => 'Fotó',
                        'video' => 'Videó',
                        default => $state,
                    })
                    ->badge(),
                TextColumn::make('path')
                    ->label('Fájl'),
                TextColumn::make('url')
                    ->label('Videó link')
                    ->url(fn (?string $state): ?string => $state)
                    ->openUrlInNewTab(),
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
