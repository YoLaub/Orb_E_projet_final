

<?php
require_once RACINE . "app/controleurs/navigation_ctrl.php";
include RACINE . "app/vues/page_header.php";
?>

<h1>Produit</h1>

<?=var_dump($commande["Detail produit"])?>


<a href="./?action=<?=$keys[0]?>"><?=$commande[$keys[0]]?></a>

<?php

include RACINE . "app/vues/page_footer.php";

?>