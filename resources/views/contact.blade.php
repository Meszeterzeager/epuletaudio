<x-layouts.app :title="'Kapcsolat'">
    @php
        $crumbs = [
            ['name' => 'Főoldal', 'url' => route('home')],
            ['name' => 'Kapcsolat', 'url' => route('contact')],
        ];
    @endphp

    <x-slot:schema>
        <x-schema.breadcrumbs :items="$crumbs" />
    </x-slot:schema>

    <section class="py-20 bg-petrol-950">
        <div class="mx-auto max-w-4xl px-6 text-center">
            <x-breadcrumbs :items="$crumbs" class="justify-center mb-4" />
            <p class="text-sm font-semibold uppercase tracking-widest text-gold-400" data-animate="fade-up">Kapcsolat</p>
            <h1 class="mt-4 font-display text-4xl sm:text-5xl font-semibold text-cream" data-animate="split-up">Írj vagy hívj minket</h1>
            <p class="mt-4 text-cream/70 max-w-2xl mx-auto" data-animate="fade-up">
                Egy gyors kérdésre e-mailben vagy telefonon is válaszolunk — ha viszont már tudod, milyen épületről és milyen rendszerről van szó, a részletes ajánlatkérő űrlapunkkal gyorsabban célba érünk.
            </p>
        </div>
    </section>

    <section class="py-20">
        <div class="mx-auto max-w-3xl px-6 grid grid-cols-1 {{ config('company.phone') ? 'sm:grid-cols-2' : 'grid-cols-1 max-w-sm' }} gap-6" data-animate-group>
            <a
                href="mailto:{{ config('company.email') }}"
                data-animate-item
                class="group flex flex-col items-center text-center gap-4 rounded-2xl bg-petrol-50 p-10 transition-colors hover:bg-petrol-100"
            >
                <span class="flex h-14 w-14 items-center justify-center rounded-full bg-petrol-900 text-cream">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                </span>
                <div>
                    <h2 class="text-sm font-semibold uppercase tracking-wide text-gold-500">Email</h2>
                    <p class="mt-2 text-lg font-semibold text-ink group-hover:underline">{{ config('company.email') }}</p>
                </div>
            </a>

            @if (config('company.phone'))
                <a
                    href="tel:{{ config('company.phone') }}"
                    data-animate-item
                    class="group flex flex-col items-center text-center gap-4 rounded-2xl bg-petrol-50 p-10 transition-colors hover:bg-petrol-100"
                >
                    <span class="flex h-14 w-14 items-center justify-center rounded-full bg-petrol-900 text-cream">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" /></svg>
                    </span>
                    <div>
                        <h2 class="text-sm font-semibold uppercase tracking-wide text-gold-500">Telefon</h2>
                        <p class="mt-2 text-lg font-semibold text-ink group-hover:underline">{{ config('company.phone') }}</p>
                    </div>
                </a>
            @endif
        </div>
    </section>

    <x-cta-band title="Inkább részletes ajánlatot kérnél?" subtitle="Töltsd ki az 5 lépéses ajánlatkérő űrlapot, és pontos, a helyszínre szabott ajánlattal jelentkezünk." />
</x-layouts.app>
