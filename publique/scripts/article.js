// Sélection de tous les éléments avec la classe "icon" (icônes SVG pour les boutons d'expansion)
let svgIcon = document.querySelectorAll('.icon');

// Sélection de tous les éléments avec la classe "article-content" (contenu à afficher ou masquer)
let content = document.querySelectorAll('.article-content');

// Définition du SVG pour l'icône "+" (utilisé pour indiquer un contenu masqué)
let svgIconPlus =  `
<svg class="bi bi-plus-lg" viewBox="0 0 16 16"> 
  <path fill-rule="evenodd" d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2"/>
</svg>
`;

// Définition du SVG pour l'icône "−" (utilisé pour indiquer un contenu affiché)
let svgIconMoins = `
<svg class="bi bi-dash-lg" viewBox="0 0 16 16">
  <path fill-rule="evenodd" d="M2 8a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11A.5.5 0 0 1 2 8"/>
</svg>
`;

// Initialisation de toutes les icônes avec le SVG "+"
svgIcon.forEach(element => {
    element.innerHTML = svgIconPlus;
});

// Variable de comptage, inutilisée ici mais conservée pour debug ou extension future
let count = 0;

// Gestion du clic sur la première icône : affiche ou masque le premier contenu
svgIcon[0].addEventListener("click", function () {
    if (content[0].style.maxHeight) {
        // Si le contenu est déjà visible, on le masque
        content[0].style.maxHeight = null;
        svgIcon[0].innerHTML = svgIconPlus;
        console.log(count);
    } else {
        // Sinon, on l'affiche et on change l'icône en "−"
        content[0].style.maxHeight = content[0].scrollHeight + "px";
        svgIcon[0].innerHTML = svgIconMoins;
        console.log(count);
    }
});

// Gestion du clic sur la deuxième icône : même logique que ci-dessus
svgIcon[1].addEventListener("click", function () {
    if (content[1].style.maxHeight) {
        content[1].style.maxHeight = null;
        svgIcon[1].innerHTML = svgIconPlus;
        console.log(count);
    } else {
        content[1].style.maxHeight = content[1].scrollHeight + "px";
        svgIcon[1].innerHTML = svgIconMoins;
        console.log(count);
    }
});

// Gestion du clic sur la troisième icône : même logique que ci-dessus
svgIcon[2].addEventListener("click", function () {
    if (content[2].style.maxHeight) {
        content[2].style.maxHeight = null;
        svgIcon[2].innerHTML = svgIconPlus;
        console.log(count);
    } else {
        content[2].style.maxHeight = content[2].scrollHeight + "px";
        svgIcon[2].innerHTML = svgIconMoins;
        console.log(count);
    }
});
