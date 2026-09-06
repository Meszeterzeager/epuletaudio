@php
    $w = \App\Livewire\QuoteRequestWizard::class;
    $systems = $quoteRequest->requested_systems ?? [];
    $hasSystem = fn (string $key) => in_array($key, $systems, true);
@endphp
<x-mail::message>
# Köszönjük az ajánlatkérésedet, {{ $quoteRequest->name }}!

Megkaptuk a beadott adataidat, hamarosan felvesszük veled a kapcsolatot. Az áttekinthetőség kedvéért alább összefoglaltuk, amit megadtál.

## Kapcsolattartó
- Név: {{ $quoteRequest->name }}
- Email: {{ $quoteRequest->email }}
- Telefonszám: {{ $quoteRequest->phone }}
@if ($quoteRequest->company)
- Cégnév / intézmény: {{ $quoteRequest->company }}
@endif

## Projekt és tér
- Épület/intézmény típusa: {{ $w::BUILDING_TYPES[$quoteRequest->building_type] ?? $quoteRequest->building_type }}
- Kért rendszerek: {{ collect($systems)->map(fn ($s) => $w::REQUESTED_SYSTEMS[$s] ?? $s)->join(', ') }}
@if ($quoteRequest->space_character)
- Tér / zóna jellege: {{ $w::SPACE_CHARACTERS[$quoteRequest->space_character] ?? $quoteRequest->space_character }}
@endif
@if ($quoteRequest->sound_system_type)
- Hangrendszer típusa: {{ $w::SOUND_SYSTEM_TYPES[$quoteRequest->sound_system_type] ?? $quoteRequest->sound_system_type }}
@endif
@if ($quoteRequest->conference_room_type)
- Használt tér típusa: {{ $w::CONFERENCE_ROOM_TYPES[$quoteRequest->conference_room_type] ?? $quoteRequest->conference_room_type }}
@endif
@if ($quoteRequest->tour_type)
- Vezetett túra típusa: {{ $w::TOUR_TYPES[$quoteRequest->tour_type] ?? $quoteRequest->tour_type }}
@endif
@if ($quoteRequest->ceiling_height_m)
- Belmagasság: {{ $quoteRequest->ceiling_height_m }} m
@endif
@if ($quoteRequest->area_sqm)
- Becsült alapterület: {{ $quoteRequest->area_sqm }} m²
@endif
@if ($quoteRequest->mobile_headcount || $quoteRequest->mobile_area_size)
- Kihangosítandó létszám / terület: {{ $quoteRequest->mobile_headcount ? $quoteRequest->mobile_headcount.' fő' : '-' }} / {{ $quoteRequest->mobile_area_size ?: '-' }}
@endif
@if ($quoteRequest->conference_moderator_count)
- Konferencia moderátorok száma: {{ $quoteRequest->conference_moderator_count }}
@endif
@if ($hasSystem('epulethangositas'))
- Van álmennyezet: {{ $quoteRequest->has_suspended_ceiling ? 'igen' : 'nem' }}@if ($quoteRequest->has_suspended_ceiling && $quoteRequest->suspended_ceiling_type) ({{ $quoteRequest->suspended_ceiling_type }})@endif
@endif
@if ($hasSystem('konferenciarendszer'))
- Van hangrendszer a helyiségben, és szeretné azon keresztül használni: {{ $quoteRequest->has_room_sound_system ? 'igen' : 'nem' }}
@endif

