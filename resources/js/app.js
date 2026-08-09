import './bootstrap';
import Alpine from 'alpinejs';
import { initScrollAnimations, initSmoothScroll } from './animations';
import { initPageTransitions } from './transitions';

window.Alpine = Alpine;
Alpine.start();

initScrollAnimations();
initSmoothScroll();
initPageTransitions();

let heroCleanup = null;

function initHeroForCurrentPage() {
    const heroCanvas = document.getElementById('hero-canvas');
    if (!heroCanvas) return;

    import('./hero3d').then(({ initHero3D }) => {
        heroCleanup = initHero3D(heroCanvas) || null;
    });
}

initHeroForCurrentPage();

document.addEventListener('livewire:navigate', () => {
    if (heroCleanup) {
        heroCleanup();
        heroCleanup = null;
    }
});

document.addEventListener('livewire:navigated', () => {
    initScrollAnimations();
    initHeroForCurrentPage();
});
