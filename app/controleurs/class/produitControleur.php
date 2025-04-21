<?php

namespace app\controleurs\class;

use app\middleware\Middleware;
use app\modeles\DBProduct;
use app\modeles\DBOrder;

class ProduitControleur
{
    private $pageLayout; // Instance de la classe qui gère la mise en page
    private $connexion; // Instance de la classe Middleware pour gérer l'accès utilisateur
    private $produits; // Instance du modèle DBProduct pour récupérer les informations sur les produits
    private $detailsProduit; // Détails d'un produit spécifique
    private $gestionCommande; // Instance du modèle DBOrder pour gérer les commandes
    private $params; // Tableau pour stocker les paramètres à passer à la vue

    public function __construct()
    {
        $this->pageLayout = new RenderLayout; // Initialise l'instance de la classe RenderLayout
        $this->connexion = new Middleware; // Initialise l'instance de Middleware
        $this->produits = new DBProduct; // Initialise le modèle DBProduct
        $this->gestionCommande = new DBOrder; // Initialise le modèle DBOrder
        $this->detailsProduit = $this->produits->getProduct(); // Récupère les détails des produits
        $this->params = array(); // Initialisation du tableau de paramètres
        $this->params["commande"] = "Commandez !"; // Message par défaut
    }

    public function pageProduit()
    {
        // Préparation des paramètres pour afficher la page produit
        $this->params["commande"] = "Commandez !";
        $this->params["Detail produit"] = $this->detailsProduit;
        $this->params["meta"] = '<meta property="og:title" content="' . $this->detailsProduit[0]["nom"] . '" />
        <meta property="og:description" content="' . $this->detailsProduit[0]["description"] . '" />
        <meta property="og:image" content="./publique/images/commande_ex.webp" />
        <meta property="og:url" content="https://stagiaires-kercode9.greta-bretagne-sud.org/yoann-laubert/Orb_E_projet_final/produit" />
        <meta property="og:type" content="product" />';

        // Intègre un module de partage sur la page produit
        $this->params["partage"] = $this->pageLayout->render("partials/partage.php",  $this->detailsProduit, true);
        $this->params["style"] = "style_produit.css"; // Lien vers la feuille de style spécifique au produit
        $this->params["scripts"] = '<script type="module" src="./publique/scripts/visualiseur.js" defer></script>
        <script src="./publique/scripts/article.js" defer></script>'; // Scripts associés à la page produit
        $this->params["page"] = "Orb'E"; // Titre de la page

        // Si le produit n'est pas en stock, le message de commande devient "Réservez !"
        if (!$this->detailsProduit[0]["disponibilite"] == "en_stock") {
            $this->params["commande"] = "Reservez !";
        }

        // Stocke l'ID du produit dans la session
        $_SESSION["id_produit"] = $this->detailsProduit[0]["id_produit"];

        // Affiche la page produit avec les paramètres
        $content = "page_produit.php";
        $this->pageLayout->render($content,  $this->params);
    }

    public function pageProduitBo()
    {
        // Prépare la page pour l'interface administrateur de gestion des produits
        $this->params["listeProduit"] = $this->produits->getProduct();
        $_SESSION["id_produit"] = $this->detailsProduit[0]["id_produit"];
        $this->params["style"] = "page_fiche_produit.css";
        $this->params["scripts"] = '<script src="./publique/scripts/preview_photo.js" defer></script>'; // Script de prévisualisation des photos

        // Affiche la page de gestion des produits pour l'administrateur
        $content = "admin/page_produit_bo.php";
        $this->pageLayout->render($content,  $this->params);
    }

