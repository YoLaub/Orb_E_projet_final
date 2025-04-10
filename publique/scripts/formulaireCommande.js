document.addEventListener("DOMContentLoaded", function () {

    // Récupérer les éléments du formulaire
    let form = document.getElementById('commandeForm');
    let showModalBtn = document.getElementById('showModal');
    let modal = document.getElementById('confirmationModal');
    let confirmBtn = document.getElementById('confirmBtn');
    let cancelBtn = document.getElementById('cancelBtn');

    // Récupérer les éléments de la modale pour afficher les infos
    let confirmNomProduit = document.getElementById('confirmNomProduit');
    let confirmPrix = document.getElementById('confirmPrix');
    let confirmQuantite = document.getElementById('confirmQuantite');

    // Afficher la modale avec les informations du produit
    showModalBtn.addEventListener('click', function (e) {
        e.preventDefault();  // Empêcher la soumission du formulaire
        let quantite = document.querySelector('input[name="quantite"]').value;
        let nomProduit = document.querySelector('input[name="nomProduit"]').value;
        let prix = document.querySelector('input[name="prix"]').value;

        // Vérifier la validité de la quantité
        if (quantite < 1 || isNaN(quantite)) {
            alert('La quantité doit être un nombre valide et supérieur ou égal à 1.');
            return;
        }

        // Remplir la modale avec les informations
        confirmNomProduit.textContent = nomProduit;
        confirmPrix.textContent = prix;
        confirmQuantite.textContent = quantite;

        // Afficher la modale
        modal.style.display = 'flex';
    });

    // Annuler la commande et fermer la modale
    cancelBtn.addEventListener('click', function () {
        modal.style.display = 'none';
    });

    // Confirmer la commande et soumettre le formulaire
    confirmBtn.addEventListener('click', function () {
        form.submit();  // Soumettre le formulaire
        modal.style.display = 'none';  // Fermer la modale
    });

});