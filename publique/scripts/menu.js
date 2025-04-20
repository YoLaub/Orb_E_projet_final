// Exécute le script uniquement une fois que le DOM est complètement chargé
document.addEventListener("DOMContentLoaded", function () {

  // Sélectionne le bouton de menu (menu hamburger ou icône de bascule)
  let menuToggle = document.querySelector(".menu-toggle");

  // Sélectionne la balise <nav> contenant les liens de navigation
  let nav = document.querySelector("nav");

  // Référence au corps du document, utilisé pour gérer des effets globaux (ex: scroll lock)
  let body = document.body;

  // Bascule l'ouverture/fermeture du menu au clic sur le bouton
  menuToggle.addEventListener("click", function () {
    nav.classList.toggle("open");        // Ajoute ou retire la classe "open" sur la navigation
    body.classList.toggle("menu-open");  // Ajoute ou retire une classe globale sur le body (utile pour les effets visuels ou le blocage du scroll)
  });

  // Sélectionne tous les liens de navigation du menu principal
  let links = document.querySelectorAll("#main-nav li a");

  // Boucle sur chaque lien pour vérifier s'il correspond à l'URL actuelle
  links.forEach((link) => {
    if (link.href == window.location.href) {
       link.classList.add("active"); // Ajoute la classe "active" au lien correspondant à la page en cours
    }
  });

});
