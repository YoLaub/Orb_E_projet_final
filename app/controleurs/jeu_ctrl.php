<?php

require RACINE."app/controleurs/navigation_ctrl.php";


use app\class\GestionConnexion;

$connexion = new GestionConnexion();

if(!$connexion->estConnecte()){
    header("Location: ?action=inscription");
    exit();
}else{
    //Affichage des vues


    
    include_once RACINE . "app/vues/page_header.php";
    include_once RACINE . "app/vues/page_jeu.php";
    include_once RACINE . "app/vues/page_footer.php"; 

}


