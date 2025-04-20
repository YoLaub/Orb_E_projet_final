<?php

namespace app\controleurs\class;

// Importation des classes nécessaires pour les middlewares, modèles et gestion de données
use app\middleware\Middleware;
use app\modeles\DBUser;
use app\modeles\DBContacts;
use app\modeles\DBResponse;
use app\modeles\DBOrder;
use app\modeles\DBProduct;

class ProfilControleur
{
    // Déclaration des propriétés privées utilisées dans le contrôleur
    private $pageLayout;
    private $connexion;
    private $gestionProfil;
    private $connexionContact;
    private $connexionReponses;
    private $gestionCommande;
    private $connexionDBProduct;
    private $infoPerso;
    private $email;

    // Constructeur pour initialiser les dépendances et récupérer les informations de l'utilisateur connecté
    public function __construct()
    {
        $this->pageLayout = new RenderLayout;
        $this->connexion = new Middleware;
        $this->gestionProfil = new DBUser;
        $this->connexionContact = new DBContacts;
        $this->connexionReponses = new DBResponse;
        $this->connexionDBProduct = new DBProduct;
        $this->gestionCommande = new DBOrder;

        // Vérifie si un email est présent en session et le stocke
        if (isset($_SESSION["email"])) {
            $this->email = $_SESSION["email"];
        }

        // Récupère les informations personnelles de l'utilisateur connecté
        $this->infoPerso = $this->gestionProfil->infoUser($this->email);
    }

    // Affiche la page profil de l'utilisateur
    public function pageProfil()
    {
        if ($this->connexion->accesMiddleware()) {

            $action = "profile";
            $nom = $this->infoPerso[0]["nom"] ?? "";

            // Préparation des paramètres à passer à la vue
            $params = [
                "email" => $this->email,
                "informations" =>  $this->infoPerso,
                "commandes" => json_encode($this->gestionProfil->getUserOrders($this->email)),
                "score" => $this->gestionProfil->getUserScores($this->email),
                "mesMessages" => $this->connexionContact->getMessagePerEmail($this->email),
                "formulaire" => $this->modifierInformationPerso($action),
                "reponse" => $this->repondre($nom),
                "style" => "style_profile.css",
                "page" => "Mon profil",
                "scripts" => '<script src="./publique/scripts/modal_profile.js" defer></script>
<script src="./publique/scripts/rechercheReponse.js" defer></script>
<script src="./publique/scripts/information.js" defer></script>'
            ];

            // Rendu de la page profil avec les paramètres
            $content = "page_profile.php";
            $this->pageLayout->render($content, $params);
        } else {
            // Redirige vers la page de connexion si l'accès est refusé
            $_SESSION["url"] = $_SERVER['REQUEST_URI'];
            header("Location: ?action=connexion");
        }
    }

    // Affiche la page commande de l'utilisateur
    public function pageCommande()
    {
        if ($this->connexion->accesMiddleware()) {

            $action = "commande";
            // Préparation des paramètres à passer à la vue commande
            $params = [
                "email" => $this->email,
                "informations" =>  $this->infoPerso,
                "formulaire" => $this->modifierInformationPerso($action),
                "infoProduit" => $this->connexionDBProduct->getProduct(),
                "style" => "style_commande.css",
                "page" => "Commande",
                "scripts" => '<script src="./publique/scripts/formulaireCommande.js" defer></script>
            <script src="./publique/scripts/information.js" defer></script>'
            ];

            // Rendu de la page commande avec les paramètres
            $content = "page_commande.php";
            $this->pageLayout->render($content, $params);
        } else {
            // Redirige vers la page de connexion si l'accès est refusé
            $_SESSION["url"] = $_SERVER['REQUEST_URI'];
            header("Location: ?action=connexion");
        }
    }

