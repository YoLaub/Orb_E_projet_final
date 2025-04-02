<?php
require_once RACINE . "app/controleurs/navigation_ctrl.php";
include RACINE . "app/vues/page_header.php";

?>

<h2>Contactez-nous</h2>

   <p>
    <?php 
    if(isset($_SESSION["message"])){
        echo $_SESSION["message"];
    }else{
        echo $commande["message"];
    }
    ?>
    </p>
    
    <form action="./?action=contact" method="post">
        <label for="name">Nom :</label>
        <input type="text" id="name" name="nom" required><br>

        <label for="email">Email :</label>
        <input type="email" id="email" name="email" required><br>

        <label for="message">Message :</label>
        <textarea id="message" name="message" required></textarea><br>

        <button type="submit">Envoyer</button>
    </form>

<?php

include RACINE . "app/vues/page_footer.php";

?>