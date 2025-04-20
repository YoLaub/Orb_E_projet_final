// Attente du chargement complet du DOM avant d'exécuter le script
document.addEventListener("DOMContentLoaded", function () {

  // Récupération du formulaire de contact
  let form = document.getElementById("contact");

  // Zone d'affichage des messages d'erreur
  let error = document.querySelector(".errorMessage");

  // Bouton d'envoi (élément utilisé pour afficher un message de statut)
  let send = document.querySelector(".send");

  // Écoute de l'événement de soumission du formulaire
  form.addEventListener("submit", function (e) {
    e.preventDefault(); // Empêche l'envoi automatique du formulaire

    // Récupération des valeurs saisies par l'utilisateur
    let nom = document.querySelector('input[name="nom"]').value;
    let email = document.querySelector('input[name="email"]').value;
    let message = document.querySelector('textarea[name="message"]').value;
    let term = document.querySelector("#term");

    let valid = true; // Variable de validation globale
    let errorMessage = ""; // Message d'erreur à afficher si nécessaire

    // Vérification de l'adresse email avec une expression régulière
    let emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailPattern.test(email)) {
      valid = false;
      errorMessage = "Veuillez entrer une adresse email valide.";
    }

    // Vérifie que le message contient au moins 10 caractères
    if (message.length < 10) {
      valid = false;
      errorMessage = "Minimum 10 caractères";
    }

    // Vérifie que le nom contient au moins 2 caractères
    if (nom.length < 2) {
      valid = false;
      errorMessage = "Minimum 2 caractères";
    }

    // Vérifie si les conditions d'utilisation sont cochées
    if (!term.checked) {
      valid = false;
      errorMessage = "Veuillez cocher les conditions d'utilisation";
    }

    // Affichage du message d'erreur si un champ est invalide
    if (!valid) {
      error.style.display = "block";
      error.textContent = errorMessage;
    } else {
      // Si tous les champs sont valides, masque l'erreur et affiche un message de progression
      error.style.display = "none";
      send.innerHTML = "Envoi en cours... ✈️";

      // Mise à jour du message après 2 secondes pour indiquer l'envoi
      setTimeout(() => {
        send.innerHTML = "Message envoyé !";
      }, 2000);

      // Soumission réelle du formulaire après 3 secondes
      setTimeout(() => {
        form.submit();
      }, 3000);
    }
  });

  // Gestion du compteur de caractères pour le champ message
  let infoMessage = document.querySelector(".maxChar"); // Zone de compteur
  let maxChar = 300; // Nombre maximal de caractères autorisés
  let inputSubmit = document.querySelector('input[name="envoyer"]'); // Bouton de soumission

  // Événement sur la saisie dans le champ message
  document.getElementById("message").addEventListener("input", function (e) {
    
    // Mise à jour du compteur en direct
    infoMessage.innerHTML = `${this.value.length}/ ${maxChar}`;

    // Si le nombre maximal de caractères est atteint
    if (this.value.length >= maxChar) {
      e.preventDefault();
      valid = false;
      infoMessage.innerHTML = "";
      infoMessage.innerHTML = "Max caractère atteind !";

      // Cache le bouton de soumission pour empêcher l'envoi
      inputSubmit.style.display = "none";
    } else {
      // Réaffiche le bouton si la limite n'est pas atteinte
      inputSubmit.style.display = "block";
    }
  });

});