    // Gère l'affichage et la modification des informations personnelles de l'utilisateur
    public function modifierInformationPerso($action)
    {
        // Récupération des informations actuelles de l'utilisateur
        $information = $this->gestionProfil->infoUser($this->email);
        $table = "commerce";
        $colonne = "mode_paiement";

        // Préparation des paramètres pour le formulaire
        $params = [
            "informations" => $information,
            "select" => $this->gestionCommande->showEnum($table, $colonne),
            "action" => $action
        ];

        // Traitement de la soumission du formulaire
        if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["prenom"], $_POST["nom"])) {

            // Récupération et nettoyage des données du formulaire
            $id_utilisateur = $_SESSION["id"];
            $prenom = trim($_POST["prenom"] ?? '');
            $nom = trim($_POST["nom"] ?? "user" . $id_utilisateur);
            $adresse = trim($_POST["adresse"] ?? '');
            $ville = trim($_POST["ville"] ?? '');
            $cp = trim($_POST["cp"] ?? '');
            $tel = trim($_POST["tel"] ?? '');
            $pays = trim($_POST["pays"] ?? '');
            $paiement = trim($_POST["paiement"] ?? '');

            // Si un email est présent, on met à jour ou crée l'information utilisateur
            if ($this->email) {
                if (!empty($information) && isset($information[0]["nom"])) {
                    $etat = $this->gestionProfil->updateInfoUser($this->email, $prenom, $nom, $adresse, $ville, $cp, $tel, $pays, $paiement);
                } else {
                    $etat = $this->gestionCommande->createInfoUser($id_utilisateur, $prenom, $nom, $adresse, $ville, $cp, $tel, $pays, $paiement);
                }

                // Si la mise à jour est réussie, on redirige sur la même page
                if ($etat) {
                    $_SESSION["message"] = "<p>Modification effectué !</p>";
                    header("Location: ?action=" . $action);
                    exit;
                } else {
                    // Sinon, on affiche un message d'erreur dans le formulaire
                    $params["message"] = "<p> Erreur de modification !</p>";
                    return $this->pageLayout->render("partials/formulaire.php", $params, true);
                }
            } else {
                return $this->pageLayout->render("partials/formulaire.php", $params, true);
            }
        } else {
            // Affiche le formulaire par défaut s'il n'y a pas de POST
            return $this->pageLayout->render("partials/formulaire.php", $params, true);
        }
    }

    // Gère l'ajout d'une commande par l'utilisateur
    public function ajouterCommande()
    {
        $action = "commande";

        // Préparation des paramètres pour la page commande
        $params = [
            "email" => $this->email,
            "informations" =>  $this->infoPerso,
            "formulaire" => $this->modifierInformationPerso($action),
            "infoProduit" => $this->connexionDBProduct->getProduct(),
            "style" => "style_commande.css",
            "page" => "Commande",
            "scripts" => '<script src="./publique/scripts/formulaireCommande.js" defer></script>
            <script src="./publique/scripts/information.js" defer></script>'
        ];

        // Traitement de la soumission du formulaire de commande
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $nomProduit = trim($_POST["nomProduit"] ?? '');
            $prix = trim($_POST["prix"] ?? '');
            $quantite = intval(trim($_POST["quantite"] ?? ''));
            $prixTotal = floatval($prix) * $quantite;

            // Vérifie les données avant d'ajouter la commande
            if ($nomProduit && $prix && isset($_SESSION["id_produit"])) {
                $etat = $this->connexionDBProduct->addOrder($prixTotal, $_SESSION["id"], $_SESSION["id_produit"], $quantite);

                // Si ajout réussi : nettoyage session + message de confirmation
                if ($etat) {
                    unset($_SESSION["id_produit"]);
                    $_SESSION["merci"] = "Merci pour votre commande, nous vous contacterons dans les 48H";
                    header("Location: ?action=produit");
                } else {
                    // En cas d'échec, rechargement de la page commande
                    $content = "page_commande.php";
                    $this->pageLayout->render($content, $params);
                }
            } else {
                // Si données incomplètes, affiche un message
                $params["message"] = "Informations produit incomplètes.";
                $this->pageLayout->render("page_commande.php", $params);
            }
        } else {
            // Affiche la page commande par défaut
            $content = "page_commande.php";
            $this->pageLayout->render($content, $params);
        }
    }

    // Permet à l'utilisateur d'envoyer un message via le formulaire de contact
    public function repondre($nom)
    {
        // Préparation des paramètres pour la vue contact
        $params = [
            "action" => "profile"
        ];

        // Traitement de la soumission du formulaire de message
        if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["message"])) {

            if (isset($_SESSION["email"])) {
                $email = $_SESSION["email"];
            }

            $message = htmlspecialchars($_POST["message"] ?? "");

            if (isset($_SESSION["id"])) {
                $id_utlisateur = $_SESSION["id"];
            } else {
                $id_utlisateur = NULL;
            }

            $connexionContact = new DBContacts();

            // Vérifie les données avant d'enregistrer le message
            if (!empty($nom) && !empty($email) && !empty($message)) {
                $etat = $connexionContact->saveMessage($nom, $email, $message, $id_utlisateur);
                if ($etat) {
                    $_SESSION["message"] = "Message envoyé !";
                    header("Location: ?action=profile"); // Redirection post-message
                    exit;
                } else {
                    $params["message"] = "Erreur d'envoie' !";
                    return $this->pageLayout->render("partials/contact.php", $params, true);
                }
            } else {
                $params["message"] = "Rediger un message !";
                return $this->pageLayout->render("partials/contact.php", $params, true);
            }
        }

        // Réinitialise le message session s'il existe
        if (isset($_SESSION["message"])) {
            unset($_SESSION["message"]);
        }

        // Affiche le formulaire par défaut avec un message
        $params["message"] = "Dites nous tous !";
        return $this->pageLayout->render("partials/contact.php", $params, true);
    }
}
