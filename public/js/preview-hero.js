(() => {
    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;
    const hero = document.querySelector('#preview-hero');
    if (!hero) return;
    const image = hero.querySelector('.hero-image');
    image.animate([{ transform: 'scale(1.015)' }, { transform: 'scale(1.045)' }], { duration: 26000, direction: 'alternate', iterations: Infinity, easing: 'ease-in-out' });
    const paths = [...hero.querySelectorAll('[data-preview-path]')];
    paths.forEach((path, index) => {
        const length = path.getTotalLength();
        path.style.strokeDasharray = `26 ${Math.max(length - 26, 1)}`;
        path.animate([{ strokeDashoffset: length }, { strokeDashoffset: 0 }], { duration: index === 0 ? 5200 : 7600, delay: index ? 3400 : 0, iterations: Infinity, easing: 'linear', endDelay: index ? 1600 : 2600 });
    });
})();
