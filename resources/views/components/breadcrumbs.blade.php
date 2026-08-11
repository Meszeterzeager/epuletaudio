@props(['items', 'dark' => true])

<nav {{ $attributes->merge(['aria-label' => 'Morzsamenü'])->class(['flex items-center gap-1.5 text-xs', 'text-cream/50' => $dark, 'text-ink/50' => ! $dark]) }}>
    @foreach ($items as $index => $item)
        @if ($index > 0)
            <span aria-hidden="true">/</span>
        @endif
        @if ($index === count($items) - 1)
            <span class="{{ $dark ? 'text-cream/80' : 'text-ink/70' }}" aria-current="page">{{ $item['name'] }}</span>
        @else
            <a href="{{ $item['url'] }}" wire:navigate class="{{ $dark ? 'hover:text-cream' : 'hover:text-ink' }} transition-colors">{{ $item['name'] }}</a>
        @endif
    @endforeach
</nav>
