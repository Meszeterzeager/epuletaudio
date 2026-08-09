<x-layouts.app :title="'Kapcsolat'">
    <x-slot:schema>
        <x-schema.local-business />
        <x-schema.breadcrumbs :items="[
            ['name' => 'Főoldal', 'url' => route('home')],
            ['name' => 'Kapcsolat', 'url' => route('contact')],
        ]" />
    </x-slot:schema>

    <section class="py-20 bg-petrol-950">
        <div class="mx-auto max-w-4xl px-6 text-center">
            <h1 class="font-display text-4xl sm:text-5xl font-semibold text-cream" data-animate="split-up">Kapcsolat</h1>
            <p class="mt-4 text-cream/70 max-w-2xl mx-auto" data-animate="fade-up">Írj vagy hívj minket, illetve kérj részletes ajánlatot az űrlapunkon.</p>
        </div>
    </section>

    <section class="py-20">
        <div class="mx-auto max-w-3xl px-6 grid grid-cols-1 {{ config('company.phone') ? 'sm:grid-cols-3' : 'sm:grid-cols-2' }} gap-8 text-center">
            <div>
                <h2 class="text-sm font-semibold uppercase tracking-wide text-gold-500">Email</h2>
                <p class="mt-2 text-ink/80">
                    <a href="mailto:{{ config('company.email') }}" class="hover:underline">{{ config('company.email') }}</a>
                </p>
            </div>
            @if (config('company.phone'))
                <div>
                    <h2 class="text-sm font-semibold uppercase tracking-wide text-gold-500">Telefon</h2>
                    <p class="mt-2 text-ink/80">
                        <a href="tel:{{ config('company.phone') }}" class="hover:underline">{{ config('company.phone') }}</a>
                    </p>
                </div>
            @endif
            <div>
                <h2 class="text-sm font-semibold uppercase tracking-wide text-gold-500">Cím</h2>
                <p class="mt-2 text-ink/80">{{ config('company.address') }}</p>
            </div>
        </div>
    </section>

    <x-cta-band title="Inkább részletes ajánlatot kérnél?" />
</x-layouts.app>
