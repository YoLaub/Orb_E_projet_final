document.addEventListener("DOMContentLoaded", function () {
  let terms = document.querySelectorAll(".ref");

  terms.forEach(term => {
    fetch("?action=rechercheR", {
      method: "POST",
      headers: {
        "Content-Type": "application/x-www-form-urlencoded",
      },
      body: `terme=${encodeURIComponent(term.value)}`,
    })
      .then(response => response.json())
      .then(reponses => {
        // On récupère la div .echange parente du input .ref
        const echangeContainer = term.closest(".echange-card");
        const reponseContainer = echangeContainer.querySelector(".reponse");

        reponseContainer.innerHTML = ""; // on vide l'existant

        if (reponses.length === 0) {
          reponseContainer.innerHTML = "<p>Aucune réponse trouvée.</p>";
          return;
        }

        reponses.forEach(reponse => {
          const reponseDiv = document.createElement("div");
          reponseDiv.classList.add("message-bulle", "admin");

          reponseDiv.innerHTML = `
            <div class="message-header">
              <p><strong>Réponse</strong></p>
            </div>
            <p class="message-text">${reponse.Message}</p>
            <small>En réponse au message du ${reponse.Date_message}</small>
          `;

          reponseContainer.appendChild(reponseDiv);
        });
      });
  });
});
