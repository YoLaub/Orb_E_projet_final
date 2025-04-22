import {
  initializeAudio,
  detectBeats,
  drawB,
  getCurrentFrequency,
} from "./audioManager.js";
import { getValueWeather, updateCount } from "./meteoSource.js";
import { themeVars } from './variableCSS.js';
import { Texte, openModal } from './texte.js';

//=======================VARIABLES GENERALE======================
// =======================////////////////======================
// =======================////////////////======================



var canva = document.getElementById("gameCanvas");
const context = canva.getContext("2d");

var modeTest = false;

//Gestion du score
var score = 0;
var scoreDisplay = 0;
var scoreTab = [];

//Debut de partie
var start = false;

const fps = 60;
const interval = 1000 / fps;
let lastUpdateTime = performance.now();

//Fin de partie
var isGameOver = false;
var gameOver = 0;
var animationId = null;

// Variables pour gérer le message de fin
let messageFinActive = false;
let messageFinX = canva.width;
const messageFinText = "Finish";
const messageFinSpeed = 2;

//Gestion de la balle
var ballY = 290;
var velocityY = 0;
const gravity = 0.3;
const jumpPower = -10;
const groundY = 300;
var isOnBlock = false;

//Obstacles
var obstacles = [];
//Vitesse
var baseSpeed = 2;
var speed = baseSpeed;

//Bonus
var bonus = null;
var bonusType = "";
var isInvincible = false;
var invincibilityTimer = 0;

var isSlow = false;
var slowTimer = 0;

//Particule
var particules = [];
var ballParticules = [];
//=========================TEXTE======================
//=======================/////////======================
//=======================/////////======================

var speedText = new Texte({
  id: "speed",
  text: "Super speed",
  font: themeVars.jeu_texte,
  size: 20,
  x: canva.width / 2,
  y: 60,
  color: themeVars.jeu_alert,
  justify: "center"
});

var cityText = new Texte({
  id: "city",
  text: "Paris",
  font: themeVars.jeu_texte,
  size: 20,
  x: canva.width / 2,
  y: canva.height - 20,
  color: themeVars.jeu,
  justify: "center"
});

var finishText = new Texte({
  id: "finish",
  text: messageFinText,
  font: themeVars.jeu_texte,
  size: 32,
  x: messageFinX,
  y: canva.height / 2,
  color: themeVars.jeu,
  justify: "center"
});



//=======================BACKGROUND======================
//=======================/////////======================
//=======================/////////======================

const paris = new Image();
paris.src = "./publique/images/orbe/paris.png"; // Remplace par le chemin de ton image
const moscou = new Image();
moscou.src = "./publique/images/orbe/moscou.png"; // Remplace par le chemin de ton image
const tokyo = new Image();
tokyo.src = "./publique/images/orbe/tokyo.png"; // Remplace par le chemin de ton image
const johannesburg = new Image();
johannesburg.src = "./publique/images/orbe/johannesburg.png"; // Remplace par le chemin de ton image
const rio = new Image();
rio.src = "./publique/images/orbe/rio.png"; // Remplace par le chemin de ton image
const newYork = new Image();
newYork.src = "./publique/images/orbe/newyork.png"; // Remplace par le chemin de ton image

var backgroundsCity = [
  { src: paris, x: 0, y: -100, width: canva.width, height: canva.height },
  { src: moscou, x: 0, y: -100, width: canva.width, height: canva.height },
  { src: tokyo, x: 0, y: -100, width: canva.width, height: canva.height },
  {
    src: johannesburg,
    x: 0,
    y: -100,
    width: canva.width,
    height: canva.height,
  },
  { src: rio, x: 0, y: -100, width: canva.width, height: canva.height },
  { src: newYork, x: 0, y: -100, width: canva.width, height: canva.height },
];

let backgroundIndex = 0;
let round = 0;

