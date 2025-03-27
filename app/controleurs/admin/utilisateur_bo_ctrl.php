<?php

    require_once RACINE . "app/modeles/bddUtilisateur.php";
    require RACINE."app/controleurs/navigation_ctrl.php";

    $gestionProfil = new DBUser();
    $listeUtilisateur = $gestionProfil->getUser();

    //Affichage des vues
    include_once RACINE . "app/vues/page_header.php";
    include_once RACINE . "app/vues/admin/page_Ubo.php";
    include_once RACINE . "app/vues/page_footer.php"; 


?>