<?php

namespace App\Filament\Resources\QuoteRequests\Schemas;

use App\Models\QuoteRequest;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;

class QuoteRequestForm
{
    public const BUILDING_TYPES = [
        'templom' => 'Templom',
        'fogaszat_rendelo' => 'Fogászat / rendelő',
        'kavezo_vendeglatas' => 'Kávézó / vendéglátás',
        'iroda' => 'Iroda',
        'oktatasi_intezmeny' => 'Oktatási intézmény',
        'ipari_letesitmeny' => 'Ipari létesítmény',
        'hivatali_letesitmeny' => 'Hivatali létesítmény (önkormányzat, minisztérium)',
        'kozulet' => 'Egyéb közület',
        'maganszemely' => 'Magánszemély',
    ];

    public const SOUND_SYSTEM_TYPES = [
        'egyszeru' => 'Egyszerű hangrendszer',
        'zonas' => 'Zónás hangrendszer',
        'matrix' => 'Mátrix hangrendszer',
    ];

    public const CONFERENCE_ROOM_TYPES = [
        'konferenciaterem' => 'Konferenciaterem',
        'eloadoterem' => 'Előadóterem',
        'meeting_room' => 'Meeting room',
        'egyetemi_oktatasi_eloado' => 'Egyetemi vagy oktatási előadó',
        'targyalo' => 'Tárgyalóterem',
    ];

    public const CONFERENCE_RECORDING_TYPES = [
        'analog' => 'Analóg',
        'digitalis' => 'Digitális',
    ];

    public const CONFERENCE_ROOM_SOUND_SYSTEM_TYPES = [
        'hagyomanyos' => 'Hagyományos',
        'voltos_100' => '100 voltos',
        'otthoni_hifi' => 'Otthoni HiFi',
        'egyeb' => 'Egyéb',
    ];

    public const AMPLIFIER_TYPES = [
        'digitalis' => 'Digitális',
        'analog' => 'Analóg',
        'kevero_erosito' => 'Keverőerősítő',
        'nem_tudom' => 'Nem tudom',
    ];

    public const MOBILE_SPEAKER_TYPES = [
        'aktiv' => 'Aktív hangszóró',
        'passziv' => 'Passzív hangszóró',
        'gurulos' => 'Mobil, gurulós hangrendszer',
    ];

    public const TOUR_TYPES = [
        'kulfoldi_utazas' => 'Külföldi utazás',
        'belfoldi_utazas' => 'Belföldi utazás (utazási iroda)',
        'muzeum' => 'Múzeum',
        'gyartura' => 'Gyártúra / gyárlátogatás',
        'egyeb_szabadteri' => 'Egyéb szabadtéri rendezvény',
    ];

    public const DELIVERY_METHODS = [
        'futarszolgalat' => 'Futárszolgálattal kérem',
        'szemelyes_kiszallitas' => 'Személyes kiszállítást kérek Pest megyén belül (felárral)',
    ];

    public const REQUESTED_SYSTEMS = [
        'epulethangositas' => 'Épülethangosítás',
        'konferenciarendszer' => 'Konferenciarendszer',
        'tourguide_rendszer' => 'Tourguide rendszer',
        'mobil_hangositas' => 'Mobil hangosítás',
    ];

    public const SPACE_CHARACTERS = [
        'zart' => 'Zárt tér',
        'felig_nyitott_vedett' => 'Félig nyitott, csapadéktól védett',
        'felig_nyitott_nem_vedett' => 'Félig nyitott, csapadéktól nem védett',
        'szabadteri' => 'Szabadtéri',
    ];

    public const SPEAKER_PREFERENCES = [
        'sullyesztett' => 'Süllyesztett (mennyezeti, fali)',
        'fuggesztett' => 'Függesztett (mennyezeti)',
        'konzolos' => 'Konzolos (falra vagy oszlopra)',
    ];

    public const PROJECT_STAGES = [
        'tervezes' => 'Tervezés alatt',
        'epul_felujitas' => 'Már épül / felújítás alatt',
        'kesz' => 'Kész',
    ];

    public const SOURCE_EQUIPMENT = [
        'vezetekes_mikrofon' => 'Vezetékes mikrofon',
        'vezetek_nelkuli_mikrofon' => 'Vezeték nélküli mikrofon',
        'bluetooth' => 'Bluetooth',
        'telefon' => 'Telefon',
        'lejatszo' => 'Lejátszó',
        'cd_lejatszo' => 'CD lejátszó',
        'laptop' => 'Laptop',
        'egyeb' => 'Egyéb',
    ];