function drawAndUpdateBackground() {
  context.drawImage(
    backgroundsCity[backgroundIndex].src,
    backgroundsCity[backgroundIndex].x + canva.width,
    backgroundsCity[backgroundIndex].y,
    backgroundsCity[backgroundIndex].width,
    backgroundsCity[backgroundIndex].height
  );

  if (backgroundsCity[backgroundIndex].x + canva.width > -800) {
    if (isSlow) {
      backgroundsCity[backgroundIndex].x -= 0.1; // Vitesse réduite si slow
    } else if (isInvincible) {
      backgroundsCity[backgroundIndex].x -= 0.7; // Vitesse légèrement plus lente pour simuler la distance
    } else {
      backgroundsCity[backgroundIndex].x -= 0.3;
    }
  } else {
    if (backgroundIndex === backgroundsCity.length - 1) {
      backgroundIndex = 0;
      backgroundsCity.forEach((backgroundCity) => (backgroundCity.x = 0));
      round++;
    } else {
      backgroundIndex++;
      updateCount(backgroundIndex)
      pressure();
      temperature();
      nebulosity();
      let nameCity = backgroundsCity[backgroundIndex].src.src
      let cleanedName = nameCity.split('/').pop().replace('.png', '');
      cityText.updateText(cleanedName.toUpperCase()); // affiche juste "paris"
    }
  }
}
//=========================TEXTE======================
//=======================/////////======================
//=======================/////////======================

// const textes = [
//   new Text({id:"gameover", text:"Game Over", x:canva.width / 2, y:canva.height / 2, color: jeu_alert, justify: "center" }),
//   new Text({id:"gameover", text:"Game Over", x:canva.width / 2, y:canva.height / 2, color: jeu_alert, justify: "center" })
// ]


//=========================METEO======================
//=======================/////////======================
//=======================/////////======================

var pressureData = null;
var temperatureData = null;
//var humidityData = null;
var nebulositeData = null;

async function pressure() {
  try {
    const weatherData = await getValueWeather();
    console.log(weatherData);
    pressureData = weatherData.pressure;
    return pressureData;
  } catch (error) {
    console.error(
      "Erreur lors de la récupération des données météorologiques:",
      error
    );
  }
}
pressure();
async function temperature() {
  try {
    const weatherData = await getValueWeather();
    console.log(weatherData);
    temperatureData = weatherData.temperature;
    nebulositeData = weatherData.nebulosity;
    return temperatureData, nebulositeData;
  } catch (error) {
    console.error(
      "Erreur lors de la récupération des données météorologiques:",
      error
    );
  }
}
temperature();

async function nebulosity() {
  try {
    const weatherData = await getValueWeather();
    console.log(weatherData);
    nebulositeData = weatherData.nebulosity;
    return nebulositeData;
  } catch (error) {
    console.error(
      "Erreur lors de la récupération des données météorologiques:",
      error
    );
  }
}
nebulosity();


//Son

//const soundJump = new Audio("sound/jump.mp3")

//========================SOLEIL======================

let angle = 0;
const rotationCenterX = 400;
const rotationCenterY = 300; // Centré verticalement
const circleRadius = 10;
const circleDistance = canva.width - 500; // Distance entre le centre de rotation et le cercle
const blurLayers = 4; // Nombre de couches de flou
const blurIntensity = 10; // Intensité du flou

function drawSun() {
  // Calculer la position du cercle en fonction de l'angle de rotation
  const circleX = rotationCenterX + circleDistance * Math.cos(angle);
  const circleY = rotationCenterY + circleDistance * Math.sin(angle);

  // Dessiner le cercle avec effet de flou
  for (let i = 0; i < blurLayers; i++) {
    context.beginPath();
    context.arc(
      circleX,
      circleY,
      circleRadius + i * blurIntensity,
      0,
      2 * Math.PI
    );
    context.fillStyle = `rgba(255, 165, 0, ${(1 - i / blurLayers) * 0.5})`;
    context.fill();
    context.closePath();
  }
  // Incrémenter l'angle pour la rotation
  angle += 0.002;
}

//========================NUAGES======================
var clouds = [];

