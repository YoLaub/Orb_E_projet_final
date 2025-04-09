<section>

    <div>
        <h1>Gestion des produits</h1>
        <a href="./?action=nouveau" class="nouveau_produit">Ajouter un nouveau produit</a>
    </div>

    <article class="produit-section">
        <?php foreach ($commande["listeProduit"] as $produit): ?>
            <div class="produit-card">
                <img src="<?= htmlspecialchars($produit["photo"]) ?>" alt="<?= htmlspecialchars($produit["nom"]) ?>">
                <div class="produit-info">
                    <h2><?= htmlspecialchars($produit["nom"]) ?></h2>
                    <p><?= htmlspecialchars($produit["description"]) ?></p>
                    <p><strong>Prix :</strong> <?= $produit["prix"] ?> €</p>
                    <p><strong>Disponibilité :</strong> <?= $produit["disponibilite"] ?></p>


                    <a href="./?action=fiche" class="nouveau_produit">✏️ Éditer la fiche produit</a>

                    <form action="./?action=suppression" method="post" class="form-inline">
                        <input type="hidden" name="id_produit" value="<?= $produit["id_produit"] ?>">
                        <button type="submit">Supprimer</button>
                    </form>
                </div>
            </div>
        <?php endforeach; ?>
    </article>
</section>