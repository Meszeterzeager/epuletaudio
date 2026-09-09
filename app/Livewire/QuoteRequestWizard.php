<?php

namespace App\Livewire;

use App\Mail\QuoteRequestConfirmation;
use App\Mail\QuoteRequestReceivedAdmin;
use App\Models\QuoteRequest;
use App\Models\Setting;
use App\Services\ImageOptimizer;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;

class QuoteRequestWizard extends Component
{
    use WithFileUploads;

    public int $step = 1;

    public const TOTAL_STEPS = 6;

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

    public const SOUND_SYSTEM_TYPES = [
        'egyszeru' => 'Egyszerű hangrendszer',
        'zonas' => 'Zónás hangrendszer',
        'matrix' => 'Mátrix hangrendszer',
    ];

    public const SOUND_SYSTEM_TYPE_HINTS = [
        'egyszeru' => '1 hangforrás mindenhová szól.',
        'zonas' => '1 hangforrás több helyiségbe szólhat, különböző hangerőn.',
        'matrix' => 'Több hangforrás szólhat, egymástól függetlenül, több helyre.',
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
        'kulfoldi_utazas' => 'Külföldi utazás (utazási iroda)',
        'belfoldi_utazas' => 'Belföldi utazás (utazási iroda)',
        'muzeum' => 'Múzeum',
        'gyartura' => 'Gyártúra / gyárlátogatás',
        'egyeb_szabadteri' => 'Egyéb szabadtéri rendezvény',
    ];