function generateClouds() {
  let quantityCloud = Math.floor(nebulositeData);

  if (quantityCloud <= 0) {
    return;
  }
  for (let i = 0; i < quantityCloud; i++) {
    let cloud = {
      x: 0,
      y: 0,
      size: 0,
    };
    cloud.x = Math.floor(Math.random() * 600);
    cloud.y = Math.floor(Math.random() * 150);
    cloud.size = Math.floor(Math.random() * (quantityCloud * 10));
    clouds.push(cloud);
  }
}

function drawCloud() {
  for (let i = clouds.length - 1; i >= 0; i--) {
    let cloud = clouds[i];

    if (!isSlow) {
      cloud.x -= 0.2;
    } else {
      cloud.x -= 0;
    }

    context.fillStyle = "rgba(128, 128, 128, 0.3)"; // Couleur blanche pour le nuage
    context.beginPath();

    // Dessiner les cercles du nuage
    context.arc(cloud.x, cloud.y, cloud.size, 0, Math.PI * 2); // Cercle principal
    context.arc(
      cloud.x + cloud.size * 0.7,
      cloud.y - cloud.size * 0.4,
      cloud.size * 0.8,
      0,
      Math.PI * 2
    );
    context.arc(
      cloud.x - cloud.size * 0.7,
      cloud.y - cloud.size * 0.4,
      cloud.size * 0.8,
      0,
      Math.PI * 2
    );
    context.arc(
      cloud.x + cloud.size * 0.4,
      cloud.y + cloud.size * 0.4,
      cloud.size * 0.7,
      0,
      Math.PI * 2
    );
    context.arc(
      cloud.x - cloud.size * 0.4,
      cloud.y + cloud.size * 0.4,
      cloud.size * 0.7,
      0,
      Math.PI * 2
    );

    context.closePath();
    context.fill();

    // Supprime l'obstacle s'il sort de l'écran
    if (cloud.x < 0) {
      cloud.x = canva.width;
    }
  }
}

//=======================FLOCON DE NEIGE======================
//=======================///////////////======================
//=======================///////////////======================

// function drawSnowflake(x, y, size) {
//   ctx.strokeStyle = '#FFFFFF'; // Blanc pour le flocon
//   ctx.lineWidth = 2;

//   // Fonction récursive pour dessiner les branches
//   function drawBranch(x1, y1, length, angle, depth) {
//       if (depth === 0) return;

//       // Calculer le point final de la branche
//       const x2 = x1 + length * Math.cos(angle);
//       const y2 = y1 + length * Math.sin(angle);

//       // Dessiner la branche principale
//       ctx.beginPath();
//       ctx.moveTo(x1, y1);
//       ctx.lineTo(x2, y2);
//       ctx.stroke();

//       // Dessiner les sous-branches
//       const newLength = length * 0.6; // Réduction de la taille
//       drawBranch(x2, y2, newLength, angle - Math.PI / 6, depth - 1); // Branche gauche
//       drawBranch(x2, y2, newLength, angle + Math.PI / 6, depth - 1); // Branche droite
//   }

//   // Dessiner les six branches principales du flocon
//   for (let i = 0; i < 6; i++) {
//       const angle = (Math.PI / 3) * i;
//       drawBranch(x, y, size, angle, 3); // Profondeur 3
//   }
// }

//=======================MUSIQUES======================
//=======================/////////======================
//=======================/////////======================

const backgroundMusic = new Audio("./publique/musique/test3.mp3");
backgroundMusic.volume = 1; // Ajuste le volume

backgroundMusic.addEventListener("ended", () => {
  messageFinActive = true;
  drawEndMessage();
});

//=========================BONUS======================
//=======================/////////======================
//=======================/////////======================

//Generer les bonus
function generateBonus() {
  if (!messageFinActive) {
    bonus = {
      x: canva.width,
      y: Math.random() * (groundY - 50), // Position aléatoire au-dessus du sol
      width: 20,
      height: 20,
    };
  }
}

