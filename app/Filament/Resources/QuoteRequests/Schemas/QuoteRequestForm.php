<?php

namespace App\Filament\Resources\QuoteRequests\Schemas;

use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class QuoteRequestForm
{
    public const BUILDING_TYPES = [
        'templom' => 'Templom',
        'fogaszat_rendelo' => 'Fogászat / rendelő',
        'kavezo_vendeglatas' => 'Kávézó / vendéglátás',
        'iroda' => 'Iroda',
        'oktatasi_intezmeny' => 'Oktatási intézmény',
        'kozulet' => 'Egyéb közület',
        'maganszemely' => 'Magánszemély',
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
        'telepitett_mikrofon' => 'Telepített mikrofon',
        'vezetekes_mikrofon' => 'Vezetékes mikrofonok',
        'vezetek_nelkuli_mikrofon' => 'Vezeték nélküli mikrofonok',
        'halozati_lejatszo' => 'Hálózati lejátszó',
        'bluetooth' => 'Bluetooth vétel',
        'cd_lejatszo' => 'CD lejátszó',
        'radio' => 'Rádió',
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
                            ->required()
                            ->columnSpanFull(),
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
                    ]),

                Section::make('Rendszer és eszközök')
                    ->columns(2)
                    ->schema([
                        CheckboxList::make('speaker_preference')
                            ->label('Hangsugárzók jellege')
                            ->options(self::SPEAKER_PREFERENCES)
                            ->columnSpanFull(),
                        Select::make('project_stage')
                            ->label('Létesítmény stádiuma')
                            ->options(self::PROJECT_STAGES)
                            ->default(null),
                        CheckboxList::make('source_equipment')
                            ->label('Forráseszközök')
                            ->options(self::SOURCE_EQUIPMENT)
                            ->columnSpanFull(),
                        TextInput::make('room_count')
                            ->label('Helyiségek / zónák száma')
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
                        Toggle::make('wants_installation')
                            ->label('Kivitelezésre is kér ajánlatot'),
                        Toggle::make('wants_site_survey')
                            ->label('Előzetes helyszíni felmérést kér'),
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
                            ->options([
                                'new' => 'Új',
                                'contacted' => 'Kapcsolatba léptünk',
                                'quoted' => 'Ajánlat kiküldve',
                                'closed' => 'Lezárva',
                            ])
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