    public const DELIVERY_METHODS = [
        'futarszolgalat' => 'Futárszolgálattal kérem',
        'szemelyes_kiszallitas' => 'Személyes kiszállítást kérek Pest megyén belül (felárral)',
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

    // 1. lépés — kapcsolattartó
    public string $name = '';

    public string $email = '';

    public string $phone = '';

    public string $company = '';

    // 2. lépés — projekt típusa és tér jellege
    public string $building_type = '';

    public string $requested_system = '';

    public string $space_character = '';

    public string $sound_system_type = '';

    public string $conference_room_type = '';

    public ?int $conference_moderator_count = null;

    public string $tour_type = '';

    public ?float $ceiling_height_m = null;

    public bool $has_suspended_ceiling = false;

    public string $suspended_ceiling_type = '';

    public bool $has_room_sound_system = false;

    public ?float $area_sqm = null;

    public ?int $mobile_headcount = null;

    public string $mobile_area_size = '';

    public array $floor_plans = [];

    // 3. lépés — rendszer és eszközök
    public array $speaker_preference = [];

    public string $project_stage = '';

    public array $source_equipment = [];

    public string $source_equipment_other = '';

    public ?int $room_count = null;

    public bool $existing_system = false;

    public string $existing_system_notes = '';

    public ?int $conference_president_mic_count = null;

    public ?int $conference_delegate_mic_count = null;

    public string $conference_recording_type = '';

    public string $conference_room_sound_system_type = '';

    public string $conference_room_sound_system_other = '';

    public string $mobile_speaker_type = '';

    public string $amplifier_type = '';

    public string $amplifier_type_other = '';

    public ?int $group_size = null;

    public ?int $tour_guide_count = null;

    public bool $needs_transport_case = false;

    public bool $needs_fast_charger = false;

    public bool $leads_small_groups = false;

    // 4. lépés — prioritások, keret, kivitelezés
    public string $priority = '';

    public string $budget_huf = '';

    public bool $wants_installation = false;

    public bool $wants_site_survey = false;

    public string $site_survey_address = '';

    public string $site_survey_notes = '';

    public string $delivery_method = '';

    public ?string $needed_by_date = null;

    // 5. lépés — csatolmányok
    public array $photos = [];

    public $video_file = null;

    public string $video_url = '';

    // 6. lépés — egyéb / összegzés
    public string $message = '';

    public string $preferred_timeframe = '';

    public bool $gdpr_consent = false;

    public bool $submitted = false;

    /**
     * Honeypot mező — valódi látogatók nem látják (CSS-sel elrejtve), csak a
     * formákat automatikusan kitöltő botok. Ha nem üres, spam-gyanús
     * beküldésnek tekintjük.
     */
    public string $website = '';

    public function hasSystem(string $key): bool
    {
        return $this->requested_system === $key;
    }

    public function removeFloorPlan(int $index): void
    {
        unset($this->floor_plans[$index]);
        $this->floor_plans = array_values($this->floor_plans);
    }

    public function removePhoto(int $index): void
    {
        unset($this->photos[$index]);
        $this->photos = array_values($this->photos);
    }

    public function removeVideoFile(): void
    {
        $this->video_file = null;
    }

    public function updatedBudgetHuf(string $value): void
    {
        // Csak számjegyeket engedünk — a Ft/pont/szóköz formázást mi tesszük
        // hozzá, hogy egységes maradjon az admin felületen és az emailekben.
        $this->budget_huf = preg_replace('/[^0-9]/', '', $value) ?? '';
    }

    public function updatedPhone(string $value): void
    {
        // Csak szabványos telefonszám-karakterek maradhatnak — számjegyek,
        // szóköz és a +()- elválasztók; betűket eleve nem engedünk begépelni.
        $this->phone = preg_replace('/[^0-9+\-\s()]/', '', $value) ?? '';
    }

    protected function rulesForStep(int $step): array
    {
        return match ($step) {
            1 => [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'email', 'max:255'],
                'phone' => [
                    'required',
                    'string',
                    'max:50',
                    'regex:/^[0-9+\-\s()]{6,50}$/',
                    function (string $attribute, mixed $value, \Closure $fail): void {
                        if (preg_match_all('/\d/', (string) $value) < 6) {
                            $fail('Kérjük, adj meg egy érvényes, legalább 6 számjegyből álló telefonszámot.');
                        }
                    },
                ],
                'company' => ['nullable', 'string', 'max:255'],
            ],
            2 => [
                'building_type' => [
                    Rule::requiredIf(fn () => ! $this->hasSystem('tourguide_rendszer')),
                    'nullable', 'string', Rule::in(array_keys(self::BUILDING_TYPES)),
                ],
                'requested_system' => ['required', 'string', Rule::in(array_keys(self::REQUESTED_SYSTEMS))],
                'space_character' => ['nullable', 'string', Rule::in(array_keys(self::SPACE_CHARACTERS))],
                'sound_system_type' => [
                    Rule::requiredIf(fn () => $this->hasSystem('epulethangositas')),
                    'nullable', 'string', Rule::in(array_keys(self::SOUND_SYSTEM_TYPES)),
                ],
                'conference_room_type' => [
                    Rule::requiredIf(fn () => $this->hasSystem('konferenciarendszer')),
                    'nullable', 'string', Rule::in(array_keys(self::CONFERENCE_ROOM_TYPES)),
                ],
                'conference_moderator_count' => ['nullable', 'integer', 'min:0'],
                'tour_type' => [
                    Rule::requiredIf(fn () => $this->hasSystem('tourguide_rendszer')),
                    'nullable', 'string', Rule::in(array_keys(self::TOUR_TYPES)),
                ],
                'ceiling_height_m' => ['nullable', 'numeric', 'min:0'],
                'has_suspended_ceiling' => ['boolean'],
                'suspended_ceiling_type' => ['nullable', 'string', 'max:255'],
                'has_room_sound_system' => ['boolean'],
                'area_sqm' => [
                    Rule::requiredIf(fn () => $this->hasSystem('epulethangositas')),
                    'nullable', 'numeric', 'min:0',
                ],
                'mobile_headcount' => ['nullable', 'integer', 'min:0'],
                'mobile_area_size' => ['nullable', 'string', 'max:255'],
                'floor_plans' => ['array', 'max:5'],
                'floor_plans.*' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:20480'],
            ],
            3 => [
                'speaker_preference' => ['nullable', 'array'],
                'speaker_preference.*' => [Rule::in(array_keys(self::SPEAKER_PREFERENCES))],
                'project_stage' => ['nullable', 'string', Rule::in(array_keys(self::PROJECT_STAGES))],
                'source_equipment' => ['nullable', 'array'],
                'source_equipment.*' => [Rule::in(array_keys(self::SOURCE_EQUIPMENT))],
                'source_equipment_other' => ['nullable', 'string', 'max:255'],
                'room_count' => ['nullable', 'integer', 'min:0'],
                'existing_system' => ['boolean'],
                'existing_system_notes' => ['nullable', 'string', 'max:2000'],
                'conference_president_mic_count' => ['nullable', 'integer', 'min:0'],
                'conference_delegate_mic_count' => ['nullable', 'integer', 'min:0'],
                'conference_recording_type' => ['nullable', 'string', Rule::in(array_keys(self::CONFERENCE_RECORDING_TYPES))],
                'conference_room_sound_system_type' => ['nullable', 'string', Rule::in(array_keys(self::CONFERENCE_ROOM_SOUND_SYSTEM_TYPES))],
                'conference_room_sound_system_other' => ['nullable', 'string', 'max:255'],
                'mobile_speaker_type' => ['nullable', 'string', Rule::in(array_keys(self::MOBILE_SPEAKER_TYPES))],
                'amplifier_type' => ['nullable', 'string', Rule::in(array_keys(self::AMPLIFIER_TYPES))],
                'amplifier_type_other' => ['nullable', 'string', 'max:500'],
                'group_size' => ['nullable', 'integer', 'min:0'],
                'tour_guide_count' => ['nullable', 'integer', 'min:0'],
                'needs_transport_case' => ['boolean'],
                'needs_fast_charger' => ['boolean'],
                'leads_small_groups' => ['boolean'],
            ],
            4 => [
                'priority' => ['nullable', 'string', Rule::in(array_keys(self::PRIORITIES))],
                'budget_huf' => ['nullable', 'string', 'max:20', 'regex:/^[0-9]*$/'],
                'wants_installation' => ['boolean'],
                'wants_site_survey' => ['boolean'],
                'site_survey_address' => [
                    Rule::requiredIf(fn () => $this->wants_site_survey),
                    'nullable', 'string', 'max:255',
                ],
                'site_survey_notes' => ['nullable', 'string', 'max:1000'],
                'delivery_method' => [
                    Rule::requiredIf(fn () => $this->hasSystem('tourguide_rendszer')),
                    'nullable', 'string', Rule::in(array_keys(self::DELIVERY_METHODS)),
                ],
                'needed_by_date' => ['nullable', 'date'],
            ],
            5 => [
                'photos' => ['array', 'max:20'],
                'photos.*' => ['nullable', 'image', 'max:20480'],
                'video_file' => ['nullable', 'file', 'mimes:mp4,mov,webm,mkv,avi,m4v', 'max:102400'],
                'video_url' => ['nullable', 'url', 'max:500'],
            ],
            6 => [
                'message' => ['nullable', 'string', 'max:3000'],
                'preferred_timeframe' => ['nullable', 'string', 'max:255'],
                'gdpr_consent' => ['accepted'],
            ],
            default => [],
        };
    }

