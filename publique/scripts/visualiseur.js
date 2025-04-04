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
const container = document.getElementById('visualisation-3d');
const renderer = new THREE.WebGLRenderer({ antialias: true });
renderer.setSize(container.clientWidth, container.clientHeight);
renderer.shadowMap.enabled = true; // Active les ombres

container.appendChild(renderer.domElement);

// LUMIÈRE
const ambientLight = new THREE.HemisphereLight(0xffffff, 0x444444, 1);
scene.add(ambientLight);

const directionalLight = new THREE.DirectionalLight(0xffffff, 1);
directionalLight.position.set(5, 10, 7.5);
directionalLight.castShadow = true;
directionalLight.shadow.mapSize.set(1024, 1024);

//Réglages plus pour une l'ombre
directionalLight.shadow.camera.left = -10;
directionalLight.shadow.camera.right = 10;
directionalLight.shadow.camera.top = 10;
directionalLight.shadow.camera.bottom = -10;
directionalLight.shadow.camera.near = 1;
directionalLight.shadow.camera.far = 50;

scene.add(directionalLight);

// SOL POUR L'OMBRE
const ground = new THREE.Mesh(
  new THREE.PlaneGeometry(10, 10),
  new THREE.ShadowMaterial({ opacity: 0.2 })
);
ground.rotation.x = -Math.PI / 2;
ground.position.y = -0.30;
ground.position.x = -0.20;
ground.receiveShadow = true;
scene.add(ground);

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
  model.scale.set(0.3, 0.3, 0.3);
  scene.add(model);
}, undefined, (error) => {
  console.error('Erreur lors du chargement :', error);
});

// RÉACTIVITÉ
window.addEventListener('resize', () => {
  camera.aspect = window.innerWidth / window.innerHeight;
  camera.updateProjectionMatrix();
  renderer.setSize(container.clientWidth, container.clientHeight);
});

// ANIMATION
let hover = false;
container.addEventListener('mouseenter', () => hover = true);
container.addEventListener('mouseleave', () => hover = false);

function animate() {
  requestAnimationFrame(animate);

  if (model) {
    //Rotation
    model.rotation.y += 0.002;

    //Zoom au hover
    const targetScale = hover ? 0.4 : 0.3;

    //Transition de l'échelle (interpolation)
    const currentScale = model.scale.x;
    const lerpedScale = THREE.MathUtils.lerp(currentScale, targetScale, 0.1);
    model.scale.set(lerpedScale, lerpedScale, lerpedScale);

        // Force le recalcul de l’ombre
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
