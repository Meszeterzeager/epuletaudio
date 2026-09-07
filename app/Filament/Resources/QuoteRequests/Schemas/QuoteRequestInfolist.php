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
                        TextEntry::make('sound_system_type')
                            ->label('Hangrendszer típusa')
                            ->formatStateUsing(fn (?string $state): string => QuoteRequestForm::SOUND_SYSTEM_TYPES[$state] ?? '-')
                            ->placeholder('-'),
                        TextEntry::make('conference_room_type')
                            ->label('Használt tér típusa')
                            ->formatStateUsing(fn (?string $state): string => QuoteRequestForm::CONFERENCE_ROOM_TYPES[$state] ?? '-')
                            ->placeholder('-'),
                        TextEntry::make('conference_moderator_count')
                            ->label('Tervezett konferencia max. létszáma')
                            ->placeholder('-'),
                        TextEntry::make('tour_type')
                            ->label('Vezetett túra típusa')
                            ->formatStateUsing(fn (?string $state): string => QuoteRequestForm::TOUR_TYPES[$state] ?? '-')
                            ->placeholder('-'),
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
                        TextEntry::make('mobile_headcount')
                            ->label('Kihangosítandó létszám (mobil)')
                            ->placeholder('-'),
                        TextEntry::make('mobile_area_size')
                            ->label('Terület (mobil)')
                            ->placeholder('-'),
                        IconEntry::make('has_suspended_ceiling')
                            ->label('Van álmennyezet')
                            ->boolean(),
                        TextEntry::make('suspended_ceiling_type')
                            ->label('Álmennyezet típusa')
                            ->placeholder('-'),
                        IconEntry::make('has_room_sound_system')
                            ->label('Van hangrendszer a helyiségben, és azon keresztül szeretné használni')
                            ->boolean(),
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
                        TextEntry::make('mobile_speaker_type')
                            ->label('Hangsugárzók jellege (mobil)')
                            ->badge()
                            ->formatStateUsing(fn (string $state): string => QuoteRequestForm::MOBILE_SPEAKER_TYPES[$state] ?? $state)
                            ->placeholder('-')
                            ->columnSpanFull(),
                        TextEntry::make('amplifier_type')
                            ->label('Erősítő típusa (mobil)')
                            ->formatStateUsing(fn (?string $state): string => QuoteRequestForm::AMPLIFIER_TYPES[$state] ?? '-')
                            ->placeholder('-'),
                        TextEntry::make('amplifier_type_other')
                            ->label('Erősítő típusa — egyéb leírás')
                            ->placeholder('-'),
                        TextEntry::make('project_stage')
                            ->label('Létesítmény / helyiség stádiuma')
                            ->formatStateUsing(fn (?string $state): string => QuoteRequestForm::PROJECT_STAGES[$state] ?? '-')
                            ->placeholder('-'),
                        TextEntry::make('source_equipment')
                            ->label('Forráseszközök')
                            ->badge()
                            ->formatStateUsing(fn (string $state): string => QuoteRequestForm::SOURCE_EQUIPMENT[$state] ?? $state)
                            ->placeholder('-')
                            ->columnSpanFull(),
                        TextEntry::make('source_equipment_other')
                            ->label('Forráseszköz — egyéb')
                            ->placeholder('-'),
                        TextEntry::make('room_count')
                            ->label('Helyiségek / zónák (vagy helyszínek) száma')
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
                        TextEntry::make('conference_president_mic_count')
                            ->label('Elnöki mikrofon mennyisége')
                            ->placeholder('-'),
                        TextEntry::make('conference_delegate_mic_count')
                            ->label('Delegált mikrofon mennyisége')
                            ->placeholder('-'),
                        TextEntry::make('conference_recording_type')
                            ->label('Hangrögzítés típusa')
                            ->formatStateUsing(fn (?string $state): string => QuoteRequestForm::CONFERENCE_RECORDING_TYPES[$state] ?? '-')
                            ->placeholder('-'),
                        TextEntry::make('conference_room_sound_system_type')
                            ->label('Helyiségben üzemelő hangrendszer típusa')
                            ->formatStateUsing(fn (?string $state): string => QuoteRequestForm::CONFERENCE_ROOM_SOUND_SYSTEM_TYPES[$state] ?? '-')
                            ->placeholder('-'),
                        TextEntry::make('conference_room_sound_system_other')
                            ->label('Helyiségben üzemelő hangrendszer — egyéb')
                            ->placeholder('-'),
                        TextEntry::make('group_size')
                            ->label('Csoport létszáma (tourguide)')
                            ->placeholder('-'),
                        TextEntry::make('tour_guide_count')
                            ->label('Túravezetők száma (tourguide)')
                            ->placeholder('-'),
                        IconEntry::make('needs_transport_case')
                            ->label('Kell szállító / töltő koffer (tourguide)')
                            ->boolean(),
                        IconEntry::make('needs_fast_charger')
                            ->label('Kell gyorstöltő (tourguide)')
                            ->boolean(),
                        IconEntry::make('leads_small_groups')
                            ->label('Kisebb létszámú csoportokat is vezet (tourguide)')
                            ->boolean(),
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
                            ->formatStateUsing(fn (?string $state): ?string => ctype_digit((string) $state) ? number_format((float) $state, 0, ',', ' ').' Ft' : $state)
                            ->placeholder('-'),
                        TextEntry::make('needed_by_date')
                            ->label('Legkésőbb szükséges dátum')
                            ->date('Y.m.d.')
                            ->placeholder('-'),
                        TextEntry::make('delivery_method')
                            ->label('Kézbesítés módja (tourguide)')
                            ->formatStateUsing(fn (?string $state): string => QuoteRequestForm::DELIVERY_METHODS[$state] ?? '-')
                            ->placeholder('-'),
                        IconEntry::make('wants_installation')
                            ->label('Kivitelezésre is kér ajánlatot')
                            ->boolean(),
                        IconEntry::make('wants_site_survey')
                            ->label('Előzetes helyszíni felmérést kér')
                            ->boolean(),
                        TextEntry::make('site_survey_address')
                            ->label('Helyszíni felmérés címe')
                            ->placeholder('-'),
                        TextEntry::make('site_survey_notes')
                            ->label('Helyszíni felmérés — egyéb infó')
                            ->placeholder('-')
                            ->columnSpanFull(),
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
                        IconEntry::make('is_processing')
                            ->label('Feldolgozás alatt')
                            ->boolean(),
                        IconEntry::make('needs_clarification')
                            ->label('Egyeztetés szükséges')
                            ->boolean(),
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
                Section::make('Ajánlat adatai')
                    ->schema([
                        TextEntry::make('offer_number')->label('Ajánlatszám')->placeholder('Küldéskor generálódik'),
                        TextEntry::make('delivery_weeks')->label('Szállítási határidő')->placeholder('2-3 hét'),
                        TextEntry::make('system_description')->label('Rendszerleírás')->placeholder('-')->columnSpanFull(),
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
