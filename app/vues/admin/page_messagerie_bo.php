<?php
require_once RACINE . "app/controleurs/navigation_ctrl.php";
include RACINE . "app/vues/page_header.php";

?>


<h1>Messagerie</h1>

<h2>Vos message</h2>

<?=var_dump($commande["lesMessages"])?>

<h2>Répondre</h2>
    
    <form action="./?action=messagerie" method="post">
        <label for="id">ID message</label>
        <input type="text" id="name" name="id_contact" required><br>

        <label for="reponse">Message :</label>
        <textarea id="message" name="reponse" required></textarea><br>

        <button type="submit">Envoyer</button>
    </form>

<h2>Vos réponse</h2>

<?=var_dump($commande["lesReponses"])?>

<?php

include RACINE . "app/vues/page_footer.php";

?>