<x-layouts.app
    :title="$post->title"
    :meta-description="$post->meta_description ?? $post->excerpt"
    :og-image="$post->og_image ?? $post->cover_image"
>
    <x-slot:schema>
        <x-schema.breadcrumbs :items="[
            ['name' => 'Főoldal', 'url' => route('home')],
            ['name' => 'Tudástár', 'url' => route('blog.index')],
            ['name' => $post->title, 'url' => route('blog.show', $post)],
        ]" />
    </x-slot:schema>

    <article class="py-20">
        <div class="mx-auto max-w-3xl px-6">
            <h1 class="font-display text-4xl font-semibold text-ink" data-animate="split-up">{{ $post->title }}</h1>
            @if ($post->published_at)
                <p class="mt-2 text-sm text-ink/50">{{ $post->published_at->translatedFormat('Y. F j.') }}</p>
            @endif

            @if ($post->cover_image)
                <img src="{{ Storage::url($post->cover_image) }}" alt="{{ $post->title }}" class="mt-8 rounded-2xl w-full object-cover aspect-[16/9]">
            @endif

            <div class="mt-8 prose prose-lg prose-headings:font-display">
                {!! $post->body !!}
            </div>
        </div>
    </article>

    <x-cta-band />
</x-layouts.app>