    public const PRIORITIES = [
        'alacsony_koltseg' => 'Alacsony költség',
        'magas_hangminoseg' => 'Magas hangminőség',
        'nem_tudom_eldonteni' => 'Nem tudok dönteni',
    ];

    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Kapcsolattartó')
                    ->columns(2)
                    ->schema([
                        TextInput::make('name')
                            ->label('Név')
                            ->required(),
                        TextInput::make('email')
                            ->label('Email')
                            ->email()
                            ->required(),
                        TextInput::make('phone')
                            ->label('Telefonszám')
                            ->tel()
                            ->required(),
                        TextInput::make('company')
                            ->label('Cégnév / intézmény')
                            ->default(null),
                    ]),

                Section::make('Projekt és tér')
                    ->columns(2)
                    ->schema([
                        Select::make('building_type')
                            ->label('Épület/intézmény típusa')
                            ->options(self::BUILDING_TYPES)
                            ->required(),
                        Select::make('space_character')
                            ->label('Tér / zóna jellege')
                            ->options(self::SPACE_CHARACTERS)
                            ->default(null),
                        CheckboxList::make('requested_systems')
                            ->label('Kért rendszerek')
                            ->options(self::REQUESTED_SYSTEMS)
                            ->live()
                            ->required()
                            ->columnSpanFull(),
                        Select::make('sound_system_type')
                            ->label('Hangrendszer típusa')
                            ->options(self::SOUND_SYSTEM_TYPES)
                            ->default(null)
                            ->visible(fn (Get $get): bool => in_array('epulethangositas', $get('requested_systems') ?? [])),
                        Select::make('conference_room_type')
                            ->label('Használt tér típusa')
                            ->options(self::CONFERENCE_ROOM_TYPES)
                            ->default(null)
                            ->visible(fn (Get $get): bool => in_array('konferenciarendszer', $get('requested_systems') ?? [])),
                        TextInput::make('conference_moderator_count')
                            ->label('Tervezett konferencia max. létszáma')
                            ->numeric()
                            ->default(null)
                            ->visible(fn (Get $get): bool => in_array('konferenciarendszer', $get('requested_systems') ?? [])),
                        Select::make('tour_type')
                            ->label('Vezetett túra típusa')
                            ->options(self::TOUR_TYPES)
                            ->default(null)
                            ->visible(fn (Get $get): bool => in_array('tourguide_rendszer', $get('requested_systems') ?? [])),
                        TextInput::make('width_m')
                            ->label('Szélesség (m)')
                            ->numeric()
                            ->default(null),
                        TextInput::make('length_m')
                            ->label('Hosszúság (m)')
                            ->numeric()
                            ->default(null),
                        TextInput::make('ceiling_height_m')
                            ->label('Belmagasság (m)')
                            ->numeric()
                            ->default(null),
                        TextInput::make('area_sqm')
                            ->label('Becsült alapterület (m²)')
                            ->numeric()
                            ->default(null),
                        TextInput::make('mobile_headcount')
                            ->label('Kihangosítandó létszám (mobil hangosítás)')
                            ->numeric()
                            ->default(null)
                            ->visible(fn (Get $get): bool => in_array('mobil_hangositas', $get('requested_systems') ?? [])),
                        TextInput::make('mobile_area_size')
                            ->label('Terület (mobil hangosítás)')
                            ->default(null)
                            ->visible(fn (Get $get): bool => in_array('mobil_hangositas', $get('requested_systems') ?? [])),
                        Toggle::make('has_suspended_ceiling')
                            ->label('Van álmennyezet'),
                        TextInput::make('suspended_ceiling_type')
                            ->label('Álmennyezet típusa')
                            ->default(null),
                        Toggle::make('has_room_sound_system')
                            ->label('Van hangrendszer a helyiségben, és azon keresztül szeretné használni')
                            ->visible(fn (Get $get): bool => in_array('konferenciarendszer', $get('requested_systems') ?? [])),
                    ]),

