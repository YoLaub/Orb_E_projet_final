<?php
require_once RACINE . "app/controleurs/navigation_ctrl.php";
include RACINE . "app/vues/page_header.php";

?>

<h1>accès BO ok</h1>

<h2>
    Tableau de bord vente:
</h2>

<?=var_dump($lesCommandes)?>


<h2>Nombre d'utilisateurs: <?=var_dump($lesUtilisateurs)?></h2>


<h2>
    Tableau de bord Jeu:
</h2>

<?=var_dump($meilleurJoueur)?>


<?php

include RACINE . "app/vues/page_footer.php";

?>
