

<section>


<?=$commande["formulaire"]?>

</section>

<section>


<h2>Panier</h2>

<form action="./?action=commande" method="post">
    <input type="text" name="nomProduit" value="<?=$commande["infoProduit"][0]["nom"]; ?>"><br>
    <input type="text" name="prix" value="<?=$commande["infoProduit"][0]["prix"]; ?>"><br>
    <input type="number" name="quantite" value="1"><br>
    
    <button type="submit">Commander !</button>
</form>
</section>

