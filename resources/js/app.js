import './bootstrap';
import Alpine from 'alpinejs';
import { initScrollAnimations, initSmoothScroll } from './animations';
import { initPageTransitions } from './transitions';
import { initHeroDiagramFlow } from './hero-diagram';

window.Alpine = Alpine;
Alpine.start();

initSmoothScroll();
initPageTransitions();

// livewire:navigated fires on the initial page load too, not just on
// subsequent wire:navigate transitions — using it as the single source
// avoids double-initializing (and double-killing) ScrollTrigger instances.
document.addEventListener('livewire:navigated', () => {
    initScrollAnimations();
    initHeroDiagramFlow();
});
