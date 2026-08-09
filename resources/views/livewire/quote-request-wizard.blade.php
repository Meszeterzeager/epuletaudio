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
        <div class="mb-10 overflow-x-auto">
            <ol class="flex items-center justify-between min-w-[560px] sm:min-w-0">
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
                        <input type="text" wire:model="name" class="w-full rounded-lg border-petrol-100 focus:border-petrol-500 focus:ring-petrol-500">
                        @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-ink mb-1">Email *</label>
                        <input type="email" wire:model="email" class="w-full rounded-lg border-petrol-100 focus:border-petrol-500 focus:ring-petrol-500">
                        @error('email') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-ink mb-1">Telefonszám *</label>
                        <input type="tel" wire:model="phone" class="w-full rounded-lg border-petrol-100 focus:border-petrol-500 focus:ring-petrol-500">
                        @error('phone') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium text-ink mb-1">Cégnév / intézmény neve</label>
                        <input type="text" wire:model="company" class="w-full rounded-lg border-petrol-100 focus:border-petrol-500 focus:ring-petrol-500">
                    </div>
                </div>
            @endif

            {{-- 2. lépés — Projekt típusa és tér jellege --}}
            @if ($step === 2)
                <h2 class="font-display text-2xl font-semibold text-ink mb-6">Projekt típusa és a tér jellege</h2>
                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-ink mb-1">Épület/intézmény típusa *</label>
                        <select wire:model="building_type" class="w-full rounded-lg border-petrol-100 focus:border-petrol-500 focus:ring-petrol-500">
                            <option value="">Válassz...</option>
                            @foreach (\App\Livewire\QuoteRequestWizard::BUILDING_TYPES as $value => $label)
                                <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('building_type') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-ink mb-2">Milyen rendszer(ek) érdekli? *</label>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            @foreach (\App\Livewire\QuoteRequestWizard::REQUESTED_SYSTEMS as $value => $label)
                                <label class="flex items-center gap-3 rounded-lg border border-petrol-100 px-4 py-3 cursor-pointer hover:border-petrol-500 transition-colors">
                                    <input type="checkbox" wire:model="requested_systems" value="{{ $value }}" class="rounded border-petrol-300 text-petrol-900 focus:ring-petrol-500">
                                    <span class="text-sm text-ink">{{ $label }}</span>
                                </label>
                            @endforeach
                        </div>
                        @error('requested_systems') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-ink mb-2">A tér / zóna jellege</label>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            @foreach (\App\Livewire\QuoteRequestWizard::SPACE_CHARACTERS as $value => $label)
                                <label class="flex items-center gap-3 rounded-lg border border-petrol-100 px-4 py-3 cursor-pointer hover:border-petrol-500 transition-colors">
                                    <input type="radio" wire:model="space_character" value="{{ $value }}" class="border-petrol-300 text-petrol-900 focus:ring-petrol-500">
                                    <span class="text-sm text-ink">{{ $label }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                        <div>
                            <label class="block text-sm font-medium text-ink mb-1">Szélesség (m)</label>
                            <input type="number" min="0" step="0.1" wire:model="width_m" class="w-full rounded-lg border-petrol-100 focus:border-petrol-500 focus:ring-petrol-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-ink mb-1">Hosszúság (m)</label>
                            <input type="number" min="0" step="0.1" wire:model="length_m" class="w-full rounded-lg border-petrol-100 focus:border-petrol-500 focus:ring-petrol-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-ink mb-1">Belmagasság (m)</label>
                            <input type="number" min="0" step="0.1" wire:model="ceiling_height_m" class="w-full rounded-lg border-petrol-100 focus:border-petrol-500 focus:ring-petrol-500">
                        </div>
                    </div>
                </div>
            @endif

            {{-- 3. lépés — Hangfal-preferencia, stádium, forráseszközök --}}
            @if ($step === 3)
                <h2 class="font-display text-2xl font-semibold text-ink mb-6">Rendszer és eszközök</h2>
                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-ink mb-2">Hangsugárzók jellege</label>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                            @foreach (\App\Livewire\QuoteRequestWizard::SPEAKER_PREFERENCES as $value => $label)
                                <label class="flex items-center gap-3 rounded-lg border border-petrol-100 px-4 py-3 cursor-pointer hover:border-petrol-500 transition-colors">
                                    <input type="checkbox" wire:model="speaker_preference" value="{{ $value }}" class="rounded border-petrol-300 text-petrol-900 focus:ring-petrol-500">
                                    <span class="text-sm text-ink">{{ $label }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-ink mb-2">Milyen stádiumban van a létesítmény?</label>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                            @foreach (\App\Livewire\QuoteRequestWizard::PROJECT_STAGES as $value => $label)
                                <label class="flex items-center gap-3 rounded-lg border border-petrol-100 px-4 py-3 cursor-pointer hover:border-petrol-500 transition-colors">
                                    <input type="radio" wire:model="project_stage" value="{{ $value }}" class="border-petrol-300 text-petrol-900 focus:ring-petrol-500">
                                    <span class="text-sm text-ink">{{ $label }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-ink mb-2">Milyen forráseszközöket fog használni?</label>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            @foreach (\App\Livewire\QuoteRequestWizard::SOURCE_EQUIPMENT as $value => $label)
                                <label class="flex items-center gap-3 rounded-lg border border-petrol-100 px-4 py-3 cursor-pointer hover:border-petrol-500 transition-colors">
                                    <input type="checkbox" wire:model="source_equipment" value="{{ $value }}" class="rounded border-petrol-300 text-petrol-900 focus:ring-petrol-500">
                                    <span class="text-sm text-ink">{{ $label }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-medium text-ink mb-1">Helyiségek / zónák száma</label>
                            <input type="number" min="0" wire:model="room_count" class="w-full rounded-lg border-petrol-100 focus:border-petrol-500 focus:ring-petrol-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-ink mb-1">Hangforrások száma</label>
                            <input type="number" min="0" wire:model="source_count" class="w-full rounded-lg border-petrol-100 focus:border-petrol-500 focus:ring-petrol-500">
                        </div>
                        <div class="sm:col-span-2">
                            <label class="block text-sm font-medium text-ink mb-1">Becsült alapterület (m²)</label>
                            <input type="number" min="0" step="0.1" wire:model="area_sqm" class="w-full sm:w-1/2 rounded-lg border-petrol-100 focus:border-petrol-500 focus:ring-petrol-500">
                        </div>
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
                            <textarea wire:model="existing_system_notes" rows="3" class="w-full rounded-lg border-petrol-100 focus:border-petrol-500 focus:ring-petrol-500"></textarea>
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
                                <label class="flex items-center gap-3 rounded-lg border border-petrol-100 px-4 py-3 cursor-pointer hover:border-petrol-500 transition-colors">
                                    <input type="radio" wire:model="priority" value="{{ $value }}" class="border-petrol-300 text-petrol-900 focus:ring-petrol-500">
                                    <span class="text-sm text-ink">{{ $label }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-ink mb-1">Tervezett maximális keret (Ft)</label>
                        <input type="text" wire:model="budget_huf" placeholder="pl. 1 500 000 Ft" class="w-full sm:w-1/2 rounded-lg border-petrol-100 focus:border-petrol-500 focus:ring-petrol-500">
                    </div>

                    <div class="space-y-3">
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="checkbox" wire:model="wants_installation" class="rounded border-petrol-300 text-petrol-900 focus:ring-petrol-500">
                            <span class="text-sm font-medium text-ink">Kérek kivitelezésre is ajánlatot</span>
                        </label>
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="checkbox" wire:model="wants_site_survey" class="rounded border-petrol-300 text-petrol-900 focus:ring-petrol-500">
                            <span class="text-sm font-medium text-ink">Kérek előzetes helyszíni felmérést</span>
                        </label>
                    </div>
                </div>
            @endif

            {{-- 5. lépés — Csatolmányok --}}
            @if ($step === 5)
                <h2 class="font-display text-2xl font-semibold text-ink mb-6">Csatolmányok</h2>
                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-ink mb-1">Alaprajz (PDF, JPG, PNG)</label>
                        <input type="file" wire:model="floor_plans" multiple accept=".pdf,.jpg,.jpeg,.png" class="block w-full text-sm">
                        <div wire:loading wire:target="floor_plans" class="text-sm text-petrol-500 mt-1">Feltöltés...</div>
                        @error('floor_plans.*') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        @if (!empty($floor_plans))
                            <ul class="mt-2 text-sm text-ink/60 list-disc pl-5">
                                @foreach ($floor_plans as $file)
                                    <li>{{ $file->getClientOriginalName() }}</li>
                                @endforeach
                            </ul>
                        @endif
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-ink mb-1">Fotók a helyszínről</label>
                        <input type="file" wire:model="photos" multiple accept="image/*" class="block w-full text-sm">
                        <div wire:loading wire:target="photos" class="text-sm text-petrol-500 mt-1">Feltöltés...</div>
                        @error('photos.*') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        @if (!empty($photos))
                            <ul class="mt-2 text-sm text-ink/60 list-disc pl-5">
                                @foreach ($photos as $file)
                                    <li>{{ $file->getClientOriginalName() }}</li>
                                @endforeach
                            </ul>
                        @endif
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-ink mb-1">Videó link (YouTube / Drive)</label>
                        <input type="url" wire:model="video_url" placeholder="https://..." class="w-full rounded-lg border-petrol-100 focus:border-petrol-500 focus:ring-petrol-500">
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
                        <textarea wire:model="message" rows="4" class="w-full rounded-lg border-petrol-100 focus:border-petrol-500 focus:ring-petrol-500"></textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-ink mb-1">Tervezett kivitelezési időszak</label>
                        <input type="text" wire:model="preferred_timeframe" placeholder="pl. 2026 Q3" class="w-full sm:w-1/2 rounded-lg border-petrol-100 focus:border-petrol-500 focus:ring-petrol-500">
                    </div>
                    <div>
                        <label class="flex items-start gap-3 cursor-pointer">
                            <input type="checkbox" wire:model="gdpr_consent" class="mt-0.5 rounded border-petrol-300 text-petrol-900 focus:ring-petrol-500">
                            <span class="text-sm text-ink">
                                Hozzájárulok, hogy a megadott adataimat az ajánlatkészítés céljából kezeljék. *
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
                    class="inline-flex items-center rounded-full bg-gold-500 px-8 py-3 text-sm font-semibold text-petrol-950 hover:bg-gold-400 transition-colors disabled:opacity-60"
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
