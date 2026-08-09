import gsap from 'gsap';

let isCovered = true;

function getElements() {
    return {
        overlay: document.getElementById('page-transition-overlay'),
        mark: document.getElementById('page-transition-mark'),
    };
}

function cover() {
    if (isCovered) return;
    isCovered = true;

    const { overlay, mark } = getElements();
    if (!overlay) return;

    overlay.style.pointerEvents = 'auto';

    gsap.killTweensOf([overlay, mark]);
    gsap.to(overlay, { opacity: 1, duration: 0.35, ease: 'power2.inOut' });
    if (mark) {
        gsap.to(mark, { opacity: 1, scale: 1, duration: 0.4, ease: 'power2.out', delay: 0.05 });
    }
}

function reveal() {
    if (!isCovered) return;

    const { overlay, mark } = getElements();
    if (!overlay) return;

    gsap.killTweensOf([overlay, mark]);
    if (mark) {
        gsap.to(mark, { opacity: 0, duration: 0.25, ease: 'power2.in' });
    }
    gsap.to(overlay, {
        opacity: 0,
        duration: 0.4,
        delay: 0.1,
        ease: 'power2.inOut',
        onComplete: () => {
            overlay.style.pointerEvents = 'none';
            isCovered = false;
        },
    });
}

export function initPageTransitions() {
    const { overlay } = getElements();
    if (!overlay) return;

    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        overlay.style.display = 'none';
        isCovered = false;
        return;
    }

    const { mark } = getElements();
    if (mark) {
        gsap.to(mark, { opacity: 1, scale: 1, duration: 0.4, ease: 'power2.out', delay: 0.1 });
    }

    const revealOnReady = () => reveal();
    if (document.readyState === 'complete') {
        setTimeout(revealOnReady, 500);
    } else {
        window.addEventListener('load', () => setTimeout(revealOnReady, 350), { once: true });
    }

    document.addEventListener('livewire:navigate', cover);
    document.addEventListener('livewire:navigating', cover);
    document.addEventListener('livewire:navigated', reveal);
}
