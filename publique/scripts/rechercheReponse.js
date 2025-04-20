// Fonction de nettoyage pour éviter les injections XSS en échappant les caractères spéciaux HTML
function sanitize(str) {
  return String(str)
    .replace(/&/g, "&amp;")
    .replace(/</g, "&lt;")
    .replace(/>/g, "&gt;")
    .replace(/"/g, "&quot;")
    .replace(/'/g, "&#039;");
}

// Exécute le code une fois que le DOM est complètement chargé
document.addEventListener("DOMContentLoaded", function () {
  // Sélectionne tous les éléments avec la classe .ref (références aux messages utilisateurs)
  let terms = document.querySelectorAll(".ref");

  // Parcours de chaque terme (input .ref)
  terms.forEach(term => {
    // Envoie une requête POST vers l'action "rechercheR" avec la valeur du champ comme paramètre
    fetch("?action=rechercheR", {
      method: "POST",
      headers: {
        "Content-Type": "application/x-www-form-urlencoded",
      },
      body: `terme=${encodeURIComponent(term.value)}`,
    })
      // Récupère la réponse au format JSON
      .then(response => response.json())
      .then(reponses => {
        // Récupère le conteneur .echange-card parent de l'élément courant
        const echangeContainer = term.closest(".echange-card");
        // Récupère la div .reponse à l'intérieur de ce conteneur
        const reponseContainer = echangeContainer.querySelector(".reponse");

        // Vide le contenu actuel du conteneur de réponses
        reponseContainer.innerHTML = "";

        // Si aucune réponse n'est trouvée, affiche un message et quitte la fonction
        if (reponses.length === 0) {
          reponseContainer.innerHTML = "<p>Aucune réponse trouvée.</p>";
          return;
        }

        // Parcours de chaque réponse reçue
        reponses.forEach(reponse => {
          // Création d'une div contenant la réponse, avec classes pour le style
          const reponseDiv = document.createElement("div");
          reponseDiv.classList.add("message-bulle", "admin");

          // Construction du contenu HTML de la réponse, en sécurisant les données avec sanitize
          reponseDiv.innerHTML = `
            <div class="message-header">
              <p><strong>Réponse</strong></p>
            </div>
            <p class="message-text">${sanitize(reponse.Message)}</p>
            <small>En réponse au message du ${sanitize(reponse.Date_message)}</small>
          `;

          // Ajout de la réponse dans le conteneur correspondant
          reponseContainer.appendChild(reponseDiv);
        });
      });
  });
});
