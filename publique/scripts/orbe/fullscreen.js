// Récupération de l'élément représentant la zone de jeu (console)
let game = document.getElementById("console");

// Récupération du bouton qui déclenche le passage en plein écran
let fullScreen = document.getElementById("full");

// Récupération du conteneur des contrôles (non utilisé dans ce bloc mais présent pour d'éventuelles actions futures)
let control = document.querySelector(".control");

// Insertion du contenu SVG dans le bouton "plein écran"
// Ce SVG représente l'icône de passage en plein écran
fullScreen.innerHTML = `<svg  fill="currentColor" class= "full" viewBox="0 0 16 16">
  <path fill-rule="evenodd" d="M5.828 10.172a.5.5 0 0 0-.707 0l-4.096 4.096V11.5a.5.5 0 0 0-1 0v3.975a.5.5 0 0 0 .5.5H4.5a.5.5 0 0 0 0-1H1.732l4.096-4.096a.5.5 0 0 0 0-.707m4.344 0a.5.5 0 0 1 .707 0l4.096 4.096V11.5a.5.5 0 1 1 1 0v3.975a.5.5 0 0 1-.5.5H11.5a.5.5 0 0 1 0-1h2.768l-4.096-4.096a.5.5 0 0 1 0-.707m0-4.344a.5.5 0 0 0 .707 0l4.096-4.096V4.5a.5.5 0 1 0 1 0V.525a.5.5 0 0 0-.5-.5H11.5a.5.5 0 0 0 0 1h2.768l-4.096 4.096a.5.5 0 0 0 0 .707m-4.344 0a.5.5 0 0 1-.707 0L1.025 1.732V4.5a.5.5 0 0 1-1 0V.525a.5.5 0 0 1 .5-.5H4.5a.5.5 0 0 1 0 1H1.732l4.096 4.096a.5.5 0 0 1 0 .707"/>
</svg>`;

// Ajout d'un écouteur d'événement au clic sur le bouton "plein écran"
fullScreen.addEventListener("click", function(){
  // Vérifie si aucun élément n'est actuellement en mode plein écran
  if (!document.fullscreenElement) {
    // Si aucun, on passe la console (zone de jeu) en plein écran
    game.requestFullscreen();
  } else {
    // Sinon, on quitte le mode plein écran
    document.exitFullscreen();
  }
});