    public function ajouterProduit()
    {
        // Fonction pour ajouter un produit
        $table = "produits";
        $colonne = "disponibilite";
        $content = "admin/page_ajout_produit.php";

        // Message par défaut
        $this->params["message"] = "Veuillez remplir tous les champs !";
        $this->params["select"] = $this->gestionCommande->showEnum($table, $colonne); // Récupère les valeurs possibles pour la disponibilité
        $this->params["style"] = "page_fiche_produit.css";

        // Si le formulaire a été soumis en POST
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $nom = trim($_POST["nom"] ?? '');
            $description = trim($_POST["description"] ?? '');
            $prix = floatval(trim($_POST["prix"] ?? ''));
            $dispo = trim($_POST["dispo"] ?? '');

            // Vérifie que tous les champs sont remplis
            if ($nom && $description &&  $prix  && $dispo) {
                $photo = $this->ajouterPhoto(); // Ajoute la photo du produit
                $etat =  $this->produits->addProduct($nom, $description, $prix, $photo, $dispo); // Ajoute le produit à la base de données

                // Si l'ajout est réussi, redirige vers la page produit
                if ($etat) {
                    $_SESSION["message"] = "Les modifications ont été enregistrées";
                    header("Location: ?action=produit");
                    exit();
                } else {
                    $this->params["message"] = $etat;
                    $this->pageLayout->render($content,  $this->params); // Affiche un message d'erreur si l'ajout échoue
                }
            } else {
                $this->params["message"] = "Veuillez remplir tous les champs !";
                $this->pageLayout->render($content,  $this->params);
            }
        }

        // Si un message est déjà présent, le supprime après traitement
        if (isset($_SESSION["message"])) {
            unset($_SESSION["message"]);
        }
        $this->pageLayout->render($content,  $this->params);
    }

    public function editionProduitBo()
    {
        // Fonction pour éditer un produit dans l'interface administrateur
        $table = "produits";
        $colonne = "disponibilite";

        $id_produit = $_SESSION["id_produit"];
        $this->params["detailProduit"] = $this->produits->getProductById($id_produit); // Récupère les détails du produit à modifier
        $this->params["message"] = "Veuillez remplir tous les champs !";
        $content = "admin/page_ficheP_bo.php";
        $this->params["select"] = $this->gestionCommande->showEnum($table, $colonne); // Récupère les valeurs possibles pour la disponibilité
        $this->params["style"] = "page_fiche_produit.css";

        // Si le formulaire a été soumis en POST
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $nom = trim($_POST["nom"] ?? '');
            $description = trim($_POST["description"] ?? '');
            $prix = floatval(trim($_POST["prix"] ?? ''));
            $dispo = trim($_POST["statut"] ?? '');

            // Si tous les champs sont remplis, met à jour le produit
            if ($nom && $description &&  $prix && $dispo) {
                $photo = $this->ajouterPhoto() ??  $this->params["detailProduit"][0]["photo"]; // Utilise la photo existante si aucune nouvelle photo n'est uploadée
                $etat =  $this->produits->updateProduct($id_produit, $nom, $description, $prix, $photo, $dispo);

                // Si la mise à jour est réussie, redirige vers la page produit
                if ($etat) {
                    unset($_SESSION["id_produit"]);
                    $_SESSION["message"] = "Les modifications ont été enregistrées";
                    header("Location: ?action=produit");
                    exit();
                } else {
                    $this->params["message"] = "Une erreur s'est produite !";
                }
            } else {
                $this->params["message"] = "Veuillez remplir tous les champs !";
            }
        }

        // Si un message est déjà présent, le supprime après traitement
        if (isset($_SESSION["message"])) {
            unset($_SESSION["message"]);
        }
        $this->pageLayout->render($content,  $this->params);
    }

    private function ajouterPhoto()
    {
        // Fonction pour ajouter une photo au produit
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            if (isset($_FILES["photo"]) && $_FILES["photo"]["error"] === UPLOAD_ERR_OK) {
                $file = $_FILES["photo"];
                $maxSize = 1024 * 1024; // 1mo

                // Vérifie la taille du fichier
                if ($file["size"] > $maxSize) {
                    "erreur 3";
                }

                // Vérifie le type du fichier
                $allowedTypes = ["image/jpeg", "image/png", "image/gif", "image/jpg"];
                if (!in_array($file["type"], $allowedTypes)) {
                    "erreur 2";
                }

                // Déplace le fichier vers un dossier spécifique
                $uploadDir = "./publique/images/imports/";
                $fileName = uniqid() . "-" . basename($file["name"]);
                $filePath = $uploadDir . $fileName;

                // Si le fichier est déplacé correctement, retourne le chemin
                if (move_uploaded_file($file["tmp_name"], $filePath)) {
                    return $filePath;
                }
            }
        }
        return "erreur 1"; // Aucun fichier uploadé ou erreur
    }
}