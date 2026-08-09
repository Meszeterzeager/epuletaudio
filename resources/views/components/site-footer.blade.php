<footer class="bg-petrol-950 text-cream/90 mt-24">
    <div class="mx-auto max-w-7xl px-6 py-16 grid grid-cols-1 md:grid-cols-4 gap-10">
        <div>
            <div class="flex items-center gap-3">
                <img src="{{ asset('images/logo-icon.png') }}" alt="" class="h-10 w-auto">
                <span class="font-display text-2xl font-semibold text-cream">Épület<span class="text-gold-400">audio</span></span>
            </div>
            <p class="mt-4 text-sm text-cream/60 max-w-xs">
                Épülethangosítás, konferenciarendszerek, tourguide-rendszerek és mobil hangosítás — tervezéstől az átadásig.
            </p>
        </div>

        <div>
            <h3 class="text-sm font-semibold uppercase tracking-wide text-gold-400">Szolgáltatások</h3>
            <ul class="mt-4 space-y-2 text-sm text-cream/70">
                <li><a href="{{ route('services.index') }}" wire:navigate class="hover:text-cream">Épülethangosítás</a></li>
                <li><a href="{{ route('services.index') }}" wire:navigate class="hover:text-cream">Konferenciarendszerek</a></li>
                <li><a href="{{ route('services.index') }}" wire:navigate class="hover:text-cream">Tourguide-rendszerek</a></li>
                <li><a href="{{ route('services.index') }}" wire:navigate class="hover:text-cream">Mobil hangosítás</a></li>
            </ul>
        </div>

        <div>
            <h3 class="text-sm font-semibold uppercase tracking-wide text-gold-400">Gyors linkek</h3>
            <ul class="mt-4 space-y-2 text-sm text-cream/70">
                <li><a href="{{ route('projects.index') }}" wire:navigate class="hover:text-cream">Referenciák</a></li>
                <li><a href="{{ route('about') }}" wire:navigate class="hover:text-cream">Rólunk</a></li>
                <li><a href="{{ route('blog.index') }}" wire:navigate class="hover:text-cream">Tudástár</a></li>
                <li><a href="{{ route('contact') }}" wire:navigate class="hover:text-cream">Kapcsolat</a></li>
            </ul>
        </div>

        <div>
            <h3 class="text-sm font-semibold uppercase tracking-wide text-gold-400">Kapcsolat</h3>
            <ul class="mt-4 space-y-2 text-sm text-cream/70">
                <li><a href="mailto:{{ config('company.email') }}" class="hover:text-cream">{{ config('company.email') }}</a></li>
                @if (config('company.phone'))
                    <li><a href="tel:{{ config('company.phone') }}" class="hover:text-cream">{{ config('company.phone') }}</a></li>
                @endif
                <li>{{ config('company.address') }}</li>
            </ul>
            <a href="{{ route('quote.create') }}" wire:navigate class="mt-4 inline-flex items-center rounded-full bg-gold-500 px-5 py-2.5 text-sm font-semibold text-petrol-950 hover:bg-gold-400 transition-colors">
                Ajánlatot kérek
            </a>
        </div>
    </div>

    <div class="border-t border-cream/10 py-6 text-center text-xs text-cream/50">
        &copy; {{ now()->year }} Épületaudio. Minden jog fenntartva.
    </div>
</footer>
