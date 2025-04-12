<h2 class="titre_form">Vérifier vos informations</h2>

<?php if (isset($commande["message"])) {
    $commande["message"];
}
?>


<form class="info-form" action="?action=<?= $commande["action"] ?>" method="post">
    <input type="text" name="prenom" value="<?php echo htmlspecialchars($commande["informations"][0]["prenom"]); ?>"></label><br>
    <input type="text" name="nom" value="<?php echo htmlspecialchars($commande["informations"][0]["nom"]); ?>"></label><br>
    <input type="text" name="adresse" value="<?php echo htmlspecialchars($commande["informations"][0]["adresse_livraison"]); ?>"></label><br>
    <input id ="cpInput" type="text" name="cp" placeholder="Entrez votre code postal..." value="<?php echo htmlspecialchars($commande["informations"][0]["code_postal"]); ?>"></label><br>
    <select id="resultListCp" name="ville">
        <option value="<?php echo htmlspecialchars($commande["informations"][0]["ville"]) ?? ''; ?>"><?php echo htmlspecialchars($commande["informations"][0]["ville"]) ?? '--- Selectionner votre ville'; ?></option>
    </select>
    <input type="text" id="searchInput" placeholder="Rechercher votre pays ici..." value="" />
    <select id="resultList" name="pays">
        <option value="<?php echo htmlspecialchars($commande["informations"][0]["pays"]) ?? ''; ?>"><?php echo htmlspecialchars($commande["informations"][0]["pays"]) ?? '--- Selectionner votre pays'; ?></option>
    </select>
    <input type="text" name="tel" value="<?php echo htmlspecialchars($commande["informations"][0]["telephone"]); ?>"></label><br>
    <select name="paiement">
        <?php foreach ($commande["select"] as $value): ?>
            <option value="<?= htmlspecialchars($value); ?>">
                <?= htmlspecialchars($value); ?>
            </option>
        <?php endforeach; ?>
    </select>
    <button type="submit">Modifier</button>
</form>


<!-- https://apicarto.ign.fr/api/codes-postaux/communes/56420 -->