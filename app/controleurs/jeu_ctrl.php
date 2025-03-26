<?php
require_once RACINE . "app/modeles/bddUtilisateur.php";
require RACINE."app/controleurs/navigation_ctrl.php";
require_once RACINE . "app/class/gestionConnexion.php";

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


