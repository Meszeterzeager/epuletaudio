<?php

namespace App\Filament\Resources\Solutions\RelationManagers;

use App\Filament\Resources\Projects\Schemas\ProjectForm;
use App\Services\ImageOptimizer;
use Filament\Actions\AssociateAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DissociateAction;
use Filament\Actions\DissociateBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;

class ProjectsRelationManager extends RelationManager
{
    protected static string $relationship = 'projects';

    protected static ?string $title = 'Referenciák';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('slug')
                    ->required(),
                TextInput::make('title')
                    ->label('Cím')
                    ->required(),
                FileUpload::make('og_image')
                    ->label('Borítókép')
                    ->image()
                    ->saveUploadedFileUsing(ImageOptimizer::filamentSaveUsing(1200, 630)),
                Toggle::make('is_active')
                    ->label('Aktív (látható a weboldalon)')
                    ->default(true),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns([
                ImageColumn::make('images.path')
                    ->label('Kép')
                    ->limit(1),
                TextColumn::make('title')
                    ->label('Cím')
                    ->searchable(),
                TextColumn::make('location')
                    ->label('Helyszín'),
                TextColumn::make('completed_at')
                    ->label('Átadás dátuma')
                    ->date('Y-m-d')
                    ->sortable(),
                ToggleColumn::make('is_active')
                    ->label('Aktív'),
            ])
            ->headerActions([
                CreateAction::make()
                    ->form(fn (Schema $schema): Schema => ProjectForm::configure($schema)),
                AssociateAction::make()
                    ->label('Meglévő referencia hozzárendelése'),
            ])
            ->recordActions([
                EditAction::make()
                    ->form(fn (Schema $schema): Schema => ProjectForm::configure($schema)),
                DissociateAction::make()
                    ->label('Leválasztás'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DissociateBulkAction::make(),
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
