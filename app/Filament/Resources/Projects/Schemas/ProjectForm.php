<?php

namespace App\Filament\Resources\Projects\Schemas;

use App\Services\ImageOptimizer;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Utilities\Get;
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
                Toggle::make('html_mode')
                    ->label('HTML forráskód szerkesztése')
                    ->helperText('Kapcsold be, ha közvetlenül HTML kódként akarod szerkeszteni a leírást a formázott szövegszerkesztő helyett.')
                    ->live()
                    ->dehydrated(false)
                    ->default(false)
                    ->columnSpanFull(),
                RichEditor::make('description')
                    ->label('Leírás')
                    ->hidden(fn (Get $get): bool => (bool) $get('html_mode'))
                    ->columnSpanFull(),
                Textarea::make('description')
                    ->label('Leírás (HTML forrás)')
                    ->rows(20)
                    ->visible(fn (Get $get): bool => (bool) $get('html_mode'))
                    ->columnSpanFull(),
                TextInput::make('location')
                    ->default(null),
                DatePicker::make('completed_at'),
                Toggle::make('is_active')
                    ->label('Aktív (látható a weboldalon)')
                    ->default(true),
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
