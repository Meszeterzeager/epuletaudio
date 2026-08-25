<section class="relative overflow-hidden bg-petrol-950">
    <div class="mx-auto max-w-7xl px-6 py-20 sm:py-28 grid grid-cols-1 lg:grid-cols-[minmax(0,440px)_1fr] gap-12 lg:gap-8 items-center">
        <div class="text-center lg:text-left" data-animate="fade-up">
            <p class="text-sm font-semibold uppercase tracking-widest text-gold-400">Épületaudio</p>
            <h1 class="mt-6 font-display text-4xl sm:text-5xl font-semibold text-cream leading-tight">
                Minden tér megérdemli a <span class="text-gold-400">jó</span> hangzást
            </h1>
            <p class="mt-6 text-lg text-cream/70 max-w-xl mx-auto lg:mx-0">
                Templomtól az étteremig, irodától a rendezvényteremig: épülethangosítás, konferencia-, tourguide- és mobil hangrendszerek — tervezéstől az átadásig.
            </p>
            <div class="mt-10 flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                <a href="{{ route('quote.create') }}" data-magnetic="0.35" wire:navigate class="inline-flex items-center justify-center rounded-full bg-gold-500 px-8 py-4 text-base font-semibold text-black hover:bg-gold-400 transition-colors">
                    Ajánlatot kérek
                </a>
                @if (\App\Models\Setting::getBool('references_enabled'))
                    <a href="{{ route('projects.index') }}" data-magnetic="0.35" wire:navigate class="inline-flex items-center justify-center rounded-full border border-cream/30 px-8 py-4 text-base font-semibold text-cream hover:bg-cream/10 transition-colors">
                        Referenciák megtekintése
                    </a>
                @endif
            </div>
        </div>

        <div class="relative w-full" aria-hidden="true" data-parallax-wrapper>
            <div class="absolute inset-0 bg-gradient-to-br from-gold-500/10 via-transparent to-petrol-500/10 blur-3xl" data-parallax="0.15"></div>
            @include('home.sections.hero-diagram')
        </div>
    </div>

    <div class="absolute bottom-6 inset-x-0 flex justify-center motion-safe:animate-bounce" aria-hidden="true">
        <svg class="w-6 h-6 text-cream/40" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3" /></svg>
    </div>
</section>
