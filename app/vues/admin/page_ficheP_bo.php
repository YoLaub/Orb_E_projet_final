<h1>🛠️ Édition de la fiche produit</h1>


<h2>✏️ Modifier les informations</h2>

<p class="message">
    <?php
    if (isset($_SESSION["message"])) {
        echo htmlspecialchars($_SESSION["message"]);
    } else {
        echo htmlspecialchars($commande["message"] ?? '');
    }
    ?>
</p>

<form action="./?action=fiche" method="post" enctype="multipart/form-data" class="form-produit">

    <label for="nom">Nom :</label>
    <input type="text" id="nom" name="nom" required value="<?= htmlspecialchars($commande["detailProduit"][0]["nom"]); ?>">

    <label for="description">Description :</label>
    <textarea id="description" name="description" rows="4" required><?= trim($commande["detailProduit"][0]["description"]); ?></textarea>

    <label for="prix">Prix (€) :</label>
    <input type="text" id="prix" name="prix" required value="<?= htmlspecialchars($commande["detailProduit"][0]["prix"]); ?>">

    <label for="photo">Photo actuelle :</label>
    <div class="photo-preview">
        <img src="<?= htmlspecialchars($commande["detailProduit"][0]["photo"]) ?>" alt="Photo produit" height="100">
    </div>
    <input type="file" id="photo" name="photo" accept="image/*">

    <label for="dispo">Disponibilité :</label>
    <select name="statut" id="statut">
        <?php foreach ($commande["select"] as $value): ?>
            <option value="<?= $infos["statut"] ?>">
            <?= htmlspecialchars($value); ?>
            </option>
        <?php endforeach; ?>
        </select>

    <button type="submit">💾 Valider</button>
</form>
