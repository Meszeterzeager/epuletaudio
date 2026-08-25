<?php

namespace App\Filament\Resources\Solutions\Schemas;

use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class SolutionInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('slug'),
                TextEntry::make('industry_name'),
                TextEntry::make('description')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('challenges')
                    ->label('Tipikus kihívások')
                    ->listWithLineBreaks()
                    ->bulleted()
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('recommended_package')
                    ->label('Ajánlott technológia csomag')
                    ->listWithLineBreaks()
                    ->bulleted()
                    ->placeholder('-')
                    ->columnSpanFull(),
                ImageEntry::make('hero_image')
                    ->disk('public')
                    ->placeholder('-'),
                TextEntry::make('order')
                    ->numeric(),
                TextEntry::make('meta_title')
                    ->placeholder('-'),
                TextEntry::make('meta_description')
                    ->placeholder('-'),
                ImageEntry::make('og_image')
                    ->disk('public')
                    ->placeholder('-'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
