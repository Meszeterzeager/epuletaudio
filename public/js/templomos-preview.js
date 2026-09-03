(() => {
    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;
    const hero = document.querySelector('#church-hero');
    if (!hero) return;
    const paths = [...hero.querySelectorAll('[data-church-path]')];
    paths.forEach((path, index) => {
        const length = path.getTotalLength();
        path.style.strokeDasharray = `28 ${Math.max(length - 28, 1)}`;
        path.animate([{ strokeDashoffset: length }, { strokeDashoffset: 0 }], {
            duration: index === 0 ? 600 : 1500, delay: index ? 200 : 0, iterations: Infinity,
            easing: 'ease-out', direction: 'normal', endDelay: index ? 1300 : 1500,
        });
    });
    hero.querySelector('.hero-image').animate([{ transform: 'scale(1.015)' }, { transform: 'scale(1.055)' }], { duration: 22000, direction: 'alternate', iterations: Infinity, easing: 'ease-in-out' });
})();
