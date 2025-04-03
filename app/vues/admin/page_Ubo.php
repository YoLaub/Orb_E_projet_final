<main>
<section>

<?=$commande["inscription"]?>

<h2>Admin</h2>
<?=print_r($commande["liste_admin"])?>
<form action="./?action=suppression" method="post">
    <input type="number" name="id_admin" placeholder="id admin">
    <button type="submit">supprimer</button>
</form>

</section>

<section>

<h2>Utilisateur</h2>

<?=print_r($commande["liste_utilisateur"])?>
<form action="./?action=suppression" method="post">
    <input type="number" name="id_utilisateur" placeholder="id user">
    <button type="submit">supprimer</button>
</form>

</main>


</section>




