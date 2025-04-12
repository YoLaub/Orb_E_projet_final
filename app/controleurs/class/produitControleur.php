<?php

namespace app\controleurs\class;

use app\middleware\Middleware;
use app\modeles\DBProduct;
use app\modeles\DBOrder;

class ProduitControleur
{
    private $pageLayout;
    private $connexion;
    private $produits;
    private $detailsProduit;
    private $gestionCommande;
    private $params;

    public function __construct()
    {
        $this->pageLayout = new RenderLayout;
        $this->connexion = new Middleware;
        $this->produits = new DBProduct;
        $this->gestionCommande = new DBOrder;
        $this->detailsProduit = $this->produits->getProduct();
        $this->params = array();
        $this->params["commande"] = "Commandez !";
        
    }

    public function pageProduit()
    {
         $this->params["commande"] = "Commandez !";
         $this->params["Detail produit"] = $this->detailsProduit;
         $this->params["meta"] = '<meta property="og:title" content="' . htmlspecialchars($this->detailsProduit[0]["nom"]) . '" />
        <meta property="og:description" content="' . htmlspecialchars   ($this->detailsProduit[0]["description"]) . '" />
        <meta property="og:image" content="' . htmlspecialchars($this->detailsProduit[0]["photo"]) . '" />
        <meta property="og:url" content="https://ton-site.com/?action=produit" />
        <meta property="og:type" content="product" />';
        $this->params["partage"] = $this->pageLayout->render("partials/partage.php",  $this->detailsProduit, true);
        $this->params["style"] = "style_produit.css";


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
        $this->params["style"] = "page_fiche_produit.css";
        
        $content = "admin/page_produit_bo.php";
        $this->pageLayout->render($content,  $this->params);
    }

    public function ajouterProduit(){

        $table = "produits";
        $colonne = "disponibilite";
        $content = "admin/page_ajout_produit.php";

        $this->params["message"] = "Veuillez remplir tous les champs !";
        $this->params["select"] = $this->gestionCommande->showEnum($table, $colonne);
        $this->params["style"] = "page_fiche_produit.css";


        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $nom = trim($_POST["nom"] ?? '');
            $description = trim($_POST["description"] ?? '');
            $prix = floatval(trim($_POST["prix"] ?? ''));
            $dispo = trim($_POST["dispo"] ?? '');


            if ($nom && $description &&  $prix  && $dispo) {
                $photo = $this->ajouterPhoto();
                $etat =  $this->produits->addProduct($nom, $description, $prix, $photo, $dispo);

                if ($etat) {
                    $_SESSION["message"] = "Les modifications ont été enregstrée";
                    header("Location: ?action=produit");
                    exit();
                } else {
                     $this->params["message"] = $etat;
                     $this->pageLayout->render($content,  $this->params);
                }
            } else {
                 $this->params["message"] = "Veuillez remplir tous les champs !";
                 $this->pageLayout->render($content,  $this->params);
            }
        }

        if(isset($_SESSION["message"])){
            unset($_SESSION["message"]);
        }
        $this->pageLayout->render($content,  $this->params);

    }

    public function editionProduitBo()
    {

        $table = "produits";
        $colonne = "disponibilite";

        $id_produit = $_SESSION["id_produit"];
         $this->params["detailProduit"] = $this->produits->getProductById($id_produit);
         $this->params["message"] = "Veuillez remplir tous les champs !";
        $content = "admin/page_ficheP_bo.php";
         $this->params["select"] = $this->gestionCommande->showEnum($table, $colonne);
         $this->params["style"] = "page_fiche_produit.css";


        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $nom = trim($_POST["nom"] ?? '');
            $description = trim($_POST["description"] ?? '');
            $prix = floatval(trim($_POST["prix"] ?? '')) ;
            $dispo = trim($_POST["statut"] ?? '');

            if ($nom && $description &&  $prix && $dispo) {
                $photo = $this->ajouterPhoto() ??  $this->params["detailProduit"][0]["photo"];
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
