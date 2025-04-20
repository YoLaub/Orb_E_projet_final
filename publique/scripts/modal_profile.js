// Fonction pour transformer les données brutes en un format groupé par commande
function transformerDonnees(rawData) {
  if (!rawData || rawData.length === 0) return null;

  // Objet pour stocker les commandes regroupées par id_commande
  const commandes = {};

  rawData.forEach(item => {
    const id = item.id_commande;

    // Si l'ID n'existe pas encore, on initialise l'objet
    if (!commandes[id]) {
      commandes[id] = {
        produits: [], // Liste des produits pour cette commande
        infos: {      // Informations générales sur la commande
          id_commande: item.id_commande,
          date_heure: item.date_heure,
          montant_total: parseFloat(item.montant_total),
          statut: item.statut
        }
      };
    }

    // Ajout du produit courant à la liste des produits de cette commande
    commandes[id].produits.push({
      nom_produit: item.nom_produit,
      description: item.description,
      prix: parseFloat(item.prix),
      quantité: item.quantité,
      total_produit: parseFloat(item.total_produit)
    });
  });

  // Retourne un tableau de commandes (au lieu d'un objet avec des clés dynamiques)
  return Object.values(commandes);
}

// Génère une version carte simplifiée d'une commande (utile pour mobile)
function createCommandeCard(details) {
  let card = document.createElement("div");
  card.className = "commande_card"; // classe CSS pour styliser la carte

  let liste = document.createElement("ul");

  // Affiche uniquement le premier produit de la commande (version condensée)
  liste.innerHTML = `
    <li>${details.produits[0].nom_produit}</li> 
    <li>Quantité: ${details.produits[0].quantité}</li>
    <li>Prix total: ${details.infos.montant_total.toFixed(2)} €</li>
  `;

  card.appendChild(liste);

  return card;
}

// Génère une table complète avec tous les produits d'une commande
function createCommandeTable(details) {
  const table = document.createElement("table");
  table.className = "commande-table"; // classe CSS pour le style

  // Création de l'en-tête du tableau
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

  // Corps du tableau avec chaque produit
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

  // Pied du tableau avec le total global de la commande
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

// Exécute une fois que tout le DOM est chargé
document.addEventListener("DOMContentLoaded", () => {

  // Ouverture des modales quand on clique sur les boutons avec l'attribut data-modal-target
  document.querySelectorAll('[data-modal-target]').forEach(btn => {
    btn.addEventListener("click", (e) => {
      const modal = document.querySelector(btn.dataset.modalTarget);
      if (modal) modal.style.display = "flex"; // rend visible la modale
    });
  });

  // Fermeture des modales via les boutons avec l'attribut data-close
  document.querySelectorAll('[data-close]').forEach(closeBtn => {
    closeBtn.addEventListener("click", () => {
      closeBtn.closest(".modal-overlay").style.display = "none"; // masque la modale parente
    });
  });

  // Fermeture des modales en cliquant en dehors du contenu (overlay)
  document.querySelectorAll(".modal-overlay").forEach(modal => {
    modal.addEventListener("click", (e) => {
      if (e.target === modal) modal.style.display = "none"; // masque si clic en dehors de la modale
    });
  });

  // Récupère la largeur de la fenêtre (utilisé pour adapter le rendu)
  let window_width = window.innerWidth;

  // Récupération des données brutes JSON encodées dans un élément <script>
  let dataScript = document.getElementById("detail_commande");
  let rawData = JSON.parse(dataScript.textContent);

  // Transformation des données pour traitement
  let commandes = transformerDonnees(rawData);

  // Élément dans lequel on insère les commandes à afficher
  let container = document.getElementById("commande_contenair");

  // Affichage adapté à la taille de l’écran : version tableau (desktop) ou carte (mobile)
  if (window_width > 768) {
    commandes.forEach(details => {
      // Titre de la commande avec ID, date et statut
      let titre = document.createElement("h3");
      titre.textContent = `Commande #${details.infos.id_commande} - ${details.infos.date_heure} (${details.infos.statut})`;
      container.appendChild(titre);

      // Affichage sous forme de tableau
      container.appendChild(createCommandeTable(details));
    });
  } else {
    commandes.forEach(details => {
      // Titre de la commande
      let titre = document.createElement("h3");
      titre.textContent = `Commande #${details.infos.id_commande} - ${details.infos.date_heure} (${details.infos.statut})`;
      container.appendChild(titre);

      // Affichage sous forme de carte
      container.appendChild(createCommandeCard(details));
    });
  }

});
