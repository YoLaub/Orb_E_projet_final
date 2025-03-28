<h1>Utilisateur</h1>

<?=print_r($listeUtilisateur)?>
<form action="./?action=suppression" method="post">
    <input type="number" name="id_utilisateur" placeholder="id user">
    <button type="submit">supprimer</button>
</form>

<section id="inscription">
    <h2>Ajouter un compte admnistrateur</h2>
    <form action="./?action=utilisateur" method="post">
        <input type="text" name="email" placeholder="votre email">
        <input type="text" name="mdp" placeholder="votre mot de passe">
        <button type="submit">Valider</button>
    </form>
</section>
<?=print_r($listeAdmin)?>
<form action="./?action=suppression" method="post">
    <input type="number" name="id_admin" placeholder="id admin">
    <button type="submit">supprimer</button>
</form>
