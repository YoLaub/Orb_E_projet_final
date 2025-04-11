<h2 class="titre_form">Verifier vos informations</h2>

<?php if (isset($commande["message"])) {
    $commande["message"];
}
?>


<form  action="?action=<?= $commande["action"] ?>" method="post">
    <input type="text" name="prenom" value="<?php echo htmlspecialchars($commande["informations"][0]["prenom"]); ?>"></label><br>
    <input type="text" name="nom" value="<?php echo htmlspecialchars($commande["informations"][0]["nom"]); ?>"></label><br>
    <input type="text" name="adresse" value="<?php echo htmlspecialchars($commande["informations"][0]["adresse_livraison"]); ?>"></label><br>
    <input id ="cpInput" type="text" name="cp" value="<?php echo htmlspecialchars($commande["informations"][0]["code_postal"]); ?>"></label><br>
    <select id="resultListCp" name="ville"></select>
    <input type="text" id="searchInput" placeholder="Entrez un pays..." value="<?php echo htmlspecialchars($commande["informations"][0]["pays"]); ?>" />
    <select id="resultList" name="pays"></select>
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