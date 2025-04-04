import * as THREE from 'https://cdn.skypack.dev/three@0.129.0';
  import { GLTFLoader } from 'https://cdn.skypack.dev/three@0.129.0/examples/jsm/loaders/GLTFLoader.js';
  import { OrbitControls } from 'https://cdn.skypack.dev/three@0.129.0/examples/jsm/controls/OrbitControls.js';

// SCÈNE
const scene = new THREE.Scene();
scene.background = new THREE.Color(0xf0f0f0); // Arrière-plan clair

// CAMÉRA
const camera = new THREE.PerspectiveCamera(60, window.innerWidth / window.innerHeight, 0.1, 1000);
camera.position.set(0, 1, 3);

// RENDERER
const renderer = new THREE.WebGLRenderer({ antialias: true });
renderer.setSize(window.innerWidth, window.innerHeight);
renderer.shadowMap.enabled = true; // Active les ombres
const container = document.getElementById('visualisation-3d');
container.appendChild(renderer.domElement);

// LUMIÈRE
const ambientLight = new THREE.HemisphereLight(0xffffff, 0x444444, 1);
scene.add(ambientLight);

const directionalLight = new THREE.DirectionalLight(0xffffff, 1);
directionalLight.position.set(5, 10, 7.5);
directionalLight.castShadow = true;
directionalLight.shadow.mapSize.set(1024, 1024);
scene.add(directionalLight);

// SOL POUR L'OMBRE
const ground = new THREE.Mesh(
  new THREE.PlaneGeometry(10, 10),
  new THREE.ShadowMaterial({ opacity: 0.2 })
);
ground.rotation.x = -Math.PI / 2;
ground.receiveShadow = true;
scene.add(ground);

// CONTRÔLES
const controls = new OrbitControls(camera, renderer.domElement);
controls.enableDamping = true;
controls.enableZoom = false;

// CHARGEMENT DU MODÈLE
const loader = new GLTFLoader();
let model;
loader.load('./publique/images/modeles/sphere.glb', (gltf) => {
  model = gltf.scene;
  model.traverse(obj => {
    if (obj.isMesh) {
      obj.castShadow = true;
      obj.receiveShadow = false;
    }
  });
  model.scale.set(1, 1, 1);
  scene.add(model);
}, undefined, (error) => {
  console.error('Erreur lors du chargement :', error);
});

// RÉACTIVITÉ
window.addEventListener('resize', () => {
  camera.aspect = window.innerWidth / window.innerHeight;
  camera.updateProjectionMatrix();
  renderer.setSize(window.innerWidth, window.innerHeight);
});

// ANIMATION
let hover = false;
document.body.addEventListener('mouseenter', () => hover = true);
document.body.addEventListener('mouseleave', () => hover = false);

function animate() {
  requestAnimationFrame(animate);

  if (model) {
    // Rotation lente + zoom dynamique au hover
    model.rotation.y += 0.005;
    if (hover) {
      model.scale.set(1.1, 1.1, 1.1);
    } else {
      model.scale.set(1, 1, 1);
    }
  }

  controls.update();
  renderer.render(scene, camera);
}
animate();
