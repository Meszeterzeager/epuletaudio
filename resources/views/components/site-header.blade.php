@php
    $navLinks = [
        ['label' => 'Szolgáltatások', 'route' => 'services.index'],
        ['label' => 'Megoldások', 'route' => 'solutions.index'],
        ['label' => 'Referenciák', 'route' => 'projects.index'],
        ['label' => 'Rólunk', 'route' => 'about'],
        ['label' => 'Tudástár', 'route' => 'blog.index'],
    ];
@endphp

<header x-data="{ mobileOpen: false }" class="sticky top-0 z-40 bg-cream/95 backdrop-blur border-b border-petrol-100">
    <div class="mx-auto max-w-7xl px-6 flex items-center justify-between h-20">
        <a href="{{ route('home') }}" wire:navigate class="flex items-center gap-3">
            <img src="{{ asset('images/logo-icon.png') }}" alt="" class="h-11 w-auto">
            <span class="font-display text-2xl font-semibold text-petrol-900">Épület<span class="text-gold-500">audio</span></span>
        </a>

        <nav class="hidden lg:flex items-center gap-8">
            @foreach ($navLinks as $link)
                <a
                    href="{{ route($link['route']) }}"
                    wire:navigate
                    class="text-sm font-medium text-ink/80 hover:text-petrol-900 transition-colors {{ request()->routeIs($link['route'].'*') ? 'text-petrol-900' : '' }}"
                >
                    {{ $link['label'] }}
                </a>
            @endforeach
        </nav>

        <a
            href="{{ route('quote.create') }}"
            data-magnetic="0.25"
            wire:navigate
            class="hidden lg:inline-flex items-center rounded-full bg-petrol-900 px-5 py-2.5 text-sm font-semibold text-cream hover:bg-petrol-700 transition-colors"
        >
            Ajánlatot kérek
        </a>

        <button
            @click="mobileOpen = !mobileOpen"
            class="lg:hidden inline-flex items-center justify-center w-10 h-10 text-petrol-900"
            aria-label="Menü megnyitása"
        >
            <svg x-show="!mobileOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" /></svg>
            <svg x-show="mobileOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" x-cloak><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
        </button>
    </div>

    <div x-show="mobileOpen" x-cloak x-transition class="lg:hidden border-t border-petrol-100 bg-cream">
        <nav class="flex flex-col px-6 py-4 gap-3">
            @foreach ($navLinks as $link)
                <a href="{{ route($link['route']) }}" wire:navigate class="text-base font-medium text-ink/80 py-1">
                    {{ $link['label'] }}
                </a>
            @endforeach
            <a href="{{ route('quote.create') }}" wire:navigate class="mt-2 inline-flex items-center justify-center rounded-full bg-petrol-900 px-5 py-3 text-sm font-semibold text-cream">
                Ajánlatot kérek
            </a>
        </nav>
    </div>
</header>