function drawBonus() {
  if (bonus && bonusType === "invincible") {
    context.fillStyle = "gold";
    context.fillRect(bonus.x, bonus.y, bonus.width, bonus.height);
  } else if (bonus && bonusType === "slow") {
    context.fillStyle = "red";
    context.fillRect(bonus.x, bonus.y, bonus.width, bonus.height);
  } else if (bonus && bonusType === "addScoreBonus") {
    context.fillStyle = "blue";
    context.fillRect(bonus.x, bonus.y, bonus.width, bonus.height);
  }
}

function updateBonus() {
  if (bonus) {
    bonus.x -= speed;
    if (bonus.x + bonus.width < 0) {
      bonus = null;
    }
  }
}

function checkBonusCollision() {
  if (bonus) {
    const ballBottom = ballY + 10;
    const ballTop = ballY - 10;
    const ballRight = 100 + 10;
    const ballLeft = 100 - 10;

    const bonusBottom = bonus.y + bonus.height;
    const bonusTop = bonus.y;
    const bonusRight = bonus.x + bonus.width;
    const bonusLeft = bonus.x;

    if (
      ballBottom > bonusTop &&
      ballTop < bonusBottom &&
      ballRight > bonusLeft &&
      ballLeft < bonusRight
    ) {
      bonus = null; // Supprime le bonus
      if (bonusType === "invincible") {
        activateInvincibility();
      } else if (bonusType === "addScoreBonus") {
        scoreDisplay += 10;
      } else {
        activateSlow();
      }
    }
  }
}

function activateInvincibility() {
  isInvincible = true;
  speedText.updateText("Super speed")
  baseSpeed = 10;
  invincibilityTimer = 300; // 5 seconds => 60 FPS)
}

function updateInvincibility() {
  if (isInvincible) {
    invincibilityTimer--;
   if(invincibilityTimer <= 200 && invincibilityTimer > 150){
    speedText.updateText("3")
   }else if(invincibilityTimer <= 150 && invincibilityTimer > 100){
    speedText.updateText("2")
   }else if(invincibilityTimer <= 100 && invincibilityTimer > 50){
    speedText.updateText("1")
   }else if(invincibilityTimer <= 50){
    speedText.updateText("0")
   }

    if (invincibilityTimer <= 0) {
      isInvincible = false;
      baseSpeed = 3;
      // Fin de l'invincibilité
    }
  }
}
function activateSlow() {
  isSlow = true;
  slowTimer = 300; // 300 frames (environ 5 secondes si 60 FPS)
}

function updateSlow() {
  if (isSlow) {
    slowTimer--;
    if (slowTimer <= 0) {
      isSlow = false; // Fin de l'invincibilité
    }
  }
}

//=======================PARTICULE======================
//=======================/////////======================
//=======================/////////======================

//Generer les particules pluie
function generateParticules() {
  let particule = {
    x: Math.random() * 800,
    y: Math.random() * groundY,
    width: 2,
    height: 1,
  };
  particules.push(particule);
}

function drawParticule() {
  particules.forEach((particule) => {
    let i = particule;
    if (!isSlow) {
      particule.x -= speed * 0.3;
      particule.y += 0.1;
    } else {
      particule.x -= baseSpeed * 0.3;
      particule.y += 1;
    }

    context.fillStyle = "#f0f0f2";
    context.fillRect(
      particule.x,
      particule.y,
      particule.width + 0.1,
      particule.height
    );

    if (particule.x + particule.width < 0) {
      particules.splice(i, 1); // Retire l'obstacle du tableau
     
    }
  });
}

//particule balle
function generateBallParticules() {
  let ballParticule = {
    x: 100,
    y: Math.random() * 10 + ballY,
    width: 5,
    height: 1,
  };
  ballParticules.push(ballParticule);
}

function drawParticuleBall(){
  ballParticules.forEach((ballParticule) => {
    let i = ballParticule;
    if (isSlow) {
      ballParticule.x -= 0;
      ballParticule.y += 0;
    } else {
      ballParticule.x -= baseSpeed * Math.random();
    }

    context.fillStyle = "#f0f0f2";
    context.fillRect(
      ballParticule.x,
      ballParticule.y,
      ballParticule.width,
      ballParticule.height
    );

    if(ballParticules.length > 10){
      ballParticules.splice(i, 1); // Retire l'obstacle du tableau
    }
      
    
    
  });
}


