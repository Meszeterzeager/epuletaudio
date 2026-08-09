<section class="relative overflow-hidden bg-petrol-950">
    <div class="mx-auto max-w-7xl px-6 py-24 sm:py-32 grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-8 items-center">
        <div class="text-center lg:text-left" data-animate="fade-up">
            <p class="text-sm font-semibold uppercase tracking-widest text-gold-400">Épületaudio</p>
            <h1 class="mt-6 font-display text-4xl sm:text-6xl font-semibold text-cream leading-tight">
                Hangzás, amit <span class="text-gold-400">megéreznek</span>,<br class="hidden sm:block">
                nem csak meghallanak
            </h1>
            <p class="mt-6 text-lg text-cream/70 max-w-xl mx-auto lg:mx-0">
                Épülethangosítás, konferenciarendszerek, tourguide-rendszerek és mobil hangosítás — tervezéstől az átadásig, iparág-specifikus megoldásokkal.
            </p>
            <div class="mt-10 flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                <a href="{{ route('quote.create') }}" data-magnetic="0.35" wire:navigate class="inline-flex items-center justify-center rounded-full bg-gold-500 px-8 py-4 text-base font-semibold text-petrol-950 hover:bg-gold-400 transition-colors">
                    Ajánlatot kérek
                </a>
                <a href="{{ route('projects.index') }}" data-magnetic="0.35" wire:navigate class="inline-flex items-center justify-center rounded-full border border-cream/30 px-8 py-4 text-base font-semibold text-cream hover:bg-cream/10 transition-colors">
                    Referenciák megtekintése
                </a>
            </div>
        </div>

        <div class="relative mx-auto h-72 w-72 sm:h-96 sm:w-96" aria-hidden="true" data-parallax-wrapper>
            <div class="absolute inset-0 rounded-full bg-gradient-to-br from-gold-500/25 via-petrol-500/20 to-transparent blur-2xl" data-parallax="0.2"></div>
            <canvas id="hero-canvas" class="absolute inset-0 h-full w-full"></canvas>
        </div>
    </div>

    <div class="absolute bottom-6 inset-x-0 flex justify-center motion-safe:animate-bounce" aria-hidden="true">
        <svg class="w-6 h-6 text-cream/40" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3" /></svg>
    </div>
</section>
