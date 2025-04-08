<section>
<h1>Accès BO OK</h1>
<div class="utilisateur">
<h2>Nombre d'utilisateurs: <?= $commande["lesUtilisateurs"][0]["count(*)"] ?></h2>
<h2>Commande: <?= count($commande["commande"]) ?></h2>
<h2>Point total générer: <?=$commande["total_score"][0]["total_points"]?></h2>

</div>


    <article>

    <h2>Commande en cours</h2>


<?php foreach ($commande["commande"] as $idCommande => $infos): ?>
    <div class="commande-card">
        <h3>Commande #<?= $idCommande ?></h3>
        <p><strong>Date :</strong> <?= $infos["date_heure"] ?></p>
        <p><strong>Statut :</strong> <?= $infos["statut"] ?></p>
        <form action="?action = accueilBo" method ="post">
            <input type="hidden" name="idCommande" value ="<?= $idCommande ?>">
        <select name="statut" id="statut">
        <?php foreach ($commande["select"] as $value): ?>
            <option value="<?= $infos["statut"] ?>">
            <?= htmlspecialchars($value); ?>
            </option>
        <?php endforeach; ?>
        </select>
        <button type="submit">Modifier</button>
        </form>
        

        <?php foreach ($infos["produits"] as $produit): ?>
            <div class="produit">
                <p><strong><?= htmlspecialchars($produit["nom"]) ?></strong></p>
                <p><?= htmlspecialchars($produit["description"]) ?></p>
                <p>Prix : <?= number_format($produit["prix"], 2) ?> €</p>
                <p>Quantité : <?= $produit["quantité"] ?></p>
                <p>Total : <?= number_format($produit["total"], 2) ?> €</p>
            </div>
        <?php endforeach; ?>

        <p class="total-commande">💰 Total commande : <strong><?= number_format($infos["montant_total"], 2) ?> €</strong></p>
    </div>
<?php endforeach; ?>
    </article>

    <article>

    <h2>Tableau de bord Jeu</h2>

<?php if (!empty($commande["meilleurJoueur"])): ?>
    <?php $joueur = $commande["meilleurJoueur"][0]; ?>
    <div class="joueur-card">
        <p><strong>Joueur :</strong> <?= htmlspecialchars($joueur["email_utilisateur"]) ?></p>
        <p><strong>Meilleur score :</strong> <?= $joueur["meilleur_score"] ?></p>
    </div>
<?php else: ?>
    <p>Aucun score enregistré.</p>
<?php endif; ?>

    </article>









</section>

