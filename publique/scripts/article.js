// Sélection de tous les éléments avec la classe "icon" (icônes SVG pour les boutons d'expansion)
let svgIcon = document.querySelectorAll('.icon');

// Sélection de tous les éléments avec la classe "article-content" (contenu à afficher ou masquer)
let content = document.querySelectorAll('.article-content');

// Définition du SVG pour l'icône "+" (utilisé pour indiquer un contenu masqué)
let svgIconPlus = `
<svg  class="bi bi-chevron-double-down" viewBox="0 0 16 16">
  <path fill-rule="evenodd" d="M1.646 6.646a.5.5 0 0 1 .708 0L8 12.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708"/>
  <path fill-rule="evenodd" d="M1.646 2.646a.5.5 0 0 1 .708 0L8 8.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708"/>
</svg>
`;

// Définition du SVG pour l'icône "−" (utilisé pour indiquer un contenu affiché)
let svgIconMoins = `
<svg class="bi bi-chevron-double-up" viewBox="0 0 16 16">
  <path fill-rule="evenodd" d="M7.646 2.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1-.708.708L8 3.707 2.354 9.354a.5.5 0 1 1-.708-.708z"/>
  <path fill-rule="evenodd" d="M7.646 6.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1-.708.708L8 7.707l-5.646 5.647a.5.5 0 0 1-.708-.708z"/>
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

    } else {
        // Sinon, on l'affiche et on change l'icône en "−"
        content[0].style.maxHeight = "100%";
        svgIcon[0].innerHTML = svgIconMoins;

    }
});

// Gestion du clic sur la deuxième icône : même logique que ci-dessus
svgIcon[1].addEventListener("click", function () {
    if (content[1].style.maxHeight) {
        content[1].style.maxHeight = null;
        svgIcon[1].innerHTML = svgIconPlus;

    } else {
        content[1].style.maxHeight = content[1].scrollHeight + "px";
        svgIcon[1].innerHTML = svgIconMoins;

    }
});

// Gestion du clic sur la troisième icône : même logique que ci-dessus
svgIcon[2].addEventListener("click", function () {
    if (content[2].style.maxHeight) {
        content[2].style.maxHeight = null;
        svgIcon[2].innerHTML = svgIconPlus;

    } else {
        content[2].style.maxHeight = content[2].scrollHeight + "px";
        svgIcon[2].innerHTML = svgIconMoins;

    }
});
// Gestion du clic sur la troisième icône : même logique que ci-dessus
svgIcon[3].addEventListener("click", function () {
    if (content[3].style.maxHeight) {
        content[3].style.maxHeight = null;
        svgIcon[3].innerHTML = svgIconPlus;

    } else {
        content[3].style.maxHeight = content[3].scrollHeight + "px";
        svgIcon[3].innerHTML = svgIconMoins;

    }
});

//::::::::::::::::::::::::::::::::
// MODAL
//::::::::::::::::::::::::::::::::
let commandeModal = document.querySelector("#commandeModal");




function hideModal(selector) {
    selector.style.display = "none";

}

if (commandeModal) {
    setTimeout(() => hideModal(commandeModal), 2000);
}