## Rendszer és eszközök
@if (!empty($quoteRequest->speaker_preference))
- Hangsugárzók jellege: {{ collect($quoteRequest->speaker_preference)->map(fn ($s) => $w::SPEAKER_PREFERENCES[$s] ?? $s)->join(', ') }}
@endif
@if (!empty($quoteRequest->mobile_speaker_type))
- Hangsugárzók jellege: {{ collect($quoteRequest->mobile_speaker_type)->map(fn ($s) => $w::MOBILE_SPEAKER_TYPES[$s] ?? $s)->join(', ') }}
@endif
@if ($quoteRequest->amplifier_type)
- Erősítő típusa: {{ $w::AMPLIFIER_TYPES[$quoteRequest->amplifier_type] ?? $quoteRequest->amplifier_type }}
@endif
@if ($quoteRequest->conference_president_mic_count || $quoteRequest->conference_delegate_mic_count)
- Elnöki / delegált mikrofonok száma: {{ $quoteRequest->conference_president_mic_count ?? 0 }} / {{ $quoteRequest->conference_delegate_mic_count ?? 0 }}
@endif
@if ($quoteRequest->conference_recording_type)
- Hangrögzítés típusa: {{ $w::CONFERENCE_RECORDING_TYPES[$quoteRequest->conference_recording_type] ?? $quoteRequest->conference_recording_type }}
@endif
@if ($quoteRequest->conference_room_sound_system_type)
- Helyiségben üzemelő hangrendszer típusa: {{ $w::CONFERENCE_ROOM_SOUND_SYSTEM_TYPES[$quoteRequest->conference_room_sound_system_type] ?? $quoteRequest->conference_room_sound_system_type }}@if ($quoteRequest->conference_room_sound_system_other) ({{ $quoteRequest->conference_room_sound_system_other }})@endif
@endif
@if ($quoteRequest->project_stage)
- Stádium: {{ $w::PROJECT_STAGES[$quoteRequest->project_stage] ?? $quoteRequest->project_stage }}
@endif
@if (!empty($quoteRequest->source_equipment))
- Forráseszközök: {{ collect($quoteRequest->source_equipment)->map(fn ($s) => $w::SOURCE_EQUIPMENT[$s] ?? $s)->join(', ') }}@if ($quoteRequest->source_equipment_other) ({{ $quoteRequest->source_equipment_other }})@endif
@endif
@if ($quoteRequest->room_count)
- Helyiségek / zónák (vagy helyszínek) száma: {{ $quoteRequest->room_count }}
@endif
@if ($hasSystem('epulethangositas') || $hasSystem('mobil_hangositas'))
- Van már meglévő hangrendszer: {{ $quoteRequest->existing_system ? 'igen' : 'nem' }}@if ($quoteRequest->existing_system && $quoteRequest->existing_system_notes) — {{ $quoteRequest->existing_system_notes }}@endif
@endif
@if ($quoteRequest->group_size || $quoteRequest->tour_guide_count)
- Csoport létszáma / túravezetők száma: {{ $quoteRequest->group_size ?? '-' }} / {{ $quoteRequest->tour_guide_count ?? '-' }}
@endif
@if ($hasSystem('tourguide_rendszer'))
- Szállító/töltő koffer szükséges: {{ $quoteRequest->needs_transport_case ? 'igen' : 'nem' }}
- Gyorstöltő szükséges: {{ $quoteRequest->needs_fast_charger ? 'igen' : 'nem' }}
- Kisebb létszámú csoportokat is vezet: {{ $quoteRequest->leads_small_groups ? 'igen' : 'nem' }}
@endif

## Prioritások
@if ($quoteRequest->priority)
- Fontosabb szempont: {{ $w::PRIORITIES[$quoteRequest->priority] ?? $quoteRequest->priority }}
@endif
@if ($quoteRequest->budget_huf)
- Tervezett keret: {{ $quoteRequest->budget_huf }}
@endif
@if ($quoteRequest->delivery_method)
- Kézbesítés módja: {{ $w::DELIVERY_METHODS[$quoteRequest->delivery_method] ?? $quoteRequest->delivery_method }}
@else
- Kivitelezésre is kér ajánlatot: {{ $quoteRequest->wants_installation ? 'igen' : 'nem' }}
- Előzetes helyszíni felmérést kér: {{ $quoteRequest->wants_site_survey ? 'igen' : 'nem' }}
@endif
@if ($quoteRequest->needed_by_date)
- Legkésőbb szükséges dátum: {{ $quoteRequest->needed_by_date->format('Y.m.d.') }}
@endif

## Egyéb
@if ($quoteRequest->files()->where('type', 'floor_plan')->exists())
- Csatolt alaprajz(ok): {{ $quoteRequest->files()->where('type', 'floor_plan')->count() }} db
@endif
@if ($quoteRequest->files()->where('type', 'photo')->exists())
- Csatolt fotó(k): {{ $quoteRequest->files()->where('type', 'photo')->count() }} db
@endif
@if ($quoteRequest->files()->where('type', 'video')->exists())
- Csatolt videó
@endif
@if ($quoteRequest->preferred_timeframe)
- Tervezett kivitelezési időszak: {{ $quoteRequest->preferred_timeframe }}
@endif
@if ($quoteRequest->message)
- Megjegyzés: {{ $quoteRequest->message }}
@endif

Ha bármelyik adatot pontosítanád, vagy kérdésed van, egyszerűen válaszolj erre az emailre.

Üdvözlettel,<br>
Épületaudio csapata
</x-mail::message>
