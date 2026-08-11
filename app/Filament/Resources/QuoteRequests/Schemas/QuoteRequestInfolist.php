<?php

namespace App\Filament\Resources\QuoteRequests\Schemas;

use App\Models\QuoteRequest;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class QuoteRequestInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Árrés és nyereség')
                    ->description('Csak admin számára látható — az ügyfélnek küldött ajánlatban sosem jelenik meg.')
                    ->icon('heroicon-o-banknotes')
                    ->columns(3)
                    ->schema([
                        TextEntry::make('revenue')
                            ->label('Ajánlat összege (nettó)')
                            ->state(fn (QuoteRequest $record) => static::revenue($record))
                            ->money('HUF'),
                        TextEntry::make('cost')
                            ->label('Beszerzési költség (nettó)')
                            ->state(fn (QuoteRequest $record) => static::cost($record))
                            ->money('HUF'),
                        TextEntry::make('margin')
                            ->label('Árrés (nyereség, nettó)')
                            ->state(fn (QuoteRequest $record) => static::revenue($record) - static::cost($record))
                            ->money('HUF')
                            ->weight('bold')
                            ->color(fn (QuoteRequest $record): string => (static::revenue($record) - static::cost($record)) >= 0 ? 'success' : 'danger'),
                        TextEntry::make('margin_percent')
                            ->label('Árrés %')
                            ->state(function (QuoteRequest $record): string {
                                $revenue = static::revenue($record);

                                if ($revenue <= 0) {
                                    return '-';
                                }

                                return number_format((($revenue - static::cost($record)) / $revenue) * 100, 1).' %';
                            })
                            ->columnSpanFull(),
                    ]),
                Section::make('Kapcsolattartó')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('name')
                            ->label('Név'),
                        TextEntry::make('email')
                            ->label('Email'),
                        TextEntry::make('phone')
                            ->label('Telefonszám'),
                        TextEntry::make('company')
                            ->label('Cégnév / intézmény')
                            ->placeholder('-'),
                    ]),

                Section::make('Projekt és tér')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('building_type')
                            ->label('Épület/intézmény típusa')
                            ->formatStateUsing(fn (?string $state): string => QuoteRequestForm::BUILDING_TYPES[$state] ?? (string) $state),
                        TextEntry::make('space_character')
                            ->label('Tér / zóna jellege')
                            ->formatStateUsing(fn (?string $state): string => QuoteRequestForm::SPACE_CHARACTERS[$state] ?? '-')
                            ->placeholder('-'),
                        TextEntry::make('requested_systems')
                            ->label('Kért rendszerek')
                            ->badge()
                            ->formatStateUsing(fn (string $state): string => QuoteRequestForm::REQUESTED_SYSTEMS[$state] ?? $state)
                            ->columnSpanFull(),
                        TextEntry::make('width_m')
                            ->label('Szélesség (m)')
                            ->placeholder('-'),
                        TextEntry::make('length_m')
                            ->label('Hosszúság (m)')
                            ->placeholder('-'),
                        TextEntry::make('ceiling_height_m')
                            ->label('Belmagasság (m)')
                            ->placeholder('-'),
                        TextEntry::make('area_sqm')
                            ->label('Becsült alapterület (m²)')
                            ->placeholder('-'),
                    ]),

                Section::make('Rendszer és eszközök')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('speaker_preference')
                            ->label('Hangsugárzók jellege')
                            ->badge()
                            ->formatStateUsing(fn (string $state): string => QuoteRequestForm::SPEAKER_PREFERENCES[$state] ?? $state)
                            ->placeholder('-')
                            ->columnSpanFull(),
                        TextEntry::make('project_stage')
                            ->label('Létesítmény stádiuma')
                            ->formatStateUsing(fn (?string $state): string => QuoteRequestForm::PROJECT_STAGES[$state] ?? '-')
                            ->placeholder('-'),
                        TextEntry::make('source_equipment')
                            ->label('Forráseszközök')
                            ->badge()
                            ->formatStateUsing(fn (string $state): string => QuoteRequestForm::SOURCE_EQUIPMENT[$state] ?? $state)
                            ->placeholder('-')
                            ->columnSpanFull(),
                        TextEntry::make('room_count')
                            ->label('Helyiségek / zónák száma')
                            ->placeholder('-'),
                        TextEntry::make('source_count')
                            ->label('Hangforrások száma')
                            ->placeholder('-'),
                        IconEntry::make('existing_system')
                            ->label('Van meglévő hangrendszer')
                            ->boolean(),
                        TextEntry::make('existing_system_notes')
                            ->label('Meglévő rendszer leírása')
                            ->placeholder('-')
                            ->columnSpanFull(),
                    ]),

                Section::make('Prioritások és kivitelezés')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('priority')
                            ->label('Fontosabb szempont')
                            ->formatStateUsing(fn (?string $state): string => QuoteRequestForm::PRIORITIES[$state] ?? '-')
                            ->placeholder('-'),
                        TextEntry::make('budget_huf')
                            ->label('Tervezett keret')
                            ->placeholder('-'),
                        IconEntry::make('wants_installation')
                            ->label('Kivitelezésre is kér ajánlatot')
                            ->boolean(),
                        IconEntry::make('wants_site_survey')
                            ->label('Előzetes helyszíni felmérést kér')
                            ->boolean(),
                    ]),

                Section::make('Egyéb')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('video_url')
                            ->label('Videó link')
                            ->placeholder('-'),
                        TextEntry::make('preferred_timeframe')
                            ->label('Tervezett kivitelezési időszak')
                            ->placeholder('-'),
                        TextEntry::make('message')
                            ->label('Megjegyzés')
                            ->placeholder('-')
                            ->columnSpanFull(),
                        IconEntry::make('gdpr_consent')
                            ->label('GDPR hozzájárulás')
                            ->boolean(),
                    ]),

                Section::make('Adminisztráció')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('status')
                            ->label('Státusz')
                            ->badge(),
                        TextEntry::make('internal_notes')
                            ->label('Belső jegyzet')
                            ->placeholder('-')
                            ->columnSpanFull(),
                        TextEntry::make('created_at')
                            ->label('Beérkezett')
                            ->dateTime()
                            ->placeholder('-'),
                        TextEntry::make('updated_at')
                            ->label('Frissítve')
                            ->dateTime()
                            ->placeholder('-'),
                    ]),
            ]);
    }

    private static function revenue(QuoteRequest $record): float
    {
        return (float) $record->items()->get()
            ->sum(fn ($item) => $item->quantity * (float) $item->unit_price);
    }

    private static function cost(QuoteRequest $record): float
    {
        return (float) $record->items()
            ->where('item_type', 'product')
            ->with('supplierProduct')
            ->get()
            ->sum(fn ($item) => $item->quantity * (float) ($item->supplierProduct?->purchase_price ?? 0));
    }
}
