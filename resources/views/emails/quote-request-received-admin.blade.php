<x-mail::message>
# Új ajánlatkérés érkezett

**Kapcsolattartó:** {{ $quoteRequest->name }} ({{ $quoteRequest->email }}, {{ $quoteRequest->phone }})
@if ($quoteRequest->company)
**Cég:** {{ $quoteRequest->company }}
@endif

**Épület/intézmény típusa:** {{ \App\Livewire\QuoteRequestWizard::BUILDING_TYPES[$quoteRequest->building_type] ?? $quoteRequest->building_type }}
**Kért rendszerek:** {{ collect($quoteRequest->requested_systems)->map(fn ($s) => \App\Livewire\QuoteRequestWizard::REQUESTED_SYSTEMS[$s] ?? $s)->join(', ') }}
@if ($quoteRequest->space_character)
**Tér jellege:** {{ \App\Livewire\QuoteRequestWizard::SPACE_CHARACTERS[$quoteRequest->space_character] ?? $quoteRequest->space_character }}
@endif

@if ($quoteRequest->room_count || $quoteRequest->source_count || $quoteRequest->area_sqm || $quoteRequest->width_m || $quoteRequest->length_m || $quoteRequest->ceiling_height_m)
**Műszaki adatok:**
@if ($quoteRequest->room_count)
- Helyiségek / zónák száma: {{ $quoteRequest->room_count }}
@endif
@if ($quoteRequest->source_count)
- Hangforrások száma: {{ $quoteRequest->source_count }}
@endif
@if ($quoteRequest->area_sqm)
- Becsült alapterület: {{ $quoteRequest->area_sqm }} m²
@endif
@if ($quoteRequest->width_m || $quoteRequest->length_m)
- Méretek: {{ $quoteRequest->width_m ?? '?' }} × {{ $quoteRequest->length_m ?? '?' }} m
@endif
@if ($quoteRequest->ceiling_height_m)
- Belmagasság: {{ $quoteRequest->ceiling_height_m }} m
@endif
@endif

@if (!empty($quoteRequest->speaker_preference) || $quoteRequest->project_stage || !empty($quoteRequest->source_equipment))
**Rendszer és eszközök:**
@if (!empty($quoteRequest->speaker_preference))
- Hangsugárzó preferencia: {{ collect($quoteRequest->speaker_preference)->map(fn ($s) => \App\Livewire\QuoteRequestWizard::SPEAKER_PREFERENCES[$s] ?? $s)->join(', ') }}
@endif
@if ($quoteRequest->project_stage)
- Létesítmény stádiuma: {{ \App\Livewire\QuoteRequestWizard::PROJECT_STAGES[$quoteRequest->project_stage] ?? $quoteRequest->project_stage }}
@endif
@if (!empty($quoteRequest->source_equipment))
- Forráseszközök: {{ collect($quoteRequest->source_equipment)->map(fn ($s) => \App\Livewire\QuoteRequestWizard::SOURCE_EQUIPMENT[$s] ?? $s)->join(', ') }}
@endif
@endif

@if ($quoteRequest->existing_system)
**Van meglévő hangrendszer:** igen — {{ $quoteRequest->existing_system_notes }}
@endif

@if ($quoteRequest->priority || $quoteRequest->budget_huf)
**Prioritások:**
@if ($quoteRequest->priority)
- Fontosabb szempont: {{ \App\Livewire\QuoteRequestWizard::PRIORITIES[$quoteRequest->priority] ?? $quoteRequest->priority }}
@endif
@if ($quoteRequest->budget_huf)
- Tervezett keret: {{ $quoteRequest->budget_huf }}
@endif
@endif

@if ($quoteRequest->wants_installation || $quoteRequest->wants_site_survey)
**Kért szolgáltatások:**
@if ($quoteRequest->wants_installation)
- Kivitelezésre is kér ajánlatot
@endif
@if ($quoteRequest->wants_site_survey)
- Előzetes helyszíni felmérést kér
@endif
@endif

@if ($quoteRequest->message)
**Megjegyzés:**
{{ $quoteRequest->message }}
@endif

<x-mail::button :url="route('filament.admin.resources.quote-requests.view', $quoteRequest)">
Megnyitás az adminban
</x-mail::button>
</x-mail::message>
