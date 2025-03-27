<?php
    require RACINE."app/controleurs/navigation_ctrl.php";
    require_once RACINE . "app/modeles/bddProduit.php";

   
    $connexion = new DBProduct();
    $listeProduit = $connexion->getProduct();
    $_SESSION["id_produit"] = $listeProduit[0]["id_produit"];

    //Affichage des vues
    include_once RACINE . "app/vues/page_header.php";
    include_once RACINE . "app/vues/admin/page_produit_bo.php";
    include_once RACINE . "app/vues/page_footer.php"; 


?>