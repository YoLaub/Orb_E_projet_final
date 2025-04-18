import * as THREE from 'https://cdn.skypack.dev/three@0.129.0';
  import { GLTFLoader } from 'https://cdn.skypack.dev/three@0.129.0/examples/jsm/loaders/GLTFLoader.js';
  import { OrbitControls } from 'https://cdn.skypack.dev/three@0.129.0/examples/jsm/controls/OrbitControls.js';

// SCÈNE
const scene = new THREE.Scene();
scene.background = new THREE.Color(0xf1f8ff);

// CAMÉRA
const camera = new THREE.PerspectiveCamera(60, 1, 0.1, 1000); // 🔧 MODIFICATION (aspect provisoire, mis à jour ensuite)
camera.position.set(0, 1, 3);

// RENDERER
const container = document.getElementById('visualisation-3d');
const renderer = new THREE.WebGLRenderer({ antialias: true });
renderer.shadowMap.enabled = true;
container.appendChild(renderer.domElement);

// 🔧 MODIFICATION : initialisation responsive
function resizeRenderer() {
  const width = container.clientWidth;
  const height = container.clientHeight;

  renderer.setSize(width, height);
  camera.aspect = width / height;
  camera.updateProjectionMatrix();
}
resizeRenderer(); // 🔧 Appel initial

// LUMIÈRE
const ambientLight = new THREE.HemisphereLight(0x8cf1f1, 0x333232, 0.8);
scene.add(ambientLight);

const directionalLight = new THREE.DirectionalLight(0xffffff, 1);
directionalLight.position.set(5, 10, 7.5);
directionalLight.castShadow = true;
directionalLight.shadow.mapSize.set(1024, 1024);
directionalLight.shadow.camera.left = -10;
directionalLight.shadow.camera.right = 10;
directionalLight.shadow.camera.top = 10;
directionalLight.shadow.camera.bottom = -10;
directionalLight.shadow.camera.near = 1;
directionalLight.shadow.camera.far = 50;
scene.add(directionalLight);

// OBJET CYLINDRE
const geometry = new THREE.CylinderGeometry(0.2, 0.2, 1, 32);
const material = new THREE.MeshStandardMaterial({ color: 0xb5d3e0 });
const cylinder = new THREE.Mesh(geometry, material);
cylinder.position.y = -0.9;
cylinder.receiveShadow = true;
scene.add(cylinder);

// CONTRÔLES
const controls = new OrbitControls(camera, renderer.domElement);
controls.enableDamping = true;
controls.enableZoom = false;

// CHARGEMENT DU MODÈLE
const loader = new GLTFLoader();
let model;
loader.load('./publique/images/modeles/orbe.glb', (gltf) => {
  model = gltf.scene;
  model.traverse(obj => {
    if (obj.isMesh) {
      obj.castShadow = true;
      obj.receiveShadow = false;
    }
  });
  model.scale.set(0.5, 0.5, 0.5);
  scene.add(model);
}, undefined, (error) => {
  console.error('Erreur lors du chargement :', error);
});

// 🔧 MODIFICATION : mise à jour responsive sur redimensionnement
window.addEventListener('resize', resizeRenderer);

// HOVER ANIMATION
let hover = false;
container.addEventListener('mouseenter', () => hover = true);
container.addEventListener('mouseleave', () => hover = false);

// ANIMATION
function animate() {
  requestAnimationFrame(animate);

  if (model) {
    model.rotation.y += 0.002;

    const targetScale = hover ? 0.6 : 0.5;
    const currentScale = model.scale.x;
    const lerpedScale = THREE.MathUtils.lerp(currentScale, targetScale, 0.1);
    model.scale.set(lerpedScale, lerpedScale, lerpedScale);

    model.traverse((obj) => {
      if (obj.isMesh) {
        obj.castShadow = true;
        obj.geometry.computeBoundingSphere(); 
      }
    });
  }

  controls.update();
  renderer.render(scene, camera);
}
animate();