//=======================OBSTACLES======================
//=======================/////////======================
//=======================/////////======================

//generer les obstacles
function generateObstacle() {
  let compare = getCurrentFrequency()/2 - Math.floor(Math.random() * 200);

 if( compare > 0){
  let obstacle = {
    x: canva.width,
    width: 20 + Math.floor(Math.random() * 10),
    height: compare,
  };
  obstacles.push(obstacle); // Ajoute le nouvel obstacle au tableau
 }else{
  return
 }
  
}

function drawObstacles() {
  for (let i = obstacles.length - 5; i >= 0; i--) {
    let obstacle = obstacles[i];

    // Déplace l'obstacle
    if (!isSlow) {
      obstacle.x -= speed;
    } else {
      obstacle.x -= baseSpeed;
    }

    // Dessine l'obstacle
    context.fillStyle = "#585863";
    context.fillRect(
      obstacle.x,
      groundY - obstacle.height,
      obstacle.width,
      obstacle.height
    );

    // Couleur et style du contour
    context.strokeStyle = "#3c3c49"; // ou une autre couleur
    context.lineWidth = 1; // épaisseur du contour
    context.strokeRect(
      obstacle.x,
      groundY - obstacle.height,
      obstacle.width,
      obstacle.height
    );

    // Supprime l'obstacle s'il sort de l'écran
    if (obstacle.x + obstacle.width < 0) {
      obstacles.splice(i, 1); // Retire l'obstacle du tableau
      score++;
      if (score % 5 === 0) {
        scoreDisplay++;
      } // Incrémente le score
    }
  }
}

function checkObstaclesCollision() {
  for (let obstacle of obstacles) {
    if (!isInvincible) {
      let ballBottom = ballY + 10;
      let ballTop = ballY - 10; // Haut de la balle
      let ballRight = 100 + 10;
      let ballLeft = 100 - 10;

      let obstacleTop = groundY - obstacle.height;
      let obstacleLeft = obstacle.x;
      let obstacleRight = obstacle.x + obstacle.width;

      // Collision avec le haut du bloc
      if (
        ballBottom > obstacleTop &&
        ballTop < obstacleTop + 1 &&
        ballRight > obstacleLeft &&
        ballLeft < obstacleRight
      ) {
        ballY = obstacleTop - 10; // Place la balle sur le bloc
        velocityY = 0; // Arrête la gravité
        isOnBlock = true;
      } else if (
        ballRight > obstacleLeft &&
        ballLeft < obstacleRight &&
        ballBottom > obstacleTop
      ) {
        console.log("Collision détectée !");
        isGameOver = true; // Déclenche le Game Over
        scoreTab.push(scoreDisplay);
        gameOver++;
        start = false;
        backgroundMusic.pause();
        break;
      }
    }
  }
}

//=======================MESSAGES======================
//=======================/////////======================
//=======================/////////======================

// Fonction pour dessiner le message "Fin"
function drawEndMessage() {
  finishText.draw(context)
  messageFinX -= messageFinSpeed;
  finishText.updatePosition(messageFinX)

  // Vérifier si le message est complètement sorti de l'écran
  if (
    messageFinX + context.measureText(messageFinText).width <
    canva.width / 2
  ) {
    scoreTab.push(scoreDisplay);
    stopGame(); // Arrêter le jeu

  }
}

//=======================AFFICHAGE======================
//=======================/////////======================
//=======================/////////======================

