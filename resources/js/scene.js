import * as THREE from 'three';
import { GLTFLoader } from 'three/examples/jsm/loaders/GLTFLoader.js';

const scene = new THREE.Scene();

const camera = new THREE.PerspectiveCamera(
    75,
    window.innerWidth / window.innerHeight,
    0.1,
    1000
);
camera.position.set(0, 0, 5);
camera.lookAt(0, 0, 0);

const renderer = new THREE.WebGLRenderer({ alpha: true, antialias: true });
renderer.setSize(window.innerWidth, window.innerHeight);
renderer.setPixelRatio(window.devicePixelRatio);
renderer.shadowMap.enabled = true;

const container = document.getElementById('container3D');
if (!container) {
    console.error("❌ 'container3D' div not found.");
} else {
    container.appendChild(renderer.domElement);
}

const directionalLight = new THREE.DirectionalLight(0xffffff, 1.2);
directionalLight.position.set(5, 10, 5);
directionalLight.castShadow = true;
scene.add(directionalLight);

const ambientLight = new THREE.AmbientLight(0xffffff, 1.2);
scene.add(ambientLight);

const loader = new GLTFLoader();
const MODEL_PATH = '/models/wallet/scene.gltf';

let object = null;
let animationStart = 0;

loader.load(
    MODEL_PATH,
    (gltf) => {
        object = gltf.scene;

        object.traverse((node) => {
            if (node.isMesh) {
                node.castShadow = true;
                node.receiveShadow = true;
                node.material.flatShading = false;
                node.material.roughness = 0.4;
                node.material.metalness = 0.2;
                node.material.transparent = true;
                node.material.opacity = 0;
                node.material.needsUpdate = true;
            }
        });

        object.position.set(3, -2, 0);
        object.scale.set(0, 0, 0);
        scene.add(object);

        animationStart = Date.now();
    },
    (xhr) => {
        console.log(`🔄 ${(xhr.loaded / xhr.total * 100).toFixed(0)}% loaded`);
    },
    (error) => {
        console.error('❌ Error loading model:', error);
    }
);

function easeOutCubic(t) {
    return 1 - Math.pow(1 - t, 3);
}

let scrollProgress = 0;
window.addEventListener('scroll', () => {
    const scrollTop = window.scrollY;
    const maxScroll = document.body.scrollHeight - window.innerHeight;
    scrollProgress = Math.min(scrollTop / maxScroll, 1);
});

function animate() {
    requestAnimationFrame(animate);

    if (object) {
        const elapsed = (Date.now() - animationStart) / 2000;
        const entranceProgress = Math.min(easeOutCubic(elapsed), 1);

        const startX = 3;
        const leftX = -2;

        let targetX;
        if (scrollProgress < 0.33) {
            const t = scrollProgress / 0.33;
            targetX = startX + (leftX - startX) * t;
        } else {
            targetX = leftX;
        }

        object.position.x += (targetX - object.position.x) * 0.2;
        object.position.y = -2;
        object.position.z = 0;

        const startRotY = 0.2;
        const endRotY = -Math.PI / 2;
        const targetRotY = startRotY + (endRotY - startRotY) * scrollProgress;
        object.rotation.y += (targetRotY - object.rotation.y) * 0.1;

        const startRotX = 0;
        const endRotX = -Math.PI / 2;
        const targetRotX = startRotX + (endRotX - startRotX) * scrollProgress;
        object.rotation.x += (targetRotX - object.rotation.x) * 0.1;

        let scale = 1.5 * entranceProgress;
        let opacity = entranceProgress;

        if (scrollProgress > 0.66) {
            const exitT = (scrollProgress - 0.66) / 0.34;
            const fade = Math.max(1 - exitT, 0);
            scale = 1.5 * Math.max(fade, 0.2);
            opacity = fade;
        }

        object.scale.set(scale, scale, scale);

        object.traverse((node) => {
            if (node.isMesh && node.material.transparent) {
                node.material.opacity = opacity;
            }
        });

        object.lookAt(camera.position);
    }

    renderer.render(scene, camera);
}
animate();

window.addEventListener('resize', () => {
    camera.aspect = window.innerWidth / window.innerHeight;
    camera.updateProjectionMatrix();
    renderer.setSize(window.innerWidth, window.innerHeight);
});
