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

    public function editionProduitBo(){

        $id_produit = $_SESSION["id_produit"];
        $params["detailProduit"] = $this->produits->getProductById($id_produit);
        $content = "admin/page_ficheP_bo.php";

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $nom = trim($_POST["nom"] ?? '');
            $description = trim($_POST["description"] ?? '');
            $prix = trim($_POST["prix"] ?? '');
            $photo = trim($_POST["photo"] ?? '');
            $dispo = trim($_POST["dispo"] ?? '');
            
           
            if ($nom && $description &&  $prix && $photo && $dispo) {
               $etat =  $this->produits->updateProduct($id_produit, $nom, $description, $prix, $photo, $dispo);
        
                if ($etat) {
                    unset($_SESSION["id_produit"]);
                    
                } else {
                    $params["message"] = "Une erreur c'est produite !";
                    $this->pageLayout->render($content, $params);
                }

                $_SESSION["message"] = "Les modifications ont été enregstrée";
                header("Location: ?action=produit");
            }
            $params["message"] = "Veuillez remplir tous les champs !";
            $this->pageLayout->render($content, $params);
        } else {
        
        $params["message"] = "Veuillez remplir tous les champs !";
        $this->pageLayout->render($content, $params);
        }
    }
}
