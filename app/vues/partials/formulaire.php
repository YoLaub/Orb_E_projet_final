<h2 class="titre_form">Vérifier vos informations</h2>

<?php if (isset($commande["message"])) {
    $commande["message"];
}
?>


<form class="info-form" action="?action=<?= $commande["action"] ?>" method="post">
    <input type="text" name="prenom" placeholder="Votre prénom.." value="<?php echo htmlspecialchars($commande["informations"][0]["prenom"]); ?>" aria-label ="prenom"><br>
    <input type="text" name="nom" placeholder="Votre nom.." value="<?php echo htmlspecialchars($commande["informations"][0]["nom"]); ?>" aria-label ="nom"><br>
    <input type="text" name="adresse" placeholder="Votre adresse.." value="<?php echo htmlspecialchars($commande["informations"][0]["adresse_livraison"]); ?>" aria-label ="adresse"><br>
    <input id="cpInput" type="text" name="cp" placeholder="Entrez votre code postal..." value="<?php echo htmlspecialchars($commande["informations"][0]["code_postal"]); ?>" aria-label ="code postal"><br>
    <select id="resultListCp" name="ville" aria-label ="ville">
        <option value="<?php echo htmlspecialchars($commande["informations"][0]["ville"]) ?? ''; ?>"><?php echo htmlspecialchars($commande["informations"][0]["ville"]) ?? '--- Selectionner votre ville'; ?></option>
    </select>
    <input type="text" id="searchInput" placeholder="Rechercher votre pays ici..." value="" aria-label ="rechercher votre pays" />
    <select id="resultList" name="pays" aria-label ="pays">
        <option value="<?php echo htmlspecialchars($commande["informations"][0]["pays"]) ?? ''; ?>"><?php echo htmlspecialchars($commande["informations"][0]["pays"]) ?? '--- Selectionner votre pays'; ?></option>
    </select>
    <input type="text" name="tel" placeholder="Votre numero de téléphone.." value="<?php echo htmlspecialchars($commande["informations"][0]["telephone"]); ?>" aria-label ="telephone"><br>
    <label for="paiement">Mode de paiement</label>
    <select name="paiement" aria-label ="mode de paiement">
        <?php foreach ($commande["select"] as $value): ?>
            <option value="<?= htmlspecialchars($value); ?>">
                <?= htmlspecialchars($value); ?>
            </option>
        <?php endforeach; ?>
    </select>
    <button type="submit" aria-label ="envoyer">Modifier</button>
</form>