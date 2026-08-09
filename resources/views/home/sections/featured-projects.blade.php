@if ($featuredProjects->isNotEmpty())
    <section class="py-24 bg-petrol-50">
        <div class="mx-auto max-w-7xl px-6">
            <div class="flex items-end justify-between gap-4 mb-8" data-animate="fade-up">
                <h2 class="font-display text-3xl font-semibold text-ink" data-animate="split-up">Kiemelt referenciák</h2>
                <a href="{{ route('projects.index') }}" wire:navigate class="text-sm font-semibold text-petrol-900 hover:underline">
                    Összes referencia &rarr;
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8" data-animate-group>
                @foreach ($featuredProjects as $project)
                    <div data-animate-item>
                        <x-project-card :project="$project" />
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endif