function updateGame() {
  if (isGameOver) {

    let isOver = new Texte({
      id: "isOver",
      text: "Game Over !!",
      font: themeVars.jeu_texte,
      size: 30,
      x: canva.width / 2,
      y: (canva.height / 2) -20,
      color: themeVars.jeu_alert,
      justify: "center"
    });
    isOver.draw(context)

    let retry = new Texte({
      id: "retry",
      text: "Press Restart",
      font: themeVars.jeu_texte,
      size: 30,
      x: canva.width / 2,
      y: canva.height / 2 + 20,
      color: themeVars.jeu_alert,
      justify: "center"
    });
    retry.draw(context)
    document.getElementById("restart").style.display ="block";

    return; // Arrête la boucle du jeu
  }

  context.clearRect(0, 0, canva.width, canva.height);
  

  //COULEUR DE FOND

  //gradient linéaire
  const gradient = context.createLinearGradient(0, 0, 0, canva.height);

  // Ajouter les couleurs du gradient
  gradient.addColorStop(0, "#ff7e5f"); // Couleur orange vif
  gradient.addColorStop(1, "#feb47b"); // Couleur pêche

  // Remplir le canva avec le gradient
  context.fillStyle = gradient;
  context.fillRect(0, 0, canva.width, canva.height);

  
  drawSun();
  drawCloud();

  drawB(context, canva);
  drawAndUpdateBackground();
  //drawBackground();
  drawBonus();
  if (pressureData <= 1010) {
    generateParticules();
    drawParticule();
  }

  updateBonus();

  start = true;

  //Dessine la boule
  context.fillStyle = themeVars.texte1;
  context.beginPath();
  context.arc(100, ballY, 10, 0, Math.PI * 2);
  context.fill();
  context.lineWidth = 1; // épaisseur du contour
  context.strokeStyle = themeVars.texte2; // couleur du contour
  context.stroke(); // dessine le contour

  //Dessine le sol
  context.beginPath(); 
  context.moveTo(0, 300); 
  context.lineTo(800, 300); 
  context.lineWidth = 5;
  context.stroke(); // Render the path
  context.fillStyle = "black";
  context.fillRect(0, 300, canva.width, 100);
  generateBallParticules()
  drawParticuleBall()
  //gravité
  velocityY += gravity;
  ballY += velocityY;

  //Collision avec le sol
  if (isInvincible) {
    ballY = groundY - 150;
    velocityY = 0;
  } else {
    if (ballY > groundY - 10) {
      ballY = groundY - 10; // Reste au sol
      velocityY = 0; //Stop le mouvement
    }
  }
  //Ajuster la vitess en fonction du score

  if (speed > 15) {
    speed = 15;
  } else {
    speed = baseSpeed + 0.1 * Math.floor(scoreDisplay / 5);
  }

  if (!modeTest) {
    detectBeats(() => {
      generateObstacle(); // Génère un nouvel obstacle sur chaque beat détecté
    });
    drawObstacles();
  }

  checkObstaclesCollision();
  checkBonusCollision();
  updateInvincibility();
  updateSlow();

  // Gérer l'apparition du bonus à chaque multiple de 25 points
  if (score >= 25 && score % 25 === 0 && !bonus) {
    bonusType = "invincible";
    generateBonus();
  }
  if (score >= 30 && score % 20 === 0 && !bonus) {
    bonusType = "slow";
    generateBonus();
  }
  if (score >= 10 && score % 15 === 0 && !bonus) {
    bonusType = "addScoreBonus";
    generateBonus();
  }

  // Indicateur de bonus
  if (isInvincible && !isGameOver) {

    speedText.draw(context)
  }
  if (isSlow && !isGameOver) {

    let slow = new Texte({
      id: "slow",
      text: "SLOW",
      font: themeVars.jeu_texte,
      size: 24,
      x: canva.width / 2,
      y: 50,
      color: themeVars.jeu_alert,
      justify: "center"
    });
    slow.draw(context)
  }

  if (speed > 10 && !messageFinActive && !isGameOver) {

    let soFast = new Texte({
      id: "soFast",
      text: "YOU SO ARE FAST!!",
      font: themeVars.jeu_texte,
      size: 24,
      x: canva.width / 2,
      y: canva.height - 50,
      color: themeVars.jeu,
      justify: "center"
    });
    soFast.draw(context)
  }
  if (speed > 5 && speed < 10 && !messageFinActive && !isGameOver) {
    let goFast = new Texte({
      id: "goFast",
      text: "GO FAST!!",
      font: themeVars.jeu_texte,
      size: 24,
      x: canva.width / 2,
      y: canva.height - 50,
      color: themeVars.jeu,
      justify: "center"
    });
    goFast.draw(context)

  }
  if (speed < 4 && !messageFinActive && !isGameOver) {
    let slow = new Texte({
      id: "soSlow",
      text: "YOU ARE SO SLOW!!",
      font: themeVars.jeu_texte,
      size: 24,
      x: canva.width / 2,
      y: canva.height - 50,
      color: themeVars.jeu_alert,
      justify: "center"
    });
    slow.draw(context)

  }


  let scoreText = new Texte({
    id: "score",
    text: `Score: ${scoreDisplay}`,
    font: themeVars.jeu_texte,
    size: 16,
    x: 780,
    y: 50,
    color: themeVars.jeu,
    justify: "right"
  });

  let TempText = new Texte({
    id: "temp",
    text: `Temperature: ${Math.floor(temperatureData)}°C`,
    font: themeVars.jeu_texte,
    size: 16,
    x: 780,
    y: 30,
    color: themeVars.jeu,
    justify: "right"
  });

  scoreText.draw(context)
  TempText.draw(context)
  cityText.draw(context);

  

  if (messageFinActive) {
    drawEndMessage();
    
  }
}

