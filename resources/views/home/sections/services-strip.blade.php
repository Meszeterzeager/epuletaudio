@if ($services->isNotEmpty())
    <section class="py-24">
        <div class="mx-auto max-w-7xl px-6">
            <div class="flex items-end justify-between gap-4 mb-8" data-animate="fade-up">
                <h2 class="font-display text-3xl font-semibold text-ink" data-animate="split-up">Szolgáltatásaink</h2>
                <a href="{{ route('services.index') }}" wire:navigate class="text-sm font-semibold text-petrol-900 hover:underline">
                    Összes szolgáltatás &rarr;
                </a>
            </div>
        </div>

        <div class="mx-auto max-w-7xl px-6">
            <div
                @if ($services->count() > 3)
                    x-data="{
                        speed: 0.25,
                        targetSpeed: 0.25,
                        idleSpeed: 0.25,
                        maxSpeed: 3.5,
                        singleSetWidth: 0,
                        reducedMotion: false,
                        init() {
                            this.reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
                            this.singleSetWidth = this.$refs.track.scrollWidth / 2;
                            if (!this.reducedMotion) {
                                requestAnimationFrame(() => this.loop());
                            }
                        },
                        loop() {
                            const el = this.$refs.servicesStrip;
                            this.speed += (this.targetSpeed - this.speed) * 0.06;
                            el.scrollLeft += this.speed;
                            if (el.scrollLeft >= this.singleSetWidth) {
                                el.scrollLeft -= this.singleSetWidth;
                            } else if (el.scrollLeft <= 0) {
                                el.scrollLeft += this.singleSetWidth;
                            }
                            requestAnimationFrame(() => this.loop());
                        },
                        onMouseMove(event) {
                            const rect = this.$refs.servicesStrip.getBoundingClientRect();
                            const ratio = (event.clientX - rect.left) / rect.width;
                            const centered = Math.min(1, Math.max(-1, (ratio - 0.5) * 2));
                            this.targetSpeed = centered * this.maxSpeed;
                        },
                        onMouseLeave() {
                            this.targetSpeed = this.idleSpeed;
                        },
                    }"
                    x-init="init()"
                    @mousemove="onMouseMove($event)"
                    @mouseleave="onMouseLeave()"
                @endif
                x-ref="servicesStrip"
                class="flex overflow-x-auto pb-4 [scrollbar-width:none] [&::-webkit-scrollbar]:hidden"
                style="scroll-behavior:auto;"
                data-animate-group
            >
                <div x-ref="track" class="flex gap-6 shrink-0">
                    @foreach ($services as $service)
                        <div data-animate-item>
                            <x-service-card :service="$service" />
                        </div>
                    @endforeach
                    @if ($services->count() > 3)
                        @foreach ($services as $service)
                            <div aria-hidden="true">
                                <x-service-card :service="$service" />
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </section>
@endif
