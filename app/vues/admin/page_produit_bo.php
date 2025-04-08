<h1>Nos Produits</h1>

<section class="produit-section">

    <?php foreach ($commande["listeProduit"] as $produit): ?>
        <div class="produit-card">
            <img src="<?= htmlspecialchars($produit["photo"]) ?>" alt="<?= htmlspecialchars($produit["nom"]) ?>">
            <div class="produit-info">
                <h2><?= htmlspecialchars($produit["nom"]) ?></h2>
                <p><?= htmlspecialchars($produit["description"]) ?></p>
                <p><strong>Prix :</strong> <?= $produit["prix"] ?> €</p>
                <p><strong>Disponibilité :</strong> <?= $produit["disponibilite"] ?></p>
            </div>
        </div>
    <?php endforeach; ?>

</section>

<form action="./?action=suppression" method="post" class="form-inline">
    <input type="number" name="id_produit" placeholder="ID produit" required>
    <button type="submit">Supprimer</button>
</form>

<a href="./?action=fiche" class="edit-link">✏️ Éditer la fiche produit</a>