function stopGame() {
  let scoreToSave = Math.max(...scoreTab);

  fetch("?action=jeu", {
    method: "POST",
    header: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify({
      score: scoreToSave,
    }),
  })
    .then((response) => response.text())
    .then((data) => {
      console.log("Score envoyé au serveur :", data);
    })
    .catch((error) => {
      console.error("Erreur lors de l'envoi du score :", error);
    });

  openModal(scoreToSave);
  cancelAnimationFrame(animationId);



  context.clearRect(0, 0, canva.width, canva.height);

  let bestScore = new Texte({
    id: "bestScore",
    text: "Your best Score: " + Math.max(...scoreTab),
    font: themeVars.jeu_texte,
    size: 24,
    x: canva.width / 2,
    y: canva.height / 2,
    color: themeVars.jeu,
    justify: "center"
  });

  bestScore.draw(context)

  let failed = new Texte({
    id: "failed",
    text: "You failed " + gameOver + " times",
    font: themeVars.jeu_texte,
    size: 16,
    x: canva.width / 2,
    y: canva.height / 2 + 40,
    color: themeVars.jeu_alert,
    justify: "center"
  });

  failed.draw(context)

}

//=======================COMMANDES======================
//=======================/////////======================
//=======================/////////======================

//Gestion du saut
var doubleJumpAvailable = true;

document.getElementById("jump").addEventListener("click", () => {
  if (ballY === groundY - 10 || isOnBlock) {
    velocityY = jumpPower;
    //soundJump.play();
    isOnBlock = false; // La balle quitte le bloc
    doubleJumpAvailable = true;
  } else if (doubleJumpAvailable) {
    velocityY = jumpPower + 2;
    doubleJumpAvailable = false;
  }

});


function restartGame() {
  //Réinitialise les variables
  score = 0;
  scoreDisplay = 0;
  speed = baseSpeed;
  isGameOver = false;
  obstacles = [];
  ballY = groundY;
  velocityY = 0;
  isOnBlock = false;
  requestAnimationFrame(gameLoop);
}

function gameLoop(currentTime) {
  while (currentTime - lastUpdateTime >= interval) {
    updateGame();
    lastUpdateTime += interval;
  }

  animationId = requestAnimationFrame(gameLoop);
}

document.getElementById("start").addEventListener("click", () => {
  // Démarrer le jeu après interaction
  document.getElementById("start").style.display = "none";
  document.getElementById("restart").style.display = "none";
  initializeAudio(backgroundMusic);
  updateCount(0);
  requestAnimationFrame(gameLoop);
  generateClouds();
});

document.getElementById("restart").addEventListener("click", () => {
  // Démarrer le jeu après interaction
  document.getElementById("restart").style.display = "none";
  initializeAudio(backgroundMusic);
  restartGame();
});


