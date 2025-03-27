 <h1>Edition de la fiche produit</h1>

 <h2>Modifier les informations</h2>
<form action="./?action=fiche" method="post">
    <label>Nom : <input type="text" name="nom" value="<?php echo htmlspecialchars($detailProduit[0]["nom"]); ?>"></label><br>
    <label>Description : <input type="textarea" name="description" value="<?php echo htmlspecialchars($detailProduit[0]["description"]); ?>"></label><br>
    <label>Prix : <input type="text" name="prix" value="<?php echo htmlspecialchars($detailProduit[0]["prix"]); ?>"></label><br>
    <label>Photo : <input type="text" name="photo" value="<?php echo htmlspecialchars($detailProduit[0]["photo"]); ?>"></label><br>
    <label>Disponibilité : <input type="text" name="disponibilite" value="<?php echo htmlspecialchars($detailProduit[0]["disponibilite"]); ?>"></label><br>
   
    <button type="submit">Valider</button>
</form>