    protected function messages(): array
    {
        return [
            'name.required' => 'A név megadása kötelező.',
            'email.required' => 'Az e-mail cím megadása kötelező.',
            'email.email' => 'Kérjük, érvényes e-mail címet adj meg.',
            'phone.required' => 'A telefonszám megadása kötelező.',
            'phone.regex' => 'Kérjük, csak számokat és a szokásos telefonszám-jeleket (+, -, szóköz, zárójel) add meg.',
            'building_type.required' => 'Kérjük, válaszd ki az épület/intézmény típusát.',
            'requested_system.required' => 'Válassz egy rendszert.',
            'sound_system_type.required' => 'Kérjük, válaszd ki a hangrendszer típusát.',
            'conference_room_type.required' => 'Kérjük, válaszd ki a használt tér típusát.',
            'tour_type.required' => 'Kérjük, válaszd ki, milyen típusú vezetett túrára használnád.',
            'area_sqm.required' => 'Az alapterület megadása kötelező.',
            'delivery_method.required' => 'Kérjük, válaszd ki a kézbesítés módját.',
            'floor_plans.max' => 'Legfeljebb 5 alaprajz-fájlt tölthetsz fel.',
            'photos.max' => 'Legfeljebb 20 fotót tölthetsz fel.',
            'video_file.max' => 'A videó mérete legfeljebb 100 MB lehet.',
            'budget_huf.regex' => 'A tervezett keretet kérjük, csak számmal add meg.',
            'gdpr_consent.accepted' => 'Az Adatkezelési Tájékoztató elfogadása kötelező a folytatáshoz.',
        ];
    }

