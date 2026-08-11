import gsap from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';

gsap.registerPlugin(ScrollTrigger);

window.addEventListener('load', () => ScrollTrigger.refresh());

function splitIntoWords(el) {
    if (el.dataset.splitDone) return el.querySelectorAll(':scope > span');

    const text = el.textContent;
    el.textContent = '';

    text.split(/(\s+)/).forEach((chunk) => {
        if (chunk.trim() === '') {
            el.append(document.createTextNode(chunk));
            return;
        }
        const wrapper = document.createElement('span');
        wrapper.style.display = 'inline-block';
        wrapper.style.overflow = 'hidden';
        wrapper.style.paddingBottom = '0.15em';
        wrapper.style.marginBottom = '-0.15em';

        const inner = document.createElement('span');
        inner.style.display = 'inline-block';
        inner.textContent = chunk;
        wrapper.appendChild(inner);

        el.appendChild(wrapper);
    });

    el.dataset.splitDone = 'true';

    return el.querySelectorAll(':scope > span > span');
}

function initMagneticButtons() {
    document.querySelectorAll('[data-magnetic]').forEach((el) => {
        if (el.dataset.magneticBound) return;
        el.dataset.magneticBound = 'true';

        const strength = parseFloat(el.dataset.magnetic) || 0.3;

        el.addEventListener('pointermove', (event) => {
            const rect = el.getBoundingClientRect();
            const x = event.clientX - (rect.left + rect.width / 2);
            const y = event.clientY - (rect.top + rect.height / 2);
            gsap.to(el, { x: x * strength, y: y * strength, duration: 0.3, ease: 'power2.out' });
        });

        el.addEventListener('pointerleave', () => {
            gsap.to(el, { x: 0, y: 0, duration: 0.4, ease: 'power3.out' });
        });
    });
}

function initTiltCards() {
    document.querySelectorAll('[data-tilt]').forEach((el) => {
        if (el.dataset.tiltBound) return;
        el.dataset.tiltBound = 'true';

        el.style.transformStyle = 'preserve-3d';
        el.style.willChange = 'transform';

        el.addEventListener('pointermove', (event) => {
            const rect = el.getBoundingClientRect();
            const px = (event.clientX - rect.left) / rect.width - 0.5;
            const py = (event.clientY - rect.top) / rect.height - 0.5;

            gsap.to(el, {
                rotateY: px * 8,
                rotateX: py * -8,
                duration: 0.4,
                ease: 'power2.out',
                transformPerspective: 800,
            });
        });

        el.addEventListener('pointerleave', () => {
            gsap.to(el, { rotateX: 0, rotateY: 0, duration: 0.5, ease: 'power3.out' });
        });
    });
}

export function initScrollAnimations() {
    const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    ScrollTrigger.getAll().forEach((trigger) => trigger.kill());

    if (reduceMotion) {
        return;
    }

    document.querySelectorAll('[data-animate="fade-up"]').forEach((el) => {
        gsap.fromTo(
            el,
            { opacity: 0, y: 32 },
            {
                opacity: 1,
                y: 0,
                duration: 0.5,
                ease: 'power2.out',
                scrollTrigger: {
                    trigger: el,
                    start: 'top 90%',
                    toggleActions: 'play none none none',
                },
            }
        );
    });

    document.querySelectorAll('[data-animate="split-up"]').forEach((el) => {
        const words = splitIntoWords(el);
        if (!words.length) return;

        gsap.fromTo(
            words,
            { yPercent: 110, opacity: 0 },
            {
                yPercent: 0,
                opacity: 1,
                duration: 0.5,
                ease: 'power3.out',
                stagger: 0.025,
                scrollTrigger: {
                    trigger: el,
                    start: 'top 92%',
                    toggleActions: 'play none none none',
                },
            }
        );
    });

    document.querySelectorAll('[data-animate-group]').forEach((group) => {
        const items = group.querySelectorAll('[data-animate-item]');
        if (!items.length) return;

        gsap.fromTo(
            items,
            { opacity: 0, y: 28 },
            {
                opacity: 1,
                y: 0,
                duration: 0.4,
                ease: 'power2.out',
                stagger: 0.06,
                scrollTrigger: {
                    trigger: group,
                    start: 'top 85%',
                    toggleActions: 'play none none none',
                },
            }
        );
    });

    document.querySelectorAll('[data-parallax]').forEach((el) => {
        const speed = parseFloat(el.dataset.parallax) || 0.15;
        gsap.to(el, {
            yPercent: speed * 100,
            ease: 'none',
            scrollTrigger: {
                trigger: el.closest('[data-parallax-wrapper]') || el.parentElement,
                start: 'top bottom',
                end: 'bottom top',
                scrub: true,
            },
        });
    });

    initMagneticButtons();
    initTiltCards();

    ScrollTrigger.refresh();
}

export function initSmoothScroll() {
    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        return null;
    }

    return import('lenis').then(({ default: Lenis }) => {
        const lenis = new Lenis({
            duration: 1.1,
            smoothWheel: true,
        });

        lenis.on('scroll', ScrollTrigger.update);

        gsap.ticker.add((time) => {
            lenis.raf(time * 1000);
        });
        gsap.ticker.lagSmoothing(0);

        ScrollTrigger.addEventListener('refresh', () => lenis.resize());
        ScrollTrigger.refresh();

        return lenis;
    });
}
