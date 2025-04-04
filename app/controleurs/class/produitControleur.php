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
    private $params;

    public function __construct()
    {
        $this->pageLayout = new renderLayout;
        $this->connexion = new Middleware;
        $this->produits = new DBProduct;
        $this->detailsProduit = $this->produits->getProduct();
        $this->params = array();
        $this->params["style"] = "style_produit.css";
    }

    public function pageProduit()
    {
         $this->params["commande"] = "Commandez !";
         $this->params["Detail produit"] = $this->detailsProduit;

        if (!$this->detailsProduit[0]["disponibilite"] == "en_stock") {
             $this->params["commande"] = "Reservez !";
        }

        $_SESSION["id_produit"] = $this->detailsProduit[0]["id_produit"];

        $content = "page_produit.php";
        $this->pageLayout->render($content,  $this->params);
    }

    public function pageProduitBo()
    {

         $this->params["listeProduit"] = $this->produits->getProduct();
        $_SESSION["id_produit"] = $this->detailsProduit[0]["id_produit"];

        $content = "admin/page_produit_bo.php";
        $this->pageLayout->render($content,  $this->params);
    }

    public function editionProduitBo()
    {

        $id_produit = $_SESSION["id_produit"];
         $this->params["detailProduit"] = $this->produits->getProductById($id_produit);
         $this->params["message"] = "Veuillez remplir tous les champs !";
        $content = "admin/page_ficheP_bo.php";

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $nom = trim($_POST["nom"] ?? '');
            $description = trim($_POST["description"] ?? '');
            $prix = trim($_POST["prix"] ?? '');
            $dispo = trim($_POST["dispo"] ?? '');

            // Vérifier si une nouvelle image a été uploadée
            $photo = $this->ajouterPhoto() ??  $this->params["detailProduit"][0]["photo"];

            if ($nom && $description &&  $prix && $photo && $dispo) {
                $etat =  $this->produits->updateProduct($id_produit, $nom, $description, $prix, $photo, $dispo);

                if ($etat) {
                    unset($_SESSION["id_produit"]);
                    $_SESSION["message"] = "Les modifications ont été enregstrée";
                    header("Location: ?action=produit");
                    exit();
                } else {
                     $this->params["message"] = "Une erreur c'est produite !";;
                }
            } else {
                 $this->params["message"] = "Veuillez remplir tous les champs !";
            }
        }

        if(isset($_SESSION["message"])){
            unset($_SESSION["message"]);
        }
        $this->pageLayout->render($content,  $this->params);
    }

    private function ajouterPhoto()
    {

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            if (isset($_FILES["photo"]) && $_FILES["photo"]["error"] === UPLOAD_ERR_OK) {
                $file = $_FILES["photo"];
                $maxSize = 1024 * 1024; // 1mo

                // Vérifier la taille du fichier
                if ($file["size"] > $maxSize) {
                    "erreur 3";
                }

                // Vérifier le type du fichier
                $allowedTypes = ["image/jpeg", "image/png", "image/gif", "image/jpg",];
                if (!in_array($file["type"], $allowedTypes)) {
                    "erreur 2";
                }

                // Déplacer le fichier vers un dossier spécifique
                $uploadDir = "./publique/images/imports/";
                $fileName = uniqid() . "-" . basename($file["name"]);
                $filePath = $uploadDir . $fileName;

                if (move_uploaded_file($file["tmp_name"], $filePath)) {
                    return $filePath; // Retourne le chemin à stocker
                }
            }
        }
        return "erreur 1"; // Aucun fichier uploadé ou erreur

    }

}
