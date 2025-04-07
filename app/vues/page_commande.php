<section>
    <h1>Commande</h1>
    <div class="infoPerso">
        <?= $commande["formulaire"] ?>
    </div>
    <div>
        <h2>Votre panier</h2>
        <form class="info-form" action="./?action=commande" method="post">
            <input type="text" name="nomProduit" value="<?= $commande["infoProduit"][0]["nom"]; ?>"><br>
            <input type="text" name="prix" value="<?= $commande["infoProduit"][0]["prix"]; ?>"><br>
            <input type="number" name="quantite" value="1"><br>

            <button class="commander" type="submit">Commander !</button>
        </form>
        <img src="./publique/images/commande_ex.webp" alt="Concept art du noyau Orbe">
    </div>

</section>