                Section::make('Rendszer és eszközök')
                    ->columns(2)
                    ->schema([
                        CheckboxList::make('speaker_preference')
                            ->label('Hangsugárzók jellege')
                            ->options(self::SPEAKER_PREFERENCES)
                            ->columnSpanFull(),
                        CheckboxList::make('mobile_speaker_type')
                            ->label('Hangsugárzók jellege (mobil hangosítás)')
                            ->options(self::MOBILE_SPEAKER_TYPES)
                            ->columnSpanFull(),
                        Select::make('amplifier_type')
                            ->label('Erősítő típusa (mobil hangosítás)')
                            ->options(self::AMPLIFIER_TYPES)
                            ->default(null),
                        TextInput::make('amplifier_type_other')
                            ->label('Erősítő típusa — egyéb leírás')
                            ->default(null),
                        Select::make('project_stage')
                            ->label('Létesítmény / helyiség stádiuma')
                            ->options(self::PROJECT_STAGES)
                            ->default(null),
                        CheckboxList::make('source_equipment')
                            ->label('Forráseszközök')
                            ->options(self::SOURCE_EQUIPMENT)
                            ->live()
                            ->columnSpanFull(),
                        TextInput::make('source_equipment_other')
                            ->label('Forráseszköz — egyéb')
                            ->default(null)
                            ->visible(fn (Get $get): bool => in_array('egyeb', $get('source_equipment') ?? [])),
                        TextInput::make('room_count')
                            ->label('Helyiségek / zónák (vagy helyszínek) száma')
                            ->numeric()
                            ->default(null),
                        TextInput::make('source_count')
                            ->label('Hangforrások száma')
                            ->numeric()
                            ->default(null),
                        Toggle::make('existing_system')
                            ->label('Van meglévő hangrendszer')
                            ->required(),
                        Textarea::make('existing_system_notes')
                            ->label('Meglévő rendszer leírása')
                            ->default(null)
                            ->columnSpanFull(),
                        TextInput::make('conference_president_mic_count')
                            ->label('Elnöki mikrofon mennyisége')
                            ->numeric()
                            ->default(null),
                        TextInput::make('conference_delegate_mic_count')
                            ->label('Delegált mikrofon mennyisége')
                            ->numeric()
                            ->default(null),
                        Select::make('conference_recording_type')
                            ->label('Hangrögzítés típusa')
                            ->options(self::CONFERENCE_RECORDING_TYPES)
                            ->default(null),
                        Select::make('conference_room_sound_system_type')
                            ->label('Helyiségben üzemelő hangrendszer típusa')
                            ->options(self::CONFERENCE_ROOM_SOUND_SYSTEM_TYPES)
                            ->live()
                            ->default(null),
                        TextInput::make('conference_room_sound_system_other')
                            ->label('Helyiségben üzemelő hangrendszer — egyéb')
                            ->default(null)
                            ->visible(fn (Get $get): bool => $get('conference_room_sound_system_type') === 'egyeb'),
                        TextInput::make('group_size')
                            ->label('Csoport létszáma (tourguide)')
                            ->numeric()
                            ->default(null),
                        TextInput::make('tour_guide_count')
                            ->label('Túravezetők száma (tourguide)')
                            ->numeric()
                            ->default(null),
                        Toggle::make('needs_transport_case')
                            ->label('Kell szállító / töltő koffer (tourguide)'),
                        Toggle::make('needs_fast_charger')
                            ->label('Kell gyorstöltő (tourguide)'),
                        Toggle::make('leads_small_groups')
                            ->label('Kisebb létszámú csoportokat is vezet (tourguide)'),
                    ]),

                Section::make('Prioritások és kivitelezés')
                    ->columns(2)
                    ->schema([
                        Radio::make('priority')
                            ->label('Fontosabb szempont')
                            ->options(self::PRIORITIES)
                            ->default(null),
                        TextInput::make('budget_huf')
                            ->label('Tervezett keret (Ft)')
                            ->default(null),
                        DatePicker::make('needed_by_date')
                            ->label('Legkésőbb szükséges dátum')
                            ->default(null),
                        Select::make('delivery_method')
                            ->label('Kézbesítés módja (tourguide)')
                            ->options(self::DELIVERY_METHODS)
                            ->default(null),
                        Toggle::make('wants_installation')
                            ->label('Kivitelezésre is kér ajánlatot'),
                        Toggle::make('wants_site_survey')
                            ->label('Előzetes helyszíni felmérést kér'),
                        TextInput::make('site_survey_address')
                            ->label('Helyszíni felmérés címe')
                            ->default(null),
                        Textarea::make('site_survey_notes')
                            ->label('Helyszíni felmérés — egyéb infó')
                            ->default(null)
                            ->columnSpanFull(),
                    ]),

                Section::make('Egyéb')
                    ->columns(2)
                    ->schema([
                        TextInput::make('video_url')
                            ->label('Videó link')
                            ->url()
                            ->default(null),
                        TextInput::make('preferred_timeframe')
                            ->label('Tervezett kivitelezési időszak')
                            ->default(null),
                        Textarea::make('message')
                            ->label('Megjegyzés')
                            ->default(null)
                            ->columnSpanFull(),
                        Toggle::make('gdpr_consent')
                            ->label('GDPR hozzájárulás')
                            ->required(),
                    ]),

                Section::make('Adminisztráció')
                    ->columns(2)
                    ->schema([
                        Select::make('status')
                            ->label('Státusz')
                            ->options(QuoteRequest::STATUSES)
                            ->default('new')
                            ->required(),
                        Textarea::make('internal_notes')
                            ->label('Belső jegyzet')
                            ->helperText('Csak admin számára látható.')
                            ->default(null)
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
