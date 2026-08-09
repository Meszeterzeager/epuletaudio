<?php

namespace App\Filament\Resources\Projects\Schemas;

use App\Services\ImageOptimizer;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class ProjectForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('slug')
                    ->required(),
                TextInput::make('title')
                    ->required(),
                Select::make('solution_id')
                    ->label('Iparági megoldás')
                    ->relationship('solution', 'industry_name')
                    ->searchable()
                    ->default(null),
                Textarea::make('description')
                    ->default(null)
                    ->columnSpanFull(),
                TextInput::make('location')
                    ->default(null),
                DatePicker::make('completed_at'),
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
