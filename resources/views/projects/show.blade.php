<x-layouts.app
    :title="$project->title"
    :meta-description="$project->meta_description"
    :og-image="$project->og_image"
>
    <x-slot:schema>
        <x-schema.breadcrumbs :items="[
            ['name' => 'Főoldal', 'url' => route('home')],
            ['name' => 'Referenciák', 'url' => route('projects.index')],
            ['name' => $project->title, 'url' => route('projects.show', $project)],
        ]" />
    </x-slot:schema>

    <section class="py-20 bg-petrol-950">
        <div class="mx-auto max-w-4xl px-6 text-center">
            @if ($project->solution)
                <p class="text-sm font-semibold uppercase tracking-widest text-gold-400">{{ $project->solution->industry_name }}</p>
            @endif
            <h1 class="mt-4 font-display text-4xl sm:text-5xl font-semibold text-cream" data-animate="split-up">{{ $project->title }}</h1>
            @if ($project->location)
                <p class="mt-4 text-cream/70" data-animate="fade-up">{{ $project->location }}</p>
            @endif
        </div>
    </section>

    @if ($project->images->isNotEmpty())
        <section class="py-16">
            <div class="mx-auto max-w-7xl px-6 grid grid-cols-1 sm:grid-cols-2 gap-6">
                @foreach ($project->images as $image)
                    <img
                        src="{{ Storage::url($image->path) }}"
                        alt="{{ $image->alt ?? $project->title }}"
                        class="rounded-2xl w-full h-full object-cover aspect-[4/3]"
                        loading="lazy"
                    >
                @endforeach
            </div>
        </section>
    @endif

    <section class="py-16">
        <div class="mx-auto max-w-3xl px-6 prose prose-lg prose-headings:font-display">
            @if ($project->description)
                {!! nl2br(e($project->description)) !!}
            @else
                <p class="text-ink/60">A projekt leírása hamarosan érkezik.</p>
            @endif
        </div>
    </section>

    <x-cta-band title="Hasonló projektre gondoltál?" />
</x-layouts.app>
