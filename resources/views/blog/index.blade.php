<x-layouts.app :title="'Tudástár'">
    <x-slot:schema>
        <x-schema.breadcrumbs :items="[
            ['name' => 'Főoldal', 'url' => route('home')],
            ['name' => 'Tudástár', 'url' => route('blog.index')],
        ]" />
    </x-slot:schema>

    <section class="py-20 bg-petrol-950">
        <div class="mx-auto max-w-7xl px-6 text-center">
            <h1 class="font-display text-4xl sm:text-5xl font-semibold text-cream" data-animate="split-up">Tudástár</h1>
            <p class="mt-4 text-cream/70 max-w-2xl mx-auto" data-animate="fade-up">Szakmai cikkek hangosításról, akusztikáról és rendszertervezésről.</p>
        </div>
    </section>

    <section class="py-20">
        <div class="mx-auto max-w-5xl px-6">
            @if ($posts->isEmpty())
                <p class="text-center text-ink/60">Hamarosan érkeznek az első cikkeink.</p>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8" data-animate-group>
                    @foreach ($posts as $post)
                        <a href="{{ route('blog.show', $post) }}" wire:navigate class="group block" data-animate-item>
                            @if ($post->cover_image)
                                <div class="overflow-hidden rounded-2xl aspect-[4/3] bg-petrol-100" data-tilt>
                                    <img src="{{ Storage::url($post->cover_image) }}" alt="{{ $post->title }}" class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105" loading="lazy">
                                </div>
                            @endif
                            <h2 class="mt-4 font-display text-lg font-semibold text-ink">{{ $post->title }}</h2>
                            @if ($post->excerpt)
                                <p class="mt-2 text-sm text-ink/60 line-clamp-2">{{ $post->excerpt }}</p>
                            @endif
                        </a>
                    @endforeach
                </div>

                <div class="mt-12">
                    {{ $posts->links() }}
                </div>
            @endif
        </div>
    </section>
</x-layouts.app>
