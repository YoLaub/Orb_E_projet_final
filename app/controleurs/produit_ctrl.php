<?php

require RACINE."app/controleurs/navigation_ctrl.php";

use app\modeles\DBProduct;

$produit = new DBProduct();
$detailsProduit = $produit->getProduct();
$commandeBouton = "Commandez!";
if(!$detailsProduit[0]["disponibilite"] == "en_stock"){
    $commandeBouton = "Reservez !";
}

$_SESSION["id_produit"] = $detailsProduit[0]["id_produit"];

//Affichage des vues
    include_once RACINE . "app/vues/page_header.php";
    include_once RACINE . "app/vues/page_produit.php";
    include_once RACINE . "app/vues/page_footer.php"; 