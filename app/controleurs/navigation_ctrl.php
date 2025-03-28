<?php

require_once RACINE . "app/class/navigation.php";


if(isset($_SESSION["role"]) && $_SESSION["role"] == "admin"){
    $nav = new Navigation("menu_principal");
    $nav->addItem("./?action=accueilBo","Tableau de bord");
    $nav->addItem("./?action=utilisateur","Gestion utilisateur");
    $nav->addItem("./?action=produit","Gestion de produit");
    $nav->addItem("./?action=messagerie","Messagerie");

    $navContent = $nav->getNav();
}else{
    //Création du menu
    $nav = new Navigation("menu_principal");
    $nav->addItem("./?action=accueil","Accueil");
    $nav->addItem("./?action=jeu","Jouer");
    $nav->addItem("./?action=produit","Orb'E");
    $nav->addItem("./?action=qui","Qui sommes nous ?");
    $nav->addItem("./?action=contact","Contactez-nous");

    $navContent = $nav->getNav();
}



?>