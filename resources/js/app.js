import './bootstrap';
import { initScrollAnimations, initSmoothScroll } from './animations';
import { initPageTransitions } from './transitions';
import { initHeroDiagramFlow } from './hero-diagram';

// Livewire v3 bundles and boots its own Alpine instance — starting a second,
// separately-imported one here caused two Alpine runtimes to run at once
// (duplicate x-init/x-on bindings, "Detected multiple instances of Alpine
// running"), which showed up as random-feeling glitches: clicks silently
// swallowed, fields looking like they reloaded the page, etc.
// A Lenis-példányt eltesszük, mert a natív scrollIntoView/scrollTo nem
// hatásos, amíg Lenis felül van kerekedve rá — a görgetést végző kódnak
// (pl. a validációs hiba görgetés) ezen a példányon keresztül kell szólnia.
let lenisInstance = null;
Promise.resolve(initSmoothScroll()).then((lenis) => {
    lenisInstance = lenis;
});
initPageTransitions();

// livewire:navigated fires on the initial page load too, not just on
// subsequent wire:navigate transitions — using it as the single source
// avoids double-initializing (and double-killing) ScrollTrigger instances.
document.addEventListener('livewire:navigated', () => {
    initScrollAnimations();
    initHeroDiagramFlow();
});

// Natív <input type="file" multiple> minden kiválasztáskor lecseréli a
// files listát az újonnan választottakra, ahelyett hogy hozzáadná —
// ez adta azt a hibát, hogy a második képválasztás eltüntette az elsőt.
// Ez az Alpine-komponens a korábban választott File-okat is megtartja,
// és minden váltásnál a teljes, összesített listát tölti fel újra.
document.addEventListener('alpine:init', () => {
    Alpine.data('multiFileUploader', (property, max) => ({
        selected: [],
        uploading: false,
        progress: 0,
        errorMessage: '',
        handleChange(event) {
            const input = event.target;
            const incoming = Array.from(input.files || []);
            input.value = '';

            if (!incoming.length) {
                return;
            }

            this.errorMessage = '';
            const room = max - this.selected.length;

            if (room <= 0) {
                this.errorMessage = `Legfeljebb ${max} fájl tölthető fel.`;
                return;
            }

            const accepted = incoming.slice(0, room);

            if (incoming.length > accepted.length) {
                this.errorMessage = `Legfeljebb ${max} fájl tölthető fel — ${incoming.length - accepted.length} fájlt nem sikerült hozzáadni.`;
            }

            this.selected = [...this.selected, ...accepted];
            this.uploading = true;
            this.progress = 0;

            this.$wire.uploadMultiple(
                property,
                this.selected,
                () => {
                    this.uploading = false;
                    this.progress = 100;
                },
                (errors) => {
                    this.uploading = false;
                    this.errorMessage = Array.isArray(errors) && errors.length
                        ? errors.join(' ')
                        : 'Hiba történt a feltöltés közben.';
                },
                (uploadEvent) => {
                    this.progress = uploadEvent.detail.progress;
                }
            );
        },
    }));
});

// Ha a lépés-validáció elbukik (pl. az űrlap tetején lévő legördülő
// kitöltetlen maradt), az űrlap gyakran lejjebb van görgetve, mint ahol a
// hiba megjelenik — enélkül a felhasználó nem is látja, mi hiányzik.
document.addEventListener('livewire:init', () => {
    Livewire.hook('commit', ({ component, succeed }) => {
        if (component.name !== 'quote-request-wizard') {
            return;
        }

        succeed(() => {
            // A morph még nem biztos, hogy lefutott, amikor a "succeed"
            // meghívódik — egy microtask ebbe a résbe még belefuthat és egy
            // korábbi (rossz helyen lévő) elemet találna el. Két egymásba
            // ágyazott requestAnimationFrame biztosan a morph (és a
            // következő festés) után fut le.
            requestAnimationFrame(() => {
                requestAnimationFrame(() => {
                    const firstError = Array.from(component.el.querySelectorAll('.text-red-600'))
                        .find((el) => el.textContent.trim() !== '' && el.offsetParent !== null);

                    if (!firstError) {
                        return;
                    }

                    const rect = firstError.getBoundingClientRect();
                    const isVisible = rect.top >= 0 && rect.bottom <= window.innerHeight;

                    if (!isVisible) {
                        if (lenisInstance) {
                            lenisInstance.scrollTo(firstError, { offset: -Math.round(window.innerHeight / 2) });
                        } else {
                            firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        }
                    }
                });
            });
        });
    });
});
