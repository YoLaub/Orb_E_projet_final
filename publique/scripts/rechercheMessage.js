// Fonction pour sécuriser les chaînes de caractères en échappant les caractères spéciaux HTML
function sanitize(str) {
  return String(str)
    .replace(/&/g, "&amp;")
    .replace(/</g, "&lt;")
    .replace(/>/g, "&gt;")
    .replace(/"/g, "&quot;")
    .replace(/'/g, "&#039;");
}

// Écouteur d'événement sur la barre de recherche des messages par texte
document.getElementById("rechercheMessage").addEventListener("input", function () {
  let terme = this.value;

  // Requête POST vers le serveur avec le terme de recherche
  fetch("?action=rechercheM", {
    method: "POST",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded",
    },
    body: `terme=${encodeURIComponent(terme)}`,
  })
    .then((response) => response.json())
    .then((data) => {
      const conteneur = document.getElementById("resultatsRechercheMessage");
      conteneur.innerHTML = ""; // Réinitialisation du conteneur

      // Aucun résultat trouvé
      if (data.length === 0) {
        conteneur.innerHTML = "<p>Aucun message trouvé.</p>";
        return;
      }

      // Parcours des messages trouvés
      data.forEach((message) => {
        const div = document.createElement("div");
        div.classList.add("message-bulle", "user");

        // Insertion des données du message + formulaire de réponse
        div.innerHTML = `
          <div class="message-header">
            <strong>${sanitize(message.nom)}</strong>
            <strong>${sanitize(message.email)}</strong>
            <span>${message.created_at}</span>
          </div>
          <p class="message-text">${sanitize(message.message)}</p>
          <p><small>${sanitize(message.email)} — ID: ${message.id_contact}</small></p>
          
          <form action="./?action=messagerie" method="post" class="formMessagerie">
            <input type="hidden" name="id_contact" required value="${message.id_contact}">
            <label for="reponse-${message.id_contact}">Votre réponse :</label>
            <textarea name="reponse" id="reponse-${message.id_contact}" rows="4" required placeholder="Tapez votre message ici..."></textarea>
            <button type="submit">Envoyer</button>
          </form>

          <div class="messageR" id="messageR-${message.id_contact}"></div>
        `;

        conteneur.appendChild(div); // Ajout au DOM

        // Requête pour rechercher les réponses associées au message
        fetch("?action=rechercheR", {
          method: "POST",
          headers: {
            "Content-Type": "application/x-www-form-urlencoded",
          },
          body: `terme=${encodeURIComponent(message.id_contact)}`,
        })
          .then((response) => response.json())
          .then((reponses) => {
            const reponseContainer = div.querySelector(`#messageR-${message.id_contact}`);
            reponseContainer.innerHTML = ""; // Réinitialisation du conteneur

            // Aucune réponse trouvée
            if (reponses.length === 0) {
              reponseContainer.innerHTML = "<p>Aucune réponse trouvée.</p>";
              return;
            }

            // Parcours des réponses
            reponses.forEach((reponse) => {
              const reponseDiv = document.createElement("div");
              reponseDiv.classList.add("message-bulle", "admin");

              // Affichage des données de la réponse
              reponseDiv.innerHTML = `
                <div class="message-header">
                  <p><strong>Réponse</strong></p>
                  <strong>Ref #${sanitize(reponse.Ref)}</strong>
                </div>
                <p class="message-text">${sanitize(reponse.Message)}</p>
                <small>En réponse au message ID ${reponse.Date_message}</small>
              `;

              reponseContainer.appendChild(reponseDiv); // Ajout de la réponse au DOM
            });
          });
      });
    });
});

// Écouteur d’événement sur le champ de recherche par date
document.getElementById("rechercheMessageDate").addEventListener("input", function () {
  const terme = this.value;

  // Requête POST pour filtrer les messages par date
  fetch("?action=rechercheMD", {
    method: "POST",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded",
    },
    body: `terme=${encodeURIComponent(terme)}`,
  })
    .then((response) => response.json())
    .then((data) => {
      const conteneur = document.getElementById("resultatsRechercheMessage");
      conteneur.innerHTML = ""; // Réinitialisation du conteneur

      // Aucun résultat trouvé
      if (data.length === 0) {
        conteneur.innerHTML = "<p>Aucun message trouvé.</p>";
        return;
      }

      // Affichage de chaque message trouvé par date
      data.forEach((message) => {
        const div = document.createElement("div");
        div.classList.add("message-bulle", "user");

        // Construction de la carte du message
        div.innerHTML = `
          <div class="message-header">
            <strong>${sanitize(message.nom)}</strong>
            <span>${message.created_at}</span>
          </div>
          <p class="message-text">${sanitize(message.message)}</p>
          <small>${sanitize(message.email)} — ID: ${message.id_contact}</small>

          <form action="./?action=messagerie" method="post">
            <input type="hidden" name="id_contact" required value="${message.id_contact}">
            <label for="reponse-${message.id_contact}">Votre réponse :</label>
            <textarea name="reponse" id="reponse-${message.id_contact}" rows="4" required placeholder="Tapez votre message ici..."></textarea>
            <button type="submit">Envoyer</button>
          </form>

          <div class="messageR" id="messageR-${message.id_contact}"></div>
        `;

        conteneur.appendChild(div); // Ajout au DOM

        // Requête pour charger les réponses liées au message
        fetch("?action=rechercheR", {
          method: "POST",
          headers: {
            "Content-Type": "application/x-www-form-urlencoded",
          },
          body: `terme=${encodeURIComponent(message.id_contact)}`,
        })
          .then((response) => response.json())
          .then((reponses) => {
            const reponseContainer = div.querySelector(`#messageR-${message.id_contact}`);
            reponseContainer.innerHTML = ""; // Réinitialisation

            // Aucune réponse
            if (reponses.length === 0) {
              reponseContainer.innerHTML = "<p>Aucune réponse trouvée.</p>";
              return;
            }

            // Affichage des réponses
            reponses.forEach((reponse) => {
              const reponseDiv = document.createElement("div");
              reponseDiv.classList.add("message-bulle", "admin");

              reponseDiv.innerHTML = `
                <div class="message-header">
                  <p><strong>Réponse</strong></p>
                  <strong>Ref #${sanitize(reponse.Ref)}</strong>
                </div>
                <p class="message-text">${sanitize(reponse.Message)}</p>
                <small>En réponse au message ID ${reponse.Date_message}</small>
              `;

              reponseContainer.appendChild(reponseDiv); // Ajout de la réponse
            });
          });
      });
    });
});
