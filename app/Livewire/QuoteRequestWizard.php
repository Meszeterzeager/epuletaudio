<?php

namespace App\Livewire;

use App\Mail\QuoteRequestConfirmation;
use App\Mail\QuoteRequestReceivedAdmin;
use App\Models\QuoteRequest;
use App\Models\Setting;
use App\Services\ImageOptimizer;
use Illuminate\Support\Facades\Mail;
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

    // 1. lépés — kapcsolattartó
    public string $name = '';

    public string $email = '';

    public string $phone = '';

    public string $company = '';

    // 2. lépés — projekt típusa és tér jellege
    public string $building_type = '';

    public array $requested_systems = [];

    public string $space_character = '';

    public ?float $width_m = null;

    public ?float $length_m = null;

    public ?float $ceiling_height_m = null;

    // 3. lépés — hangfal-preferencia, stádium, forráseszközök
    public array $speaker_preference = [];

    public string $project_stage = '';

    public array $source_equipment = [];

    public ?int $room_count = null;

    public ?int $source_count = null;

    public ?float $area_sqm = null;

    public bool $existing_system = false;

    public string $existing_system_notes = '';

    // 4. lépés — prioritások, keret, kivitelezés
    public string $priority = '';

    public string $budget_huf = '';

    public bool $wants_installation = false;

    public bool $wants_site_survey = false;

    // 5. lépés — csatolmányok
    public array $floor_plans = [];

    public array $photos = [];

    public string $video_url = '';

    // 6. lépés — egyéb / összegzés
    public string $message = '';

    public string $preferred_timeframe = '';

    public bool $gdpr_consent = false;

    public bool $submitted = false;

    protected function rulesForStep(int $step): array
    {
        return match ($step) {
            1 => [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'email', 'max:255'],
                'phone' => ['required', 'string', 'max:50'],
                'company' => ['nullable', 'string', 'max:255'],
            ],
            2 => [
                'building_type' => ['required', 'string', Rule::in(array_keys(self::BUILDING_TYPES))],
                'requested_systems' => ['required', 'array', 'min:1'],
                'requested_systems.*' => [Rule::in(array_keys(self::REQUESTED_SYSTEMS))],
                'space_character' => ['nullable', 'string', Rule::in(array_keys(self::SPACE_CHARACTERS))],
                'width_m' => ['nullable', 'numeric', 'min:0'],
                'length_m' => ['nullable', 'numeric', 'min:0'],
                'ceiling_height_m' => ['nullable', 'numeric', 'min:0'],
            ],
            3 => [
                'speaker_preference' => ['nullable', 'array'],
                'speaker_preference.*' => [Rule::in(array_keys(self::SPEAKER_PREFERENCES))],
                'project_stage' => ['nullable', 'string', Rule::in(array_keys(self::PROJECT_STAGES))],
                'source_equipment' => ['nullable', 'array'],
                'source_equipment.*' => [Rule::in(array_keys(self::SOURCE_EQUIPMENT))],
                'room_count' => ['nullable', 'integer', 'min:0'],
                'source_count' => ['nullable', 'integer', 'min:0'],
                'area_sqm' => ['nullable', 'numeric', 'min:0'],
                'existing_system' => ['boolean'],
                'existing_system_notes' => ['nullable', 'string', 'max:2000'],
            ],
            4 => [
                'priority' => ['nullable', 'string', Rule::in(array_keys(self::PRIORITIES))],
                'budget_huf' => ['nullable', 'string', 'max:100'],
                'wants_installation' => ['boolean'],
                'wants_site_survey' => ['boolean'],
            ],
            5 => [
                'floor_plans.*' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:20480'],
                'photos.*' => ['nullable', 'image', 'max:20480'],
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

    public function nextStep(): void
    {
        $this->validate($this->rulesForStep($this->step));

        if ($this->step < self::TOTAL_STEPS) {
            $this->step++;
        }
    }

    public function previousStep(): void
    {
        if ($this->step > 1) {
            $this->step--;
        }
    }

    public function goToStep(int $step): void
    {
        if ($step < $this->step) {
            $this->step = $step;
        }
    }

    public function submit(): void
    {
        $this->validate($this->rulesForStep(6));

        $quoteRequest = QuoteRequest::create([
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'company' => $this->company ?: null,
            'building_type' => $this->building_type,
            'requested_systems' => $this->requested_systems,
            'space_character' => $this->space_character ?: null,
            'width_m' => $this->width_m,
            'length_m' => $this->length_m,
            'ceiling_height_m' => $this->ceiling_height_m,
            'speaker_preference' => $this->speaker_preference,
            'project_stage' => $this->project_stage ?: null,
            'source_equipment' => $this->source_equipment,
            'room_count' => $this->room_count,
            'source_count' => $this->source_count,
            'area_sqm' => $this->area_sqm,
            'existing_system' => $this->existing_system,
            'existing_system_notes' => $this->existing_system_notes ?: null,
            'priority' => $this->priority ?: null,
            'budget_huf' => $this->budget_huf ?: null,
            'wants_installation' => $this->wants_installation,
            'wants_site_survey' => $this->wants_site_survey,
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

        if ($this->video_url) {
            $quoteRequest->files()->create(['type' => 'video', 'url' => $this->video_url]);
        }

        Mail::to($this->email)->send(new QuoteRequestConfirmation($quoteRequest));

        $notificationEmails = Setting::getEmailList('notification_email');

        if (! empty($notificationEmails)) {
            Mail::to($notificationEmails)->send(new QuoteRequestReceivedAdmin($quoteRequest));
        }

        $this->submitted = true;
    }

    public function render()
    {
        return view('livewire.quote-request-wizard');
    }
}
