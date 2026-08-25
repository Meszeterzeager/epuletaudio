<?php

namespace App\Filament\Resources\BlogPosts\Schemas;

use App\Services\ImageOptimizer;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class BlogPostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('slug')
                    ->required(),
                TextInput::make('title')
                    ->required(),
                TextInput::make('excerpt')
                    ->default(null),
                Textarea::make('body')
                    ->default(null)
                    ->columnSpanFull(),
                FileUpload::make('cover_image')
                    ->image()
                    ->disk('public')
                    ->saveUploadedFileUsing(ImageOptimizer::filamentSaveUsing(1920, 1080)),
                DateTimePicker::make('published_at'),
                TextInput::make('meta_title')
                    ->default(null),
                TextInput::make('meta_description')
                    ->default(null),
                FileUpload::make('og_image')
                    ->image()
                    ->disk('public')
                    ->saveUploadedFileUsing(ImageOptimizer::filamentSaveUsing(1200, 630)),
            ]);
    }
}
