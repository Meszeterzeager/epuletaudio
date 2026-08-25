<?php

namespace App\Filament\Resources\Solutions\Schemas;

use App\Services\ImageOptimizer;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class SolutionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('slug')
                    ->required(),
                TextInput::make('industry_name')
                    ->required(),
                Textarea::make('description')
                    ->default(null)
                    ->columnSpanFull(),
                TagsInput::make('challenges')
                    ->label('Tipikus kihívások')
                    ->helperText('Enterrel adj hozzá egy-egy rövid kihívást (pl. "Nagy tér, visszhang").')
                    ->columnSpanFull(),
                TagsInput::make('recommended_package')
                    ->label('Ajánlott technológia csomag')
                    ->helperText('Enterrel adj hozzá egy-egy elemet (pl. "100V hangfalak").')
                    ->columnSpanFull(),
                FileUpload::make('hero_image')
                    ->image()
                    ->disk('public')
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
                    ->disk('public')
                    ->saveUploadedFileUsing(ImageOptimizer::filamentSaveUsing(1200, 630)),
            ]);
    }
}
