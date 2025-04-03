
<h1>Produit</h1>

<?=var_dump($commande)?>
<form action="./?action=suppression" method="post">
    <input type="number" name="id_produit" placeholder="id produit">
    <button type="submit">supprimer</button>
</form>

<a href="./?action=fiche">Editer la fiche produit</a>