    public function nextStep(): void
    {
        $this->validate($this->rulesForStep($this->step));

        $next = $this->step + 1;

        // A tour guide rendszerhez nincs értelme csatolmányt kérni (alaprajz,
        // fotó, videó) — ez a lépés ilyenkor kimarad a folyamatból.
        if ($next === 5 && $this->hasSystem('tourguide_rendszer')) {
            $next = 6;
        }

        if ($next <= self::TOTAL_STEPS) {
            $this->step = $next;
        }
    }

    public function previousStep(): void
    {
        $prev = $this->step - 1;

        if ($prev === 5 && $this->hasSystem('tourguide_rendszer')) {
            $prev = 4;
        }

        if ($prev >= 1) {
            $this->step = $prev;
        }
    }

    public function goToStep(int $step): void
    {
        if ($step === 5 && $this->hasSystem('tourguide_rendszer')) {
            $step = 4;
        }

        if ($step < $this->step) {
            $this->step = $step;
        }
    }

    public function submit(): void
    {
        // Ha a honeypot mező ki van töltve, szinte biztosan bot küldte —
        // a felhasználó felé (a botnak) sikeresnek mutatjuk, de valójában
        // semmit nem mentünk el és nem küldünk emailt.
        if ($this->website !== '') {
            $this->submitted = true;

            return;
        }

        $rateLimitKey = 'quote-request-submit:'.request()->ip();

        if (RateLimiter::tooManyAttempts($rateLimitKey, maxAttempts: 3)) {
            $this->addError('gdpr_consent', 'Túl sok ajánlatkérést küldtél rövid idő alatt. Kérjük, próbáld újra később, vagy írj nekünk emailben.');

            return;
        }

        // A felület lépésenként ellenőriz, de a Livewire művelet közvetlen
        // meghívásával a korábbi lépések átugorhatók lennének. Beküldéskor
        // ezért minden mezőt újra validálunk.
        $this->validate(array_merge(
            $this->rulesForStep(1),
            $this->rulesForStep(2),
            $this->rulesForStep(3),
            $this->rulesForStep(4),
            $this->rulesForStep(5),
            $this->rulesForStep(6),
        ));

        RateLimiter::hit($rateLimitKey, decaySeconds: 900);

        $isTourGuide = $this->hasSystem('tourguide_rendszer');

        $quoteRequest = QuoteRequest::create([
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'company' => $this->company ?: null,
            'building_type' => $this->building_type,
            'requested_systems' => $this->requested_system ? [$this->requested_system] : [],
            'space_character' => $this->space_character ?: null,
            'sound_system_type' => $this->sound_system_type ?: null,
            'conference_room_type' => $this->conference_room_type ?: null,
            'conference_moderator_count' => $this->conference_moderator_count,
            'tour_type' => $this->tour_type ?: null,
            'ceiling_height_m' => $this->ceiling_height_m,
            'has_suspended_ceiling' => $this->has_suspended_ceiling,
            'suspended_ceiling_type' => $this->has_suspended_ceiling ? ($this->suspended_ceiling_type ?: null) : null,
            'has_room_sound_system' => $this->has_room_sound_system,
            'area_sqm' => $this->area_sqm,
            'mobile_headcount' => $this->mobile_headcount,
            'mobile_area_size' => $this->mobile_area_size ?: null,
            'speaker_preference' => $this->speaker_preference,
            'project_stage' => $this->project_stage ?: null,
            'source_equipment' => $this->source_equipment,
            'source_equipment_other' => in_array('egyeb', $this->source_equipment, true) ? ($this->source_equipment_other ?: null) : null,
            'room_count' => $this->room_count,
            'existing_system' => $this->existing_system,
            'existing_system_notes' => $this->existing_system_notes ?: null,
            'conference_president_mic_count' => $this->conference_president_mic_count,
            'conference_delegate_mic_count' => $this->conference_delegate_mic_count,
            'conference_recording_type' => $this->conference_recording_type ?: null,
            'conference_room_sound_system_type' => $this->conference_room_sound_system_type ?: null,
            'conference_room_sound_system_other' => $this->conference_room_sound_system_type === 'egyeb' ? ($this->conference_room_sound_system_other ?: null) : null,
            'mobile_speaker_type' => $this->mobile_speaker_type ? [$this->mobile_speaker_type] : [],
            'amplifier_type' => $this->amplifier_type ?: null,
            'amplifier_type_other' => $this->amplifier_type === 'nem_tudom' ? ($this->amplifier_type_other ?: null) : null,
            'group_size' => $this->group_size,
            'tour_guide_count' => $this->tour_guide_count,
            'needs_transport_case' => $this->needs_transport_case,
            'needs_fast_charger' => $this->needs_fast_charger,
            'leads_small_groups' => $this->leads_small_groups,
            'priority' => $this->priority ?: null,
            'budget_huf' => $this->budget_huf ?: null,
            'wants_installation' => $isTourGuide ? false : $this->wants_installation,
            'wants_site_survey' => $isTourGuide ? false : $this->wants_site_survey,
            'site_survey_address' => $this->wants_site_survey ? ($this->site_survey_address ?: null) : null,
            'site_survey_notes' => $this->wants_site_survey ? ($this->site_survey_notes ?: null) : null,
            'delivery_method' => $isTourGuide ? ($this->delivery_method ?: null) : null,
            'needed_by_date' => $this->needed_by_date ?: null,
            'video_url' => $this->video_url ?: null,
            'message' => $this->message ?: null,
            'preferred_timeframe' => $this->preferred_timeframe ?: null,
            'gdpr_consent' => $this->gdpr_consent,
        ]);

        foreach ($this->floor_plans as $floorPlan) {
            $path = str_starts_with($floorPlan->getMimeType() ?? '', 'image/')
                ? ImageOptimizer::store($floorPlan, 'quote-requests/floor-plans', 'local', 2400, 2400)
                : $floorPlan->store('quote-requests/floor-plans');
            $quoteRequest->files()->create(['type' => 'floor_plan', 'path' => $path]);
        }

        foreach ($this->photos as $photo) {
            $path = ImageOptimizer::store($photo, 'quote-requests/photos', 'local');
            $quoteRequest->files()->create(['type' => 'photo', 'path' => $path]);
        }

        if ($this->video_file) {
            $path = $this->video_file->store('quote-requests/videos');
            $quoteRequest->files()->create(['type' => 'video', 'path' => $path]);
        }

        if ($this->video_url) {
            $quoteRequest->files()->create(['type' => 'video', 'url' => $this->video_url]);
        }

        Mail::to($this->email)->queue(new QuoteRequestConfirmation($quoteRequest));

        $notificationEmails = Setting::getEmailList('notification_email');

        if (! empty($notificationEmails)) {
            Mail::to($notificationEmails)->queue(new QuoteRequestReceivedAdmin($quoteRequest));
        }

        $this->submitted = true;
    }

    public function render()
    {
        return view('livewire.quote-request-wizard');
    }
}
