<?php
require_once RACINE . "app/controleurs/navigation_ctrl.php";
include RACINE . "app/vues/page_header.php";

?>


<h1>Utilisateur</h1>

<?=print_r($commande["liste_utilisateur"])?>
<form action="./?action=suppression" method="post">
    <input type="number" name="id_utilisateur" placeholder="id user">
    <button type="submit">supprimer</button>
</form>

<section id="inscription">
<?=$commande["inscription"]?>
</section>

<?=print_r($commande["liste_admin"])?>
<form action="./?action=suppression" method="post">
    <input type="number" name="id_admin" placeholder="id admin">
    <button type="submit">supprimer</button>
</form>

<?php

include RACINE . "app/vues/page_footer.php";

?>