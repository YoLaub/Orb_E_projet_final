<?php

namespace app\controleurs\class;

use app\middleware\Middleware;
use app\modeles\DBProduct;

class ProduitControleur
{
    private $pageLayout;
    private $connexion;
    private $produits;

    public function __construct()
    {
        $this->pageLayout = new renderLayout;
        $this->connexion = new Middleware;
        $this->produits = new DBProduct;


    }

    public function pageProduit(){

        $detailsProduit = $this->produits->getProduct();
        $params = array();
        $params["commande"] = "Commandez !";
        $params["Detail produit"] = $detailsProduit;

        if(!$detailsProduit[0]["disponibilite"] == "en_stock"){
            $params["commande"] = "Reservez !";
        }

        $_SESSION["id_produit"] = $detailsProduit[0]["id_produit"];

            $content = "page_produit.php";
            $this->pageLayout->render($content, $params);

}
}
