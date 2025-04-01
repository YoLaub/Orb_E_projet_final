<?php
require_once RACINE . "app/controleurs/navigation_ctrl.php";
include RACINE . "app/vues/page_header.php";

?>

<section id="connexion">
    <h2>
        Connexion
    </h2>

    <form action="./?action=connexion" method="post">
        <input type="text" name="email" placeholder="votre email">
        <input type="text" name="password" placeholder="votre password">
        <button type="submit">Valider</button>
    </form>
    <a href="./?action=inscription">S'inscrire</a>

</section>

<?php

include RACINE . "app/vues/page_footer.php";

?>