<?php

require_once RACINE . "app/class/navigation.php";

//Création du menu
$nav = new Navigation("menu_principal");
$nav->addItem("./?action=accueil","Accueil");
$nav->addItem("./?action=jeu","Jouer");
$nav->addItem("./?action=produit","Orb'E");
$nav->addItem("./?action=qui","Qui sommes nous ?");
$nav->addItem("./?action=contact","Contactez-nous");

$navContent = $nav->getNav();

?>