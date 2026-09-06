@php
    $stepLabels = ['Kapcsolat', 'Projekt és tér', 'Rendszer és eszközök', 'Prioritások', 'Csatolmányok', 'Összegzés'];
@endphp

<div class="mx-auto max-w-3xl px-6 py-16">

    @if ($submitted)
        <div class="rounded-3xl bg-petrol-50 p-10 text-center">
            <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-petrol-900 text-cream">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
            </div>
            <h2 class="mt-6 font-display text-2xl font-semibold text-ink">Köszönjük, {{ $name }}!</h2>
            <p class="mt-3 text-ink/70">
                Megkaptuk az ajánlatkérésedet, hamarosan felvesszük veled a kapcsolatot. Erősítő emailt küldtünk a
                <strong>{{ $email }}</strong> címre.
            </p>
            <a href="{{ route('home') }}" wire:navigate class="mt-8 inline-flex items-center justify-center rounded-full bg-petrol-900 px-6 py-3 text-sm font-semibold text-cream hover:bg-petrol-700 transition-colors">
                Vissza a főoldalra
            </a>
        </div>
    @else
        {{-- Honeypot — valódi látogatók nem látják és nem töltik ki; ha egy bot
             mégis kitölti, a submit() csendben, láthatóan sikeresen lezárja a
             folyamatot anélkül, hogy bármit elmentene vagy emailt küldene. --}}
        <input
            type="text"
            wire:model="website"
            tabindex="-1"
            autocomplete="off"
            aria-hidden="true"
            style="position:absolute;left:-9999px;top:-9999px;width:1px;height:1px;opacity:0"
        />

        <div class="mb-10">
            {{-- Mobil: kompakt "X/6" jelző + haladási sáv, hogy ne kelljen oldalra görgetni --}}
            <div class="sm:hidden">
                <div class="flex items-center justify-between text-sm font-medium text-ink mb-2">
                    <span>{{ $step }}. lépés / {{ count($stepLabels) }}</span>
                    <span class="text-ink/60">{{ $stepLabels[$step - 1] }}</span>
                </div>
                <div class="h-1.5 rounded-full bg-petrol-100 overflow-hidden">
                    <div class="h-full bg-petrol-900 rounded-full transition-all duration-300" style="width: {{ ($step / count($stepLabels)) * 100 }}%"></div>
                </div>
            </div>

            {{-- sm+: teljes, számozott lépéssor --}}
            <ol class="hidden sm:flex items-center justify-between">
                @foreach ($stepLabels as $index => $label)
                    @php $n = $index + 1; @endphp
                    <li class="flex-1 flex flex-col items-center gap-2 relative">
                        @if ($index > 0)
                            <div class="absolute top-4 right-1/2 w-full h-px {{ $n <= $step ? 'bg-petrol-900' : 'bg-petrol-100' }}" style="left: calc(-50% + 1rem); right: 50%;"></div>
                        @endif
                        <button
                            type="button"
                            wire:click="goToStep({{ $n }})"
                            @class([
                                'relative z-10 flex h-8 w-8 items-center justify-center rounded-full text-sm font-semibold transition-colors',
                                'bg-petrol-900 text-cream' => $n <= $step,
                                'bg-petrol-100 text-ink/40' => $n > $step,
                            ])
                        >
                            {{ $n }}
                        </button>
                        <span class="text-xs font-medium text-center {{ $n <= $step ? 'text-ink' : 'text-ink/40' }}">
                            {{ $label }}
                        </span>
                    </li>
                @endforeach
            </ol>
        </div>

        <form wire:submit="{{ $step === 6 ? 'submit' : 'nextStep' }}" class="rounded-3xl bg-white border border-petrol-100 p-6 sm:p-10">

            {{-- 1. lépés — Kapcsolattartó adatai --}}
            @if ($step === 1)
                <h2 class="font-display text-2xl font-semibold text-ink mb-6">Kapcsolattartó adatai</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium text-ink mb-1">Név *</label>
                        <input type="text" wire:model="name" class="w-full rounded-lg border-petrol-200 bg-petrol-50/60 focus:border-petrol-500 focus:bg-white focus:ring-petrol-500 transition-colors">
                        @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-ink mb-1">Email *</label>
                        <input type="email" wire:model="email" class="w-full rounded-lg border-petrol-200 bg-petrol-50/60 focus:border-petrol-500 focus:bg-white focus:ring-petrol-500 transition-colors">
                        @error('email') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-ink mb-1">Telefonszám *</label>
                        <input
                            type="tel"
                            inputmode="tel"
                            wire:model.live.debounce.400ms="phone"
                            oninput="this.value = this.value.replace(/[^0-9+\-\s()]/g, '')"
                            placeholder="+36 30 123 4567"
                            class="w-full rounded-lg border-petrol-200 bg-petrol-50/60 focus:border-petrol-500 focus:bg-white focus:ring-petrol-500 transition-colors"
                        >
                        @error('phone') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium text-ink mb-1">Cégnév / intézmény neve</label>
                        <input type="text" wire:model="company" class="w-full rounded-lg border-petrol-200 bg-petrol-50/60 focus:border-petrol-500 focus:bg-white focus:ring-petrol-500 transition-colors">
                    </div>
                </div>
            @endif

            {{-- 2. lépés — Projekt típusa és tér jellege --}}
            @if ($step === 2)
                <h2 class="font-display text-2xl font-semibold text-ink mb-6">Projekt típusa és a tér jellege</h2>
                <div class="space-y-6">
                    @unless ($this->hasSystem('tourguide_rendszer'))
                        <div>
                            <label class="block text-sm font-medium text-ink mb-1">Épület/intézmény típusa *</label>
                            <select wire:model="building_type" class="w-full rounded-lg border-petrol-200 bg-petrol-50/60 focus:border-petrol-500 focus:bg-white focus:ring-petrol-500 transition-colors">
                                <option value="">Válassz...</option>
                                @foreach (\App\Livewire\QuoteRequestWizard::BUILDING_TYPES as $value => $label)
                                    <option value="{{ $value }}">{{ $label }}</option>
                                @endforeach
                            </select>
                            @error('building_type') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                    @endunless

                    <div>
                        <label class="block text-sm font-medium text-ink mb-2">Milyen rendszer érdekli? *</label>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            @foreach (\App\Livewire\QuoteRequestWizard::REQUESTED_SYSTEMS as $value => $label)
                                <label class="flex items-center gap-3 rounded-lg border border-petrol-200 bg-petrol-50/60 px-4 py-3 cursor-pointer hover:border-petrol-500 has-[:checked]:border-petrol-500 has-[:checked]:bg-petrol-100 transition-colors">
                                    <input type="radio" wire:model.live="requested_system" value="{{ $value }}" class="border-petrol-300 text-petrol-900 focus:ring-petrol-500">
                                    <span class="text-sm text-ink">{{ $label }}</span>
                                </label>
                            @endforeach
                        </div>
                        <p class="mt-2 text-xs text-ink/50">Ha több rendszer típusra is szükséged van, kérjük, jelezd ezt a végén, a Megjegyzés mezőben.</p>
                        @error('requested_system') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    @if ($this->hasSystem('epulethangositas') || $this->hasSystem('mobil_hangositas'))
                        <div>
                            <label class="block text-sm font-medium text-ink mb-2">A tér / zóna jellege</label>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                @foreach (\App\Livewire\QuoteRequestWizard::SPACE_CHARACTERS as $value => $label)
                                    <label class="flex items-center gap-3 rounded-lg border border-petrol-200 bg-petrol-50/60 px-4 py-3 cursor-pointer hover:border-petrol-500 has-[:checked]:border-petrol-500 has-[:checked]:bg-petrol-100 transition-colors">
                                        <input type="radio" wire:model="space_character" value="{{ $value }}" class="border-petrol-300 text-petrol-900 focus:ring-petrol-500">
                                        <span class="text-sm text-ink">{{ $label }}</span>
                                    </label>
                                @endforeach
                            </div>
                            <p class="mt-2 text-xs text-ink/50">Ez határozza meg, hogy milyen védettségű (pl. időjárásálló) eszközökre lesz szükség.</p>
                        </div>
                    @endif

                    @if ($this->hasSystem('epulethangositas'))
                        <div>
                            <label class="block text-sm font-medium text-ink mb-2">Hangrendszer típusa *</label>
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                                @foreach (\App\Livewire\QuoteRequestWizard::SOUND_SYSTEM_TYPES as $value => $label)
                                    <label class="flex items-center gap-3 rounded-lg border border-petrol-200 bg-petrol-50/60 px-4 py-3 cursor-pointer hover:border-petrol-500 has-[:checked]:border-petrol-500 has-[:checked]:bg-petrol-100 transition-colors">
                                        <input type="radio" wire:model="sound_system_type" value="{{ $value }}" class="border-petrol-300 text-petrol-900 focus:ring-petrol-500">
                                        <span class="text-sm text-ink">{{ $label }}</span>
                                    </label>
                                @endforeach
                            </div>
                            <ul class="mt-2 text-xs text-ink/50 list-disc pl-4 space-y-0.5">
                                @foreach (\App\Livewire\QuoteRequestWizard::SOUND_SYSTEM_TYPE_HINTS as $value => $hint)
                                    <li><strong>{{ \App\Livewire\QuoteRequestWizard::SOUND_SYSTEM_TYPES[$value] }}:</strong> {{ $hint }}</li>
                                @endforeach
                            </ul>
                            @error('sound_system_type') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                    @endif

                    @if ($this->hasSystem('konferenciarendszer'))
                        <div>
                            <label class="block text-sm font-medium text-ink mb-2">Használt tér típusa *</label>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                @foreach (\App\Livewire\QuoteRequestWizard::CONFERENCE_ROOM_TYPES as $value => $label)
                                    <label class="flex items-center gap-3 rounded-lg border border-petrol-200 bg-petrol-50/60 px-4 py-3 cursor-pointer hover:border-petrol-500 has-[:checked]:border-petrol-500 has-[:checked]:bg-petrol-100 transition-colors">
                                        <input type="radio" wire:model="conference_room_type" value="{{ $value }}" class="border-petrol-300 text-petrol-900 focus:ring-petrol-500">
                                        <span class="text-sm text-ink">{{ $label }}</span>
                                    </label>
                                @endforeach
                            </div>
                            @error('conference_room_type') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                    @endif

                    @if ($this->hasSystem('tourguide_rendszer'))
                        <div>
                            <label class="block text-sm font-medium text-ink mb-2">Milyen típusú vezetett túrára használná? *</label>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                @foreach (\App\Livewire\QuoteRequestWizard::TOUR_TYPES as $value => $label)
                                    <label class="flex items-center gap-3 rounded-lg border border-petrol-200 bg-petrol-50/60 px-4 py-3 cursor-pointer hover:border-petrol-500 has-[:checked]:border-petrol-500 has-[:checked]:bg-petrol-100 transition-colors">
                                        <input type="radio" wire:model="tour_type" value="{{ $value }}" class="border-petrol-300 text-petrol-900 focus:ring-petrol-500">
                                        <span class="text-sm text-ink">{{ $label }}</span>
                                    </label>
                                @endforeach
                            </div>
                            @error('tour_type') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                    @endif

                    @if ($this->hasSystem('epulethangositas'))
                        <div>
                            <label class="block text-sm font-medium text-ink mb-1">Belmagasság (m)</label>
                            <input type="number" min="0" step="0.1" wire:model="ceiling_height_m" class="w-full sm:w-1/2 rounded-lg border-petrol-200 bg-petrol-50/60 focus:border-petrol-500 focus:bg-white focus:ring-petrol-500 transition-colors">
                        </div>
                    @endif

                    @if ($this->hasSystem('epulethangositas'))
                        <div>
                            <label class="block text-sm font-medium text-ink mb-1">Becsült alapterület (m²) *</label>
                            <input type="number" min="0" step="0.1" wire:model="area_sqm" class="w-full sm:w-1/2 rounded-lg border-petrol-200 bg-petrol-50/60 focus:border-petrol-500 focus:bg-white focus:ring-petrol-500 transition-colors">
                            @error('area_sqm') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            <p class="mt-2 text-xs text-ink/50">Minél pontosabb a becslés, annál pontosabb ajánlatot tudunk adni már helyszíni felmérés nélkül is — a belmagasság elhagyható, ha nem ismert.</p>
                        </div>
                    @endif

                    @if ($this->hasSystem('mobil_hangositas'))
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-sm font-medium text-ink mb-1">Mekkora létszámot kell kihangosítani?</label>
                                <input type="number" min="0" wire:model="mobile_headcount" class="w-full rounded-lg border-petrol-200 bg-petrol-50/60 focus:border-petrol-500 focus:bg-white focus:ring-petrol-500 transition-colors">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-ink mb-1">Mekkora területen?</label>
                                <input type="text" wire:model="mobile_area_size" placeholder="pl. 150 m², kültéri" class="w-full rounded-lg border-petrol-200 bg-petrol-50/60 focus:border-petrol-500 focus:bg-white focus:ring-petrol-500 transition-colors">
                            </div>
                        </div>
                    @endif

                    @if ($this->hasSystem('konferenciarendszer'))
                        <div>
                            <label class="block text-sm font-medium text-ink mb-1">Tervezett konferencia max. létszáma</label>
                            <input type="number" min="0" wire:model="conference_moderator_count" class="w-full sm:w-1/2 rounded-lg border-petrol-200 bg-petrol-50/60 focus:border-petrol-500 focus:bg-white focus:ring-petrol-500 transition-colors">
                        </div>
                    @endif

                    @unless ($this->hasSystem('tourguide_rendszer'))
                        <div x-data="multiFileUploader('floor_plans', 5)">
                            <label class="block text-sm font-medium text-ink mb-1">Alaprajz / helyszínrajz feltöltése (PDF, JPG, PNG)</label>
                            <input type="file" multiple accept=".pdf,.jpg,.jpeg,.png" class="block w-full text-sm" @change="handleChange($event)">
                            <div x-show="uploading" class="text-sm text-petrol-500 mt-1">Feltöltés... <span x-text="progress"></span>%</div>
                            <p x-show="errorMessage" x-text="errorMessage" class="mt-1 text-sm text-red-600"></p>
                            @error('floor_plans.*') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            @error('floor_plans') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            @if (!empty($floor_plans))
                                <ul class="mt-2 text-sm text-ink/60 space-y-1">
                                    @foreach ($floor_plans as $index => $file)
                                        <li class="flex items-center gap-2">
                                            <span class="truncate">{{ $file->getClientOriginalName() }}</span>
                                            <button
                                                type="button"
                                                wire:click="removeFloorPlan({{ $index }})"
                                                @click="selected.splice({{ $index }}, 1)"
                                                class="shrink-0 text-ink/40 hover:text-red-600"
                                                aria-label="Eltávolítás"
                                            >
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                                            </button>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                            <p class="mt-2 text-xs text-ink/50">Ha van alaprajzod vagy helyszínrajzod, töltsd fel — ez pontosítja a becslést, ha a méretek nem ismertek. Egy kézzel rajzolt vázlatot is elfogadunk, ha azon jól látható a hangosítandó helyiség/terület elrendezése. Legfeljebb 5 fájl, egyenként max. 20 MB.</p>
                        </div>
                    @endunless

                    @if ($this->hasSystem('epulethangositas'))
                        <div>
                            <label class="flex items-center gap-3 cursor-pointer">
                                <input type="checkbox" wire:model.live="has_suspended_ceiling" class="rounded border-petrol-300 text-petrol-900 focus:ring-petrol-500">
                                <span class="text-sm font-medium text-ink">Van álmennyezet a térben</span>
                            </label>
                            <p class="mt-2 text-xs text-ink/50">Ez befolyásolja, hogy a hangfalak süllyeszthetők-e a mennyezetbe, vagy más rögzítési módra lesz szükség.</p>
                            @if ($has_suspended_ceiling)
                                <div class="mt-3">
                                    <label class="block text-sm font-medium text-ink mb-1">Milyen típusú álmennyezet?</label>
                                    <input type="text" wire:model="suspended_ceiling_type" placeholder="pl. gipszkarton, ásványgyapot kazetta, fém lamella" class="w-full rounded-lg border-petrol-200 bg-petrol-50/60 focus:border-petrol-500 focus:bg-white focus:ring-petrol-500 transition-colors">
                                </div>
                            @endif
                        </div>
                    @endif

                    @if ($this->hasSystem('konferenciarendszer'))
                        <div>
                            <label class="flex items-center gap-3 cursor-pointer">
                                <input type="checkbox" wire:model="has_room_sound_system" class="rounded border-petrol-300 text-petrol-900 focus:ring-petrol-500">
                                <span class="text-sm font-medium text-ink">Van a helyiségben hangrendszer, és szeretné azon keresztül használni?</span>
                            </label>
                        </div>
                    @endif
                </div>
            @endif

            {{-- 3. lépés — Rendszer és eszközök --}}
            @if ($step === 3)
                <h2 class="font-display text-2xl font-semibold text-ink mb-6">Rendszer és eszközök</h2>
                <div class="space-y-6">
                    @if ($this->hasSystem('epulethangositas'))
                        <div>
                            <label class="block text-sm font-medium text-ink mb-2">Hangsugárzók jellege</label>
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                                @foreach (\App\Livewire\QuoteRequestWizard::SPEAKER_PREFERENCES as $value => $label)
                                    <label class="flex items-center gap-3 rounded-lg border border-petrol-200 bg-petrol-50/60 px-4 py-3 cursor-pointer hover:border-petrol-500 has-[:checked]:border-petrol-500 has-[:checked]:bg-petrol-100 transition-colors">
                                        <input type="checkbox" wire:model="speaker_preference" value="{{ $value }}" class="rounded border-petrol-300 text-petrol-900 focus:ring-petrol-500">
                                        <span class="text-sm text-ink">{{ $label }}</span>
                                    </label>
                                @endforeach
                            </div>
                            <p class="mt-2 text-xs text-ink/50">Ha nem vagy biztos benne, hagyd üresen — a helyszín és a rendszertípus alapján javaslatot teszünk.</p>
                        </div>
                    @endif

                    @if ($this->hasSystem('konferenciarendszer'))
                        <div>
                            <label class="block text-sm font-medium text-ink mb-2">A rendszer jellemzői</label>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                                <div>
                                    <label class="block text-sm font-medium text-ink mb-1">Elnöki mikrofon mennyisége</label>
                                    <input type="number" min="0" wire:model="conference_president_mic_count" class="w-full rounded-lg border-petrol-200 bg-petrol-50/60 focus:border-petrol-500 focus:bg-white focus:ring-petrol-500 transition-colors">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-ink mb-1">Delegált mikrofon mennyisége</label>
                                    <input type="number" min="0" wire:model="conference_delegate_mic_count" class="w-full rounded-lg border-petrol-200 bg-petrol-50/60 focus:border-petrol-500 focus:bg-white focus:ring-petrol-500 transition-colors">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-ink mb-1">Hangrögzítés típusa</label>
                                    <select wire:model="conference_recording_type" class="w-full rounded-lg border-petrol-200 bg-petrol-50/60 focus:border-petrol-500 focus:bg-white focus:ring-petrol-500 transition-colors">
                                        <option value="">Válassz...</option>
                                        @foreach (\App\Livewire\QuoteRequestWizard::CONFERENCE_RECORDING_TYPES as $value => $label)
                                            <option value="{{ $value }}">{{ $label }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-ink mb-1">Helyiségben üzemelő hangrendszer típusa</label>
                                    <select wire:model.live="conference_room_sound_system_type" class="w-full rounded-lg border-petrol-200 bg-petrol-50/60 focus:border-petrol-500 focus:bg-white focus:ring-petrol-500 transition-colors">
                                        <option value="">Válassz...</option>
                                        @foreach (\App\Livewire\QuoteRequestWizard::CONFERENCE_ROOM_SOUND_SYSTEM_TYPES as $value => $label)
                                            <option value="{{ $value }}">{{ $label }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @if ($conference_room_sound_system_type === 'egyeb')
                                    <div class="sm:col-span-2">
                                        <label class="block text-sm font-medium text-ink mb-1">Kérjük, írja le</label>
                                        <input type="text" wire:model="conference_room_sound_system_other" class="w-full rounded-lg border-petrol-200 bg-petrol-50/60 focus:border-petrol-500 focus:bg-white focus:ring-petrol-500 transition-colors">
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif

                    @if ($this->hasSystem('mobil_hangositas'))
                        @php
                            $mobileSpeakerHints = [
                                'aktiv' => 'Beépített erősítőt tartalmaz, nem kell hozzá külön erősítő.',
                                'passziv' => 'Nincs beépített erősítője, külön erősítőt kell hozzá csatlakoztatni.',
                                'gurulos' => 'Akkumulátorral is rendelkezik, hálózati csatlakozás nélkül is használható.',
                            ];
                        @endphp
                        <div>
                            <label class="block text-sm font-medium text-ink mb-2">Milyen típusú hangsugárzót szeretne?</label>
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                                @foreach (\App\Livewire\QuoteRequestWizard::MOBILE_SPEAKER_TYPES as $value => $label)
                                    <label class="flex items-center gap-2 rounded-lg border border-petrol-200 bg-petrol-50/60 px-4 py-3 cursor-pointer hover:border-petrol-500 has-[:checked]:border-petrol-500 has-[:checked]:bg-petrol-100 transition-colors">
                                        <input type="radio" wire:model="mobile_speaker_type" value="{{ $value }}" class="border-petrol-300 text-petrol-900 focus:ring-petrol-500">
                                        <span class="text-sm text-ink">{{ $label }}</span>
                                        <span
                                            title="{{ $mobileSpeakerHints[$value] ?? '' }}"
                                            class="inline-flex h-4 w-4 items-center justify-center rounded-full bg-petrol-200 text-[10px] font-semibold text-petrol-900 cursor-help"
                                        >i</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-ink mb-2">Erősítő típusa</label>
                            <div class="grid grid-cols-1 sm:grid-cols-4 gap-3">
                                @foreach (\App\Livewire\QuoteRequestWizard::AMPLIFIER_TYPES as $value => $label)
                                    <label class="flex items-center gap-3 rounded-lg border border-petrol-200 bg-petrol-50/60 px-4 py-3 cursor-pointer hover:border-petrol-500 has-[:checked]:border-petrol-500 has-[:checked]:bg-petrol-100 transition-colors">
                                        <input type="radio" wire:model.live="amplifier_type" value="{{ $value }}" class="border-petrol-300 text-petrol-900 focus:ring-petrol-500">
                                        <span class="text-sm text-ink">{{ $label }}</span>
                                    </label>
                                @endforeach
                            </div>
                            @if ($amplifier_type === 'nem_tudom')
                                <div class="mt-3">
                                    <textarea wire:model="amplifier_type_other" rows="2" placeholder="Írja le, mire gondol, vagy mit tud a meglévő/tervezett erősítőről" class="w-full rounded-lg border-petrol-200 bg-petrol-50/60 focus:border-petrol-500 focus:bg-white focus:ring-petrol-500 transition-colors"></textarea>
                                </div>
                            @endif
                        </div>
                    @endif

                    @if ($this->hasSystem('epulethangositas') || $this->hasSystem('konferenciarendszer'))
                        <div>
                            <label class="block text-sm font-medium text-ink mb-2">
                                {{ $this->hasSystem('konferenciarendszer') && ! $this->hasSystem('epulethangositas') ? 'Milyen stádiumban van a helyiség?' : 'Milyen stádiumban van a létesítmény?' }}
                            </label>
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                                @foreach (\App\Livewire\QuoteRequestWizard::PROJECT_STAGES as $value => $label)
                                    <label class="flex items-center gap-3 rounded-lg border border-petrol-200 bg-petrol-50/60 px-4 py-3 cursor-pointer hover:border-petrol-500 has-[:checked]:border-petrol-500 has-[:checked]:bg-petrol-100 transition-colors">
                                        <input type="radio" wire:model="project_stage" value="{{ $value }}" class="border-petrol-300 text-petrol-900 focus:ring-petrol-500">
                                        <span class="text-sm text-ink">{{ $label }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    @if ($this->hasSystem('epulethangositas') || $this->hasSystem('mobil_hangositas'))
                        <div>
                            <label class="block text-sm font-medium text-ink mb-2">Milyen forráseszközöket fog használni?</label>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                @foreach (\App\Livewire\QuoteRequestWizard::SOURCE_EQUIPMENT as $value => $label)
                                    <label class="flex items-center gap-3 rounded-lg border border-petrol-200 bg-petrol-50/60 px-4 py-3 cursor-pointer hover:border-petrol-500 has-[:checked]:border-petrol-500 has-[:checked]:bg-petrol-100 transition-colors">
                                        <input type="checkbox" wire:model.live="source_equipment" value="{{ $value }}" class="rounded border-petrol-300 text-petrol-900 focus:ring-petrol-500">
                                        <span class="text-sm text-ink">{{ $label }}</span>
                                    </label>
                                @endforeach
                            </div>
                            @if (in_array('egyeb', $source_equipment, true))
                                <div class="mt-3">
                                    <input type="text" wire:model="source_equipment_other" placeholder="Kérjük, írja le" class="w-full rounded-lg border-petrol-200 bg-petrol-50/60 focus:border-petrol-500 focus:bg-white focus:ring-petrol-500 transition-colors">
                                </div>
                            @endif
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-ink mb-1">
                                {{ $this->hasSystem('mobil_hangositas') && ! $this->hasSystem('epulethangositas') ? 'Hány helyszínen / csoportnál szükséges egyszerre a hangosítás?' : 'Helyiségek / zónák száma' }}
                            </label>
                            <input type="number" min="0" wire:model="room_count" class="w-full sm:w-1/2 rounded-lg border-petrol-200 bg-petrol-50/60 focus:border-petrol-500 focus:bg-white focus:ring-petrol-500 transition-colors">
                            <p class="mt-2 text-xs text-ink/50">Ez segít felmérni a rendszer méretét és a szükséges zónavezérlés bonyolultságát.</p>
                        </div>

                        <div>
                            <label class="flex items-center gap-3 cursor-pointer">
                                <input type="checkbox" wire:model.live="existing_system" class="rounded border-petrol-300 text-petrol-900 focus:ring-petrol-500">
                                <span class="text-sm font-medium text-ink">Van már meglévő hangrendszer</span>
                            </label>
                        </div>
                        @if ($existing_system)
                            <div>
                                <label class="block text-sm font-medium text-ink mb-1">Rövid leírás a meglévő rendszerről</label>
                                <textarea wire:model="existing_system_notes" rows="3" class="w-full rounded-lg border-petrol-200 bg-petrol-50/60 focus:border-petrol-500 focus:bg-white focus:ring-petrol-500 transition-colors"></textarea>
                            </div>
                        @endif
                    @endif

                    @if ($this->hasSystem('tourguide_rendszer'))
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-sm font-medium text-ink mb-1">Csoport létszáma</label>
                                <input type="number" min="0" wire:model="group_size" class="w-full rounded-lg border-petrol-200 bg-petrol-50/60 focus:border-petrol-500 focus:bg-white focus:ring-petrol-500 transition-colors">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-ink mb-1">Túravezetők száma</label>
                                <input type="number" min="0" wire:model="tour_guide_count" class="w-full rounded-lg border-petrol-200 bg-petrol-50/60 focus:border-petrol-500 focus:bg-white focus:ring-petrol-500 transition-colors">
                            </div>
                        </div>

                        <div class="space-y-3">
                            <label class="flex items-center gap-3 cursor-pointer">
                                <input type="checkbox" wire:model="needs_transport_case" class="rounded border-petrol-300 text-petrol-900 focus:ring-petrol-500">
                                <span class="text-sm font-medium text-ink">Szükséges-e szállító / töltő koffer?</span>
                            </label>
                            <label class="flex items-center gap-3 cursor-pointer">
                                <input type="checkbox" wire:model="needs_fast_charger" class="rounded border-petrol-300 text-petrol-900 focus:ring-petrol-500">
                                <span class="text-sm font-medium text-ink">Szükséges-e gyorstöltő?</span>
                            </label>
                            <label class="flex items-center gap-3 cursor-pointer">
                                <input type="checkbox" wire:model="leads_small_groups" class="rounded border-petrol-300 text-petrol-900 focus:ring-petrol-500">
                                <span class="text-sm font-medium text-ink">Kisebb létszámú (max. 5 fő) vezetett csoportokat is vezet?</span>
                            </label>
                            <p class="text-xs text-ink/50">Max. 5 fős csoportoknál személyi beszéderősítő is elegendő lehet.</p>
                        </div>
                    @endif
                </div>
            @endif

            {{-- 4. lépés — Prioritások, keret, kivitelezés --}}
            @if ($step === 4)
                <h2 class="font-display text-2xl font-semibold text-ink mb-6">Prioritások és keret</h2>
                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-ink mb-2">Mi a fontosabb szempont Önnek?</label>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                            @foreach (\App\Livewire\QuoteRequestWizard::PRIORITIES as $value => $label)
                                <label class="flex items-center gap-3 rounded-lg border border-petrol-200 bg-petrol-50/60 px-4 py-3 cursor-pointer hover:border-petrol-500 has-[:checked]:border-petrol-500 has-[:checked]:bg-petrol-100 transition-colors">
                                    <input type="radio" wire:model="priority" value="{{ $value }}" class="border-petrol-300 text-petrol-900 focus:ring-petrol-500">
                                    <span class="text-sm text-ink">{{ $label }}</span>
                                </label>
                            @endforeach
                        </div>
                        <p class="mt-2 text-xs text-ink/50">Ez segít abban, hogy a számodra legjobb ár-érték arányú megoldást ajánljuk.</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-ink mb-1">Tervezett maximális keret (Ft)</label>
                        <input
                            type="text"
                            inputmode="numeric"
                            wire:model.live="budget_huf"
                            oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                            placeholder="pl. 1500000"
                            class="w-full sm:w-1/2 rounded-lg border-petrol-200 bg-petrol-50/60 focus:border-petrol-500 focus:bg-white focus:ring-petrol-500 transition-colors"
                        >
                        @error('budget_huf') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        <p class="mt-2 text-xs text-ink/50">Nem kötelező, de segít reális, a kereteidhez illeszkedő javaslatot összeállítani. Csak számot adj meg, Ft-ban (pl. 1500000).</p>
                    </div>

                    @if ($this->hasSystem('tourguide_rendszer'))
                        <div>
                            <label class="block text-sm font-medium text-ink mb-2">Kézbesítés módja</label>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                @foreach (\App\Livewire\QuoteRequestWizard::DELIVERY_METHODS as $value => $label)
                                    <label class="flex items-center gap-3 rounded-lg border border-petrol-200 bg-petrol-50/60 px-4 py-3 cursor-pointer hover:border-petrol-500 has-[:checked]:border-petrol-500 has-[:checked]:bg-petrol-100 transition-colors">
                                        <input type="radio" wire:model="delivery_method" value="{{ $value }}" class="border-petrol-300 text-petrol-900 focus:ring-petrol-500">
                                        <span class="text-sm text-ink">{{ $label }}</span>
                                    </label>
                                @endforeach
                            </div>
                            @error('delivery_method') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                    @else
                        <div class="space-y-3">
                            <label class="flex items-center gap-3 cursor-pointer">
                                <input type="checkbox" wire:model="wants_installation" class="rounded border-petrol-300 text-petrol-900 focus:ring-petrol-500">
                                <span class="text-sm font-medium text-ink">Kérek kivitelezésre is ajánlatot</span>
                            </label>
                            <label class="flex items-center gap-3 cursor-pointer">
                                <input type="checkbox" wire:model.live="wants_site_survey" class="rounded border-petrol-300 text-petrol-900 focus:ring-petrol-500">
                                <span class="text-sm font-medium text-ink">Kérek előzetes helyszíni felmérést</span>
                            </label>
                            @if ($wants_site_survey)
                                <div class="rounded-2xl border-2 border-gold-500 bg-gold-50/40 p-5 space-y-3">
                                    <p class="text-sm text-ink/80">A helyszíni felmérés <strong>fizetős szolgáltatás</strong>, amelyről külön ajánlatot küldünk. Ehhez kérjük az alábbi adatokat.</p>
                                    <div>
                                        <label class="block text-sm font-medium text-ink mb-1">Kapcsolattartó neve</label>
                                        <input type="text" wire:model="name" class="w-full rounded-lg border-petrol-200 bg-white focus:border-petrol-500 focus:ring-petrol-500 transition-colors">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-ink mb-1">Helyszín címe *</label>
                                        <input type="text" wire:model="site_survey_address" placeholder="Irányítószám, város, utca, házszám" class="w-full rounded-lg border-petrol-200 bg-white focus:border-petrol-500 focus:ring-petrol-500 transition-colors">
                                        @error('site_survey_address') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-ink mb-1">Telefonszám</label>
                                        <input type="tel" wire:model="phone" class="w-full rounded-lg border-petrol-200 bg-white focus:border-petrol-500 focus:ring-petrol-500 transition-colors">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-ink mb-1">Egyéb infó, ami segíthet a felmérés megszervezésében</label>
                                        <textarea wire:model="site_survey_notes" rows="3" class="w-full rounded-lg border-petrol-200 bg-white focus:border-petrol-500 focus:ring-petrol-500 transition-colors"></textarea>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endif

                    <div>
                        <p class="text-sm text-ink/80">Az ajánlat elkészítéséhez és a szállítás megfelelő ütemezéséhez szeretnénk pontosítani, hogy legkésőbb mikorra lenne szüksége az ajánlatra.</p>
                        <input type="date" wire:model="needed_by_date" class="mt-3 w-full sm:w-1/2 rounded-lg border-petrol-200 bg-petrol-50/60 focus:border-petrol-500 focus:bg-white focus:ring-petrol-500 transition-colors">
                        @error('needed_by_date') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                </div>
            @endif

            {{-- 5. lépés — Csatolmányok --}}
            @if ($step === 5)
                <h2 class="font-display text-2xl font-semibold text-ink mb-2">Csatolmányok</h2>
                <p class="text-sm text-ink/60 mb-6">A csatolmányokat azért kérjük, hogy már az ajánlatadási állapotban is a legmegfelelőbb műszaki konfigurációt tudjuk összeállítani. Amennyiben ez alapján nem tudunk pontos ajánlatot adni, felvesszük Önnel a kapcsolatot.</p>
                <div class="space-y-6">
                    <div x-data="multiFileUploader('photos', 20)">
                        <label class="block text-sm font-medium text-ink mb-1">Fotók a helyszínről</label>
                        <input type="file" multiple accept="image/*" class="block w-full text-sm" @change="handleChange($event)">
                        <div x-show="uploading" class="text-sm text-petrol-500 mt-1">Feltöltés... <span x-text="progress"></span>%</div>
                        <p x-show="errorMessage" x-text="errorMessage" class="mt-1 text-sm text-red-600"></p>
                        @error('photos.*') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        @error('photos') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        @if (!empty($photos))
                            <ul class="mt-2 text-sm text-ink/60 space-y-1">
                                @foreach ($photos as $index => $file)
                                    <li class="flex items-center gap-2">
                                        <span class="truncate">{{ $file->getClientOriginalName() }}</span>
                                        <button
                                            type="button"
                                            wire:click="removePhoto({{ $index }})"
                                            @click="selected.splice({{ $index }}, 1)"
                                            class="shrink-0 text-ink/40 hover:text-red-600"
                                            aria-label="Eltávolítás"
                                        >
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                                        </button>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                        <p class="mt-2 text-xs text-ink/50">Egyszerre vagy több lépésben is feltölthetők a fotók, legfeljebb 20 db, egyenként max. 20 MB.</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-ink mb-1">Videó feltöltése</label>
                        <input type="file" wire:model="video_file" accept="video/*" class="block w-full text-sm">
                        <div wire:loading wire:target="video_file" class="text-sm text-petrol-500 mt-1">Feltöltés...</div>
                        @error('video_file') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        @if ($video_file)
                            <p class="mt-2 text-sm text-ink/60 flex items-center gap-2">
                                <span class="truncate">{{ $video_file->getClientOriginalName() }}</span>
                                <button
                                    type="button"
                                    wire:click="removeVideoFile"
                                    class="shrink-0 text-ink/40 hover:text-red-600"
                                    aria-label="Eltávolítás"
                                >
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                                </button>
                            </p>
                        @endif
                        <p class="mt-2 text-xs text-ink/50">Legfeljebb 100 MB méretű videófájl tölthető fel.</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-ink mb-1">Vagy videó link (YouTube / Drive)</label>
                        <input type="url" wire:model="video_url" placeholder="https://..." class="w-full rounded-lg border-petrol-200 bg-petrol-50/60 focus:border-petrol-500 focus:bg-white focus:ring-petrol-500 transition-colors">
                        @error('video_url') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                </div>
            @endif

            {{-- 6. lépés — Egyéb igények / összegzés --}}
            @if ($step === 6)
                <h2 class="font-display text-2xl font-semibold text-ink mb-6">Egyéb igények</h2>
                <div class="space-y-5">
                    <div>
                        <label class="block text-sm font-medium text-ink mb-1">Megjegyzés</label>
                        <textarea wire:model="message" rows="4" class="w-full rounded-lg border-petrol-200 bg-petrol-50/60 focus:border-petrol-500 focus:bg-white focus:ring-petrol-500 transition-colors"></textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-ink mb-1">Tervezett kivitelezési időszak</label>
                        <input type="text" wire:model="preferred_timeframe" placeholder="pl. 2026 Q3" class="w-full sm:w-1/2 rounded-lg border-petrol-200 bg-petrol-50/60 focus:border-petrol-500 focus:bg-white focus:ring-petrol-500 transition-colors">
                    </div>
                    <div>
                        <label class="flex items-start gap-3 cursor-pointer">
                            <input type="checkbox" wire:model="gdpr_consent" class="mt-0.5 rounded border-petrol-300 text-petrol-900 focus:ring-petrol-500">
                            <span class="text-sm text-ink">
                                Elfogadom az <a href="{{ route('legal.privacy') }}" target="_blank" class="underline hover:text-petrol-900">Adatkezelési Tájékoztatót</a> és hozzájárulok adataim kezeléséhez az árajánlatadás érdekében. *
                            </span>
                        </label>
                        @error('gdpr_consent') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                </div>
            @endif

            <div class="mt-10 flex items-center justify-between">
                @if ($step > 1)
                    <button type="button" wire:click="previousStep" class="inline-flex items-center rounded-full border border-petrol-900 px-6 py-3 text-sm font-semibold text-petrol-900 hover:bg-petrol-50 transition-colors">
                        Vissza
                    </button>
                @else
                    <span></span>
                @endif

                <button
                    type="submit"
                    wire:loading.attr="disabled"
                    wire:target="submit,nextStep"
                    class="inline-flex items-center rounded-full bg-gold-500 px-8 py-3 text-sm font-semibold text-black hover:bg-gold-400 transition-colors disabled:opacity-60"
                >
                    <span wire:loading.remove wire:target="submit,nextStep">
                        {{ $step === 6 ? 'Ajánlatkérés elküldése' : 'Következő' }}
                    </span>
                    <span wire:loading wire:target="submit,nextStep">Feldolgozás...</span>
                </button>
            </div>
        </form>
    @endif
</div>
