<?php

namespace app\controleurs\class;

use app\middleware\Middleware;
use app\modeles\DBProduct;

class ProduitControleur
{
    private $pageLayout;
    private $connexion;
    private $produits;
    private $detailsProduit;

    public function __construct()
    {
        $this->pageLayout = new renderLayout;
        $this->connexion = new Middleware;
        $this->produits = new DBProduct;
        $this->detailsProduit = $this->produits->getProduct();


    }

    public function pageProduit(){

        $params = array();
        $params["commande"] = "Commandez !";
        $params["Detail produit"] = $this->detailsProduit;

        if(!$this->detailsProduit[0]["disponibilite"] == "en_stock"){
            $params["commande"] = "Reservez !";
        }

        $_SESSION["id_produit"] = $this->detailsProduit[0]["id_produit"];

            $content = "page_produit.php";
            $this->pageLayout->render($content, $params);

}

    public function pageProduitBo(){

        $params["listeProduit"] = $this->produits->getProduct();
        $_SESSION["id_produit"] = $this->detailsProduit[0]["id_produit"];

        $content = "admin/page_produit_bo.php";
        $this->pageLayout->render($content, $params);

}
}
