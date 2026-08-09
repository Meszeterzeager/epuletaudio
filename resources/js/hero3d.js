import * as THREE from 'three';

export function initHero3D(canvas) {
    if (!canvas) return;

    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        return;
    }

    if (!window.WebGLRenderingContext) {
        return;
    }

    const renderer = new THREE.WebGLRenderer({ canvas, alpha: true, antialias: true });
    renderer.setPixelRatio(Math.min(window.devicePixelRatio || 1, 2));

    const scene = new THREE.Scene();
    const camera = new THREE.PerspectiveCamera(45, 1, 0.1, 100);
    camera.position.set(0, 0, 6);

    const group = new THREE.Group();
    scene.add(group);

    const coreGeometry = new THREE.IcosahedronGeometry(1.15, 1);
    const coreMaterial = new THREE.MeshStandardMaterial({
        color: 0xd9a557,
        metalness: 0.45,
        roughness: 0.35,
        emissive: 0x0f3d3e,
        emissiveIntensity: 0.2,
        flatShading: true,
    });
    const core = new THREE.Mesh(coreGeometry, coreMaterial);
    group.add(core);

    const ringDefs = [
        { radius: 1.7, color: 0x6a9d9e, opacity: 0.5, tiltOffset: 0 },
        { radius: 2.2, color: 0x1f6668, opacity: 0.35, tiltOffset: 0.2 },
        { radius: 2.7, color: 0xd9a557, opacity: 0.25, tiltOffset: 0.4 },
    ];

    const rings = ringDefs.map(({ radius, color, opacity, tiltOffset }) => {
        const geometry = new THREE.TorusGeometry(radius, 0.012, 12, 120);
        const material = new THREE.MeshBasicMaterial({ color, transparent: true, opacity });
        const ring = new THREE.Mesh(geometry, material);
        ring.rotation.x = Math.PI / 2 + tiltOffset;
        group.add(ring);
        return ring;
    });

    scene.add(new THREE.AmbientLight(0xffffff, 0.7));
    const point = new THREE.PointLight(0xffffff, 1.4);
    point.position.set(3, 3, 5);
    scene.add(point);

    function resize() {
        const width = canvas.clientWidth || 1;
        const height = canvas.clientHeight || 1;
        renderer.setSize(width, height, false);
        camera.aspect = width / height;
        camera.updateProjectionMatrix();
    }
    resize();

    const resizeObserver = new ResizeObserver(resize);
    resizeObserver.observe(canvas);

    let pointerX = 0;
    let pointerY = 0;
    const onPointerMove = (event) => {
        pointerX = event.clientX / window.innerWidth - 0.5;
        pointerY = event.clientY / window.innerHeight - 0.5;
    };
    window.addEventListener('pointermove', onPointerMove, { passive: true });

    let scrollFade = 1;
    const onScroll = () => {
        const fadeDistance = window.innerHeight * 0.9;
        scrollFade = Math.max(0.15, 1 - window.scrollY / fadeDistance);
    };
    window.addEventListener('scroll', onScroll, { passive: true });

    const clock = new THREE.Clock();
    let frameId;

    function animate() {
        const elapsed = clock.getElapsedTime();
        core.rotation.y = elapsed * 0.22 + pointerX * 0.5;
        core.rotation.x = elapsed * 0.1 + pointerY * 0.3;
        rings.forEach((ring, i) => {
            ring.rotation.z = elapsed * (0.06 + i * 0.025);
        });
        group.scale.setScalar(scrollFade);
        renderer.render(scene, camera);
        frameId = requestAnimationFrame(animate);
    }
    animate();

    return () => {
        cancelAnimationFrame(frameId);
        resizeObserver.disconnect();
        window.removeEventListener('pointermove', onPointerMove);
        window.removeEventListener('scroll', onScroll);
        renderer.dispose();
    };
}
