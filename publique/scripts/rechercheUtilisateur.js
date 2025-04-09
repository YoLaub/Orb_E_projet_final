document.getElementById("rechercheUtilisateur").addEventListener("input", function () {
    const terme = this.value;

    fetch("?action=rechercheU", {
      method: "POST",
      headers: {
        "Content-Type": "application/x-www-form-urlencoded",
      },
      body: `terme=${encodeURIComponent(terme)}`,
    })
      .then((response) => response.json())
      .then((data) => {
        const conteneur = document.getElementById("resultatsRecherche");
        conteneur.innerHTML = "";

        if (data.length === 0) {
          conteneur.innerHTML = "<p>Aucun utilisateur trouvé.</p>";
          return;
        }

        data.forEach((utilisateur) => {
            const div = document.createElement("div");
            div.classList.add("user-card");
          
            div.innerHTML = `
              <p><strong>Email :</strong> ${utilisateur.email}</p>
              <p><strong>Nom :</strong> ${utilisateur.nom || "Non renseigné"}</p>
              <p><strong>Prénom :</strong> ${utilisateur.prenom || "Non renseigné"}</p>        
              <form action="./?action=suppression" method="post" class="form-inline">
                <input type="hidden" name="id_utilisateur" value="${utilisateur.id_utilisateur}">
                <button type="submit">Supprimer</button>
              </form>
            `;
          
            conteneur.appendChild(div);
          });
      });
  });
