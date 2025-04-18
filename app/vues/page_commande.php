
<section>
    <h1>Commande</h1>
    <div class="infoPerso info-form">
        <?= $commande["formulaire"] ?>
    </div>
    <div class="info-form">
        <h2>Votre panier</h2>
        <form id="commandeForm" action="ajouterCommande" method="post">
            <input type="text" name="nomProduit" value="<?= $commande["infoProduit"][0]["nom"]; ?>" readonly><br>
            <input type="text" name="prix" value="<?= $commande["infoProduit"][0]["prix"]; ?>" readonly><br>
            <input id="commandeForm" type="number" name="quantite" value="1"><br>

            <button id="showModal" class="commander" type="submit">Commander !</button>
        </form>
        <img src="./publique/images/commande_ex.webp" alt="Concept art du noyau Orbe">
    </div>

</section>

<!-- Modale de confirmation -->
<div id="confirmationModal" class="modal" style="display: none;">
    <div class="modal-content">
        <h2>Confirmer votre commande</h2>
        <p>Êtes-vous sûr de vouloir commander ce produit avec la quantité suivante ?</p>
        <p><strong id="confirmNomProduit"></strong></p>
        <p>Prix : <span id="confirmPrix"></span></p>
        <p>Quantité : <span id="confirmQuantite"></span></p>

        <button id="confirmBtn">Confirmer</button>
        <button id="cancelBtn">Annuler</button>
    </div>
</div>