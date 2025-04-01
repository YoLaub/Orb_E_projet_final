<h2>Modifier les informations</h2>

<p><?php if(isset($commande["message"]))
         {
         $commande["message"];
         }
    ?>
</p>

<form action="./?action=formulaire" method="post">
    <label>Prénom : <input type="text" name="prenom" value="<?php echo htmlspecialchars($commande["informations"][0]["prenom"]); ?>"></label><br>
    <label>Nom : <input type="text" name="nom" value="<?php echo htmlspecialchars($commande["informations"][0]["nom"]); ?>"></label><br>
    <label>Adresse : <input type="text" name="adresse" value="<?php echo htmlspecialchars($commande["informations"][0]["adresse_livraison"]); ?>"></label><br>
    <label>Ville : <input type="text" name="ville" value="<?php echo htmlspecialchars($commande["informations"][0]["ville"]); ?>"></label><br>
    <label>Code Postal : <input type="text" name="cp" value="<?php echo htmlspecialchars($commande["informations"][0]["code_postal"]); ?>"></label><br>
    <label>Téléphone : <input type="text" name="tel" value="<?php echo htmlspecialchars($commande["informations"][0]["telephone"]); ?>"></label><br>
    <button type="submit">Modifier</button>
</form>