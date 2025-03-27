<h1>Commande</h1>


<h2>Modifier les informations</h2>
<form action="./?action=commande" method="post">
    <label>Prénom : <input type="text" name="prenom" value="<?php echo htmlspecialchars($infoPerso[0]["prenom"]); ?>"></label><br>
    <label>Nom : <input type="text" name="nom" value="<?php echo htmlspecialchars($infoPerso[0]["nom"]); ?>"></label><br>
    <label>Adresse : <input type="text" name="adresse" value="<?php echo htmlspecialchars($infoPerso[0]["adresse_livraison"]); ?>"></label><br>
    <label>Ville : <input type="text" name="ville" value="<?php echo htmlspecialchars($infoPerso[0]["ville"]); ?>"></label><br>
    <label>Code Postal : <input type="text" name="cp" value="<?php echo htmlspecialchars($infoPerso[0]["code_postal"]); ?>"></label><br>
    <label>Téléphone : <input type="text" name="tel" value="<?php echo htmlspecialchars($infoPerso[0]["telephone"]); ?>"></label><br>
    <label>Mode de paiement : <input type="text" name="paiement" value="<?php echo htmlspecialchars($infoPerso[0]["mode_paiement"]); ?>"></label><br>
    <button type="submit">Valider</button>
</form>

<h2>Panier</h2>

<form action="./?action=commande" method="post">
    <input type="text" name="nomProduit" value="<?php echo htmlspecialchars($infoProduit[0]["nom"]); ?>"><br>
    <input type="text" name="prix" value="<?php echo htmlspecialchars($infoProduit[0]["prix"]); ?>"><br>
    <input type="number" name="quantite" value="1"><br>
    
    <button type="submit">Commander !</button>
</form>