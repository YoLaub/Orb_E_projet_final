function transformerDonnees(rawData) {
  if (!rawData || rawData.length === 0) return null;

  // Regrouper par id_commande
  const commandes = {};

  rawData.forEach(item => {
    const id = item.id_commande;

    if (!commandes[id]) {
      commandes[id] = {
        produits: [],
        infos: {
          id_commande: item.id_commande,
          date_heure: item.date_heure,
          montant_total: parseFloat(item.montant_total),
          statut: item.statut
        }
      };
    }

    commandes[id].produits.push({
      nom_produit: item.nom_produit,
      description: item.description,
      prix: parseFloat(item.prix),
      quantité: item.quantité,
      total_produit: parseFloat(item.total_produit)
    });
  });

  return Object.values(commandes); // tableau de commandes
}

function createCommandeCard(details) {
  let card = document.createElement("div");
  card.className = "commande_card";
  let liste = document.createElement("ul");

  liste.innerHTML = `
    <li>${details.produits[0].nom_produit}</li> 
    <li>Quantité: ${details.produits[0].quantité}</li>
    <li>Prix total: ${details.infos.montant_total.toFixed(2)} €</li>
    `;

    card.appendChild(liste);

    return card;

}


function createCommandeTable(details) {
  const table = document.createElement("table");
  table.className = "commande-table";

  const thead = document.createElement("thead");
  thead.innerHTML = `
      <tr>
          <th>Produit</th>
          <th>Description</th>
          <th>Prix</th>
          <th>Qté</th>
          <th>Total</th>
      </tr>
  `;
  table.appendChild(thead);

  const tbody = document.createElement("tbody");

  details.produits.forEach(produit => {
    const tr = document.createElement("tr");
    tr.innerHTML = `
          <td>${produit.nom_produit}</td>
          <td>${produit.description}</td>
          <td>${produit.prix.toFixed(2)} €</td>
          <td>${produit.quantité}</td>
          <td>${produit.total_produit.toFixed(2)} €</td>
      `;
    tbody.appendChild(tr);
  });

  table.appendChild(tbody);

  const tfoot = document.createElement("tfoot");
  const trFoot = document.createElement("tr");
  trFoot.innerHTML = `
      <td colspan="4"><strong>Total Commande</strong></td>
      <td><strong>${details.infos.montant_total.toFixed(2)} €</strong></td>
  `;
  tfoot.appendChild(trFoot);
  table.appendChild(tfoot);

  return table;
}



document.addEventListener("DOMContentLoaded", () => {
  // Ouvrir la modal
  document.querySelectorAll('[data-modal-target]').forEach(btn => {
    btn.addEventListener("click", (e) => {
      const modal = document.querySelector(btn.dataset.modalTarget);
      if (modal) modal.style.display = "flex";
    });
  });

  // Fermer la modal via le bouton close
  document.querySelectorAll('[data-close]').forEach(closeBtn => {
    closeBtn.addEventListener("click", () => {
      closeBtn.closest(".modal-overlay").style.display = "none";
    });
  });

  // Fermer la modal en cliquant en dehors du contenu
  document.querySelectorAll(".modal-overlay").forEach(modal => {
    modal.addEventListener("click", (e) => {
      if (e.target === modal) modal.style.display = "none";
    });
  });

  let window_width = window.innerWidth;
  let dataScript = document.getElementById("detail_commande");
  let rawData = JSON.parse(dataScript.textContent);
  let commandes = transformerDonnees(rawData);

  let container = document.getElementById("commande_contenair");

if (window_width > 768) {

  commandes.forEach(details => {
    // titre optionnel
    let titre = document.createElement("h3");
    titre.textContent = `Commande #${details.infos.id_commande} - ${details.infos.date_heure} (${details.infos.statut})`;
    container.appendChild(titre);

    container.appendChild(createCommandeTable(details));
  });
}else{

  commandes.forEach(details => {
    // titre optionnel
    let titre = document.createElement("h3");
    titre.textContent = `Commande #${details.infos.id_commande} - ${details.infos.date_heure} (${details.infos.statut})`;
    container.appendChild(titre);

    container.appendChild(createCommandeCard(details));
  });
}






});






