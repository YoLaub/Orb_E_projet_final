<section>

    <h1>Nouveau produit</h1>

    <form action="./?action=nouveau" method="post" enctype="multipart/form-data" class="form-produit">
        <p class="message">
            <?php
            if (isset($_SESSION["message"])) {
                echo htmlspecialchars($_SESSION["message"]);
            } else {
                echo htmlspecialchars($commande["message"] ?? '');
            }
            ?>
        </p>

        <label for="nom">Nom :</label>
        <input type="text" id="nom" name="nom" required>

        <label for="description">Description :</label>
        <textarea id="description" name="description" rows="4" required></textarea>

        <label for="prix">Prix (€) :</label>
        <input type="text" id="prix" name="prix" required>


        <label for="photo">Photo :</label>
        <div class="photo-preview">
            <img id="previewImage" src="" alt="Photo produit" height="100">
        </div>
        <input type="file" id="photo" name="photo" accept="image/*">

        <label for="dispo">Disponibilité :</label>
        <select name="dispo" id="disponibilite">
            <?php foreach ($commande["select"] as $value): ?>
                <option value="<?= htmlspecialchars($value); ?>">
                    <?= htmlspecialchars($value); ?>
                </option>
            <?php endforeach; ?>
        </select>

        <button type="submit">Ajouter</button>
    </form>

</section>