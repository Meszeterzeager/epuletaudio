<x-layouts.app :title="'Referenciák'">
    @php
        $crumbs = [
            ['name' => 'Főoldal', 'url' => route('home')],
            ['name' => 'Referenciák', 'url' => route('projects.index')],
        ];
    @endphp

    <x-slot:schema>
        <x-schema.breadcrumbs :items="$crumbs" />
    </x-slot:schema>

    <section class="py-20 bg-petrol-950">
        <div class="mx-auto max-w-7xl px-6 text-center">
            <x-breadcrumbs :items="$crumbs" class="justify-center mb-4" />
            <h1 class="font-display text-4xl sm:text-5xl font-semibold text-cream" data-animate="split-up">Referenciák</h1>
            <p class="mt-4 text-cream/70 max-w-2xl mx-auto" data-animate="fade-up">Megvalósult projektjeink templomokban, rendelőkben, kávézókban és intézményekben.</p>
        </div>
    </section>

    <section class="py-20">
        <div class="mx-auto max-w-7xl px-6">
            @if ($projects->isEmpty())
                <p class="text-center text-ink/60">Hamarosan bővül a referencia-galériánk.</p>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8" data-animate-group>
                    @foreach ($projects as $project)
                        <div data-animate-item>
                            <x-project-card :project="$project" />
                        </div>
                    @endforeach
                </div>

                <div class="mt-12">
                    {{ $projects->links() }}
                </div>
            @endif
        </div>
    </section>

    <x-cta-band />
</x-layouts.app>
