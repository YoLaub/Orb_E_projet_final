// Ajout d'un écouteur d'événement sur le champ de recherche d'utilisateur
// L'événement "input" se déclenche à chaque modification du contenu du champ
document.getElementById("rechercheUtilisateur").addEventListener("input", function () {
  // Récupération de la valeur saisie dans le champ
  const terme = this.value;

  // Envoi d'une requête POST vers le serveur pour rechercher des utilisateurs correspondant au terme saisi
  fetch("?action=rechercheU", {
    method: "POST",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded",
    },
    // Encodage du terme pour éviter les problèmes de caractères spéciaux dans la requête
    body: `terme=${encodeURIComponent(terme)}`,
  })
    // Conversion de la réponse reçue en JSON
    .then((response) => response.json())
    .then((data) => {
      // Sélection du conteneur où seront affichés les résultats de la recherche
      const conteneur = document.getElementById("resultatsRecherche");
      // Réinitialisation du contenu du conteneur avant affichage des nouveaux résultats
      conteneur.innerHTML = "";

      // Si aucun utilisateur trouvé, afficher un message par défaut
      if (data.length === 0) {
        conteneur.innerHTML = "<p>Aucun utilisateur trouvé.</p>";
        return;
      }

      // Parcours des utilisateurs trouvés
      data.forEach((utilisateur) => {
        // Création d'un élément <div> pour chaque utilisateur
        const div = document.createElement("div");
        div.classList.add("user-card"); // Ajout d'une classe CSS pour le style

        // Insertion du contenu HTML dans la carte utilisateur
        div.innerHTML = `
          <p><strong>Email :</strong> ${utilisateur.email}</p>
          <p><strong>Nom :</strong> ${utilisateur.nom || "Non renseigné"}</p>
          <p><strong>Prénom :</strong> ${utilisateur.prenom || "Non renseigné"}</p>        
          <form action="./?action=suppression" method="post" class="form-inline">
            <input type="hidden" name="id_utilisateur" value="${utilisateur.id_utilisateur}">
            <button type="submit">Supprimer</button>
          </form>
        `;

        // Ajout de la carte utilisateur dans le conteneur
        conteneur.appendChild(div);
      });
    });
});
