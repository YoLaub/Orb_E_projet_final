<?php

namespace app\controleurs\class;

use app\middleware\Middleware;
use app\modeles\DBUser;
use app\modeles\DBContacts;
use app\modeles\DBResponse;
use app\modeles\DBOrder;
use app\modeles\DBProduct;

class ProfilControleur
{
    private $pageLayout;
    private $connexion;
    private $gestionProfil;
    private $connexionContact;
    private $connexionReponses;
    private $gestionCommande;
    private $connexionDBProduct;
    private $infoPerso;
    private $email;

    public function __construct()
    {
        $this->pageLayout = new RenderLayout;
        $this->connexion = new Middleware;
        $this->gestionProfil = new DBUser;
        $this->connexionContact = new DBContacts;
        $this->connexionReponses = new DBResponse;
        $this->connexionDBProduct = new DBProduct;
        $this->gestionCommande = new DBOrder;
        if (isset($_SESSION["email"])) {
            $this->email = $_SESSION["email"];
        }
        $this->infoPerso = $this->gestionProfil->infoUser($this->email);
    }

    public function pageProfil()
    {
        if ($this->connexion->accesMiddleware()) {

            $action = "profile";
            $nom = $this->infoPerso[0]["nom"] ?? "";
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

            $content = "page_profile.php";
            $this->pageLayout->render($content, $params);
        } else {
            $_SESSION["url"] = $_SERVER['REQUEST_URI'];
            header("Location: ?action=connexion");
        }
    }


    public function pageCommande()
    {
        if ($this->connexion->accesMiddleware()) {

            $action = "commande";
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

            $content = "page_commande.php";
            $this->pageLayout->render($content, $params);
        } else {
            $_SESSION["url"] = $_SERVER['REQUEST_URI'];
            header("Location: ?action=connexion");
        }
    }

    public function modifierInformationPerso($action)
    {

        $information = $this->gestionProfil->infoUser($this->email);
        $table = "commerce";
        $colonne = "mode_paiement";
        $params = array();
        // Récupérer les infos pour afficher le formulaire pré-rempli
        $params = [
            "informations" => $information,
            "select" => $this->gestionCommande->showEnum($table, $colonne),
            "action" => $action
        ];


        if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["prenom"], $_POST["nom"])) {

            $id_utilisateur = $_SESSION["id"];
            $prenom = trim($_POST["prenom"] ?? '');
            $nom = trim($_POST["nom"] ?? "user" . $id_utilisateur);
            $adresse = trim($_POST["adresse"] ?? '');
            $ville = trim($_POST["ville"] ?? '');
            $cp = trim($_POST["cp"] ?? '');
            $tel = trim($_POST["tel"] ?? '');
            $pays = trim($_POST["pays"] ?? '');
            $paiement = trim($_POST["paiement"] ?? '');


            if ($this->email) {
                if (!empty($information) && isset($information[0]["nom"])) {
                    $etat = $this->gestionProfil->updateInfoUser($this->email, $prenom, $nom, $adresse, $ville, $cp, $tel, $pays, $paiement);
                } else {
                    $etat = $this->gestionCommande->createInfoUser($id_utilisateur, $prenom, $nom, $adresse, $ville, $cp, $tel, $pays, $paiement);
                }

                if ($etat) {
                    $_SESSION["message"] = "<p>Modification effectué !</p>";
                    header("Location: ?action=" . $action);
                    exit;
                } else {
                    $params["message"] = "<p> Erreur de modification !</p>";
                    return $this->pageLayout->render("partials/formulaire.php", $params, true);
                }
            } else {
                return $this->pageLayout->render("partials/formulaire.php", $params, true);
            }
        }else{
            return $this->pageLayout->render("partials/formulaire.php", $params, true);
        }

    }
    


    public function ajouterCommande()
    {

        $action = "commande";
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


        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $nomProduit = trim($_POST["nomProduit"] ?? '');
            $prix = trim($_POST["prix"] ?? '');
            $quantite = intval(trim($_POST["quantite"] ?? ''));
            $prixTotal = floatval($prix) * $quantite;


            if ($nomProduit && $prix && isset($_SESSION["id_produit"])) {

                $etat = $this->connexionDBProduct->addOrder($prixTotal, $_SESSION["id"], $_SESSION["id_produit"], $quantite);

                if ($etat) {
                    unset($_SESSION["id_produit"]);
                    $_SESSION["merci"] = "Merci pour votre commande, nous vous contacterons dans les 48H";
                    header("Location: ?action=produit");
                } else {
                    $content = "page_commande.php";
                    $this->pageLayout->render($content, $params);
                }
            } else {
                $params["message"] = "Informations produit incomplètes.";
                $this->pageLayout->render("page_commande.php", $params);
            }
        } else {
            $content = "page_commande.php";
            $this->pageLayout->render($content, $params);
        }
    }

    public function repondre($nom)
    {

        $params = [
            "action" => "profile"
        ];

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


            if (!empty($nom) && !empty($email) && !empty($message)) {
                $etat = $connexionContact->saveMessage($nom, $email, $message, $id_utlisateur);
                if ($etat) {
                    $_SESSION["message"] = "Message envoyé !";
                    header("Location: ?action=profile"); // Redirection vers la même page après POST
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
        if (isset($_SESSION["message"])) {
            unset($_SESSION["message"]);
        }

        $params["message"] = "Dites nous tous !";
        return $this->pageLayout->render("partials/contact.php", $params, true);
    }
}
