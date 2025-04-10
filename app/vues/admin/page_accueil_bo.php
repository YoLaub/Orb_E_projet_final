<section>
<h1>Accès BO OK</h1>
<div class="utilisateur">
    <div>
        <svg viewBox="0 0 16 16">
            <path d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6m-5.784 6A2.24 2.24 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.3 6.3 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1zM4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5"/>
        </svg> 
        <p><?= $commande["lesUtilisateurs"][0]["count(*)"] ?></p>
    </div>
    <div>
        <svg  viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M10.854 8.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 0 1 .708-.708L7.5 10.793l2.646-2.647a.5.5 0 0 1 .708 0"/>
            <path d="M8 1a2.5 2.5 0 0 1 2.5 2.5V4h-5v-.5A2.5 2.5 0 0 1 8 1m3.5 3v-.5a3.5 3.5 0 1 0-7 0V4H1v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4zM2 5h12v9a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1z"/>
        </svg>
        <p><?= count($commande["commande"]) ?></p>
    </div>
        
    <div>
        <svg viewBox="0 0 16 16">
            <path d="M7.657 6.247c.11-.33.576-.33.686 0l.645 1.937a2.89 2.89 0 0 0 1.829 1.828l1.936.645c.33.11.33.576 0 .686l-1.937.645a2.89 2.89 0 0 0-1.828 1.829l-.645 1.936a.361.361 0 0 1-.686 0l-.645-1.937a2.89 2.89 0 0 0-1.828-1.828l-1.937-.645a.361.361 0 0 1 0-.686l1.937-.645a2.89 2.89 0 0 0 1.828-1.828zM3.794 1.148a.217.217 0 0 1 .412 0l.387 1.162c.173.518.579.924 1.097 1.097l1.162.387a.217.217 0 0 1 0 .412l-1.162.387A1.73 1.73 0 0 0 4.593 5.69l-.387 1.162a.217.217 0 0 1-.412 0L3.407 5.69A1.73 1.73 0 0 0 2.31 4.593l-1.162-.387a.217.217 0 0 1 0-.412l1.162-.387A1.73 1.73 0 0 0 3.407 2.31zM10.863.099a.145.145 0 0 1 .274 0l.258.774c.115.346.386.617.732.732l.774.258a.145.145 0 0 1 0 .274l-.774.258a1.16 1.16 0 0 0-.732.732l-.258.774a.145.145 0 0 1-.274 0l-.258-.774a1.16 1.16 0 0 0-.732-.732L9.1 2.137a.145.145 0 0 1 0-.274l.774-.258c.346-.115.617-.386.732-.732z"/>
        </svg>
        <p><?=$commande["total_score"][0]["total_points"]?></p>
    </div>
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

