@php
    $counters = [
        ['value' => 50000, 'suffix' => '+ m', 'label' => 'Befűzött és bemért 100V-os kábelhálózat'],
        ['value' => 100, 'suffix' => '+', 'label' => 'Egyedileg tervezett többzónás audio rendszer'],
        ['value' => 8, 'suffix' => ' iparág', 'label' => 'Testreszabott akusztikai és bemondó megoldás'],
    ];
@endphp

<section class="bg-petrol-50 py-20">
    <div class="mx-auto max-w-5xl px-6 grid grid-cols-1 sm:grid-cols-3 gap-10 text-center" data-animate-group>
        @foreach ($counters as $counter)
            <div
                data-animate-item
                x-data="{ shown: 0, target: {{ $counter['value'] }} }"
                x-init="
                    let observer = new IntersectionObserver((entries) => {
                        if (entries[0].isIntersecting) {
                            let start = performance.now();
                            const step = (now) => {
                                let progress = Math.min((now - start) / 1200, 1);
                                shown = Math.round(progress * target);
                                if (progress < 1) requestAnimationFrame(step);
                            };
                            requestAnimationFrame(step);
                            observer.disconnect();
                        }
                    }, { threshold: 0.4 });
                    observer.observe($el);
                "
            >
                <div class="font-display text-5xl font-semibold text-petrol-900">
                    <span x-text="shown.toLocaleString('hu-HU')"></span>{{ $counter['suffix'] }}
                </div>
                <p class="mt-2 text-ink/60">{{ $counter['label'] }}</p>
            </div>
        @endforeach
    </div>
</section>
