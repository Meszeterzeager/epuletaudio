import gsap from 'gsap';

export function initHeroDiagramFlow() {
    const paths = document.querySelectorAll('#hero-diagram-flows path[data-flow]');
    if (!paths.length) return;

    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        return;
    }

    paths.forEach((path) => {
        const length = path.getTotalLength();
        path.style.strokeDasharray = `${length * 0.12} ${length * 0.88}`;
        gsap.fromTo(
            path,
            { strokeDashoffset: length },
            {
                strokeDashoffset: 0,
                duration: 2.6,
                ease: 'none',
                repeat: -1,
            }
        );
    });
}
