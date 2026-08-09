@props(['project'])

@php $cover = $project->images->first(); @endphp

<a href="{{ route('projects.show', $project) }}" wire:navigate class="group block">
    <div class="relative overflow-hidden rounded-2xl aspect-[4/3] bg-petrol-100" data-tilt>
        @if ($cover)
            <img
                src="{{ Storage::url($cover->path) }}"
                alt="{{ $cover->alt ?? $project->title }}"
                class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105"
                loading="lazy"
            >
        @endif
    </div>
    <div class="mt-4">
        @if ($project->solution)
            <span class="text-xs font-semibold uppercase tracking-wide text-gold-500">{{ $project->solution->industry_name }}</span>
        @endif
        <h3 class="font-display text-lg font-semibold text-ink mt-1">{{ $project->title }}</h3>
        @if ($project->location)
            <p class="text-sm text-ink/60 mt-1">{{ $project->location }}</p>
        @endif
    </div>
</a>
