<?php

namespace App\Filament\Resources\Services\Schemas;

use App\Services\ImageOptimizer;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class ServiceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('slug')
                    ->required(),
                TextInput::make('title')
                    ->required(),
                TextInput::make('short_description')
                    ->default(null),
                Textarea::make('description')
                    ->default(null)
                    ->columnSpanFull(),
                TextInput::make('icon')
                    ->default(null),
                FileUpload::make('hero_image')
                    ->image()
                    ->saveUploadedFileUsing(ImageOptimizer::filamentSaveUsing(1920, 1080)),
                TextInput::make('order')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('meta_title')
                    ->default(null),
                TextInput::make('meta_description')
                    ->default(null),
                FileUpload::make('og_image')
                    ->image()
                    ->saveUploadedFileUsing(ImageOptimizer::filamentSaveUsing(1200, 630)),
            ]);
    }
}
