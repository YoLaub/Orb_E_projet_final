<?php

namespace app\controleurs\class;

use \Exception;

use app\modeles\DBUser;
use app\controleurs\class\RenderLayout;
use app\modeles\DBProduct;

class Connexion
{
    // Attributs pour la gestion des utilisateurs, produits, rendu de page et paramètres d'affichage
    private $connectDB;         // Accès à la base de données des utilisateurs
    private $connexionProduct; // Accès à la base de données des produits
    private $pageLayout;       // Rendu de la page
    private $home;             // Contrôleur de la page d'accueil
    private $params;           // Paramètres transmis aux vues

    public function __construct()
    {
        // Initialisation des objets et paramètres communs aux pages de connexion/inscription
        $this->connectDB = new DBUser;
        $this->connexionProduct = new DBProduct();
        $this->pageLayout = new RenderLayout;
        $this->home = new AccueilControleur;
        $this->params = array();

        $this->params["style"] = "style_connexion.css";
        $this->params["action"] = "connexion";
        $this->params["scripts"] = '<script src="./publique/scripts/formulaireConnexion.js" defer></script>
    <script src="./publique/scripts/showMdp.js" defer></script>';
        $this->params["inscription"] = $this->pageLayout->render("partials/inscription.php", $this->params, true);
    }

    // Gestion de la connexion utilisateur
    public function connexionUtilisateur()
    {
        $this->params["action"] = "connexion";
        $this->params["page"] = "Connexion";
        $this->params["inscription"] = $this->pageLayout->render("partials/inscription.php", $this->params, true);

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $email = trim($_POST["email"] ?? '');
            $mdp = trim($_POST["mdp"] ?? '');
            $secu = trim($_POST["prtg"]);

            // Vérification que le champ de sécurité est vide (anti-spam), et que les champs sont remplis
            if (empty($secu) && !empty($email) && !empty($mdp)) {
                $estConnecte = self::verifInfoConn($email, $mdp);

                // Redirection selon le rôle ou la page précédemment visitée
                if ($estConnecte == true && isset($_SESSION["role"]) && $_SESSION["role"] == "utilisateur") {
                    if (isset($_SESSION["url"])) {
                        $url = $_SESSION["url"];
                        unset($_SESSION["url"]);
                        header("Location: $url");
                        exit;
                    } else {
                        $this->home->accueil();
                    }
                } elseif ($estConnecte == true && isset($_SESSION["role"]) && $_SESSION["role"] == "admin") {
                    $this->home->accueil();
                } else {
                    $content = "page_connexion.php";
                    $this->pageLayout->render($content, $this->params);
                }
                exit(); // Fin du script pour éviter toute exécution après redirection
            } else {
                $content = "page_connexion.php";
                $this->pageLayout->render($content, $this->params);
            }
        } else {
            // Si un utilisateur est déjà connecté, on le déconnecte avant d'afficher la page
            if (isset($_SESSION)) {
                self::deconnexion();
            }

            $content = "page_connexion.php";
            $this->pageLayout->render($content, $this->params);
        }
    }

    // Vérifie si un utilisateur est connecté
    public function estConnecte()
    {
        $etat = false;
        if (isset($_SESSION["email"]) && isset($_SESSION["id"])) {
            $etat = true;
        }
        return $etat;
    }

    // Gestion de l'inscription utilisateur
    public function inscription()
    {
        $this->params["action"] = "inscription";
        $this->params["page"] = "Inscription";
        $this->params["inscription"] = $this->pageLayout->render("partials/inscription.php", $this->params, true);

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $email = trim($_POST["email"] ?? '');
            $mdp = trim($_POST["mdp"] ?? '');

            $mdpHache = self::verifInfoAuth($email, $mdp);

            // Si les informations sont valides, on ajoute l'utilisateur
            if ($email && $mdpHache) {
                $etat = $this->connectDB::addUser($email, $mdpHache);

                if ($etat) {
                    $_SESSION["valide"] = "ok";
                    self::connexionUtilisateur($email, $mdp);
                    header("Location: accueil");
                    exit();
                } else {
                    $content = "page_inscription.php";
                    $this->pageLayout->render($content, $this->params);
                }
            } else {
                $content = "page_inscription.php";
                $this->pageLayout->render($content, $this->params);
            }
        } else {
            $content = "page_inscription.php";
            $this->pageLayout->render($content, $this->params);
        }
    }

    // Déconnexion de l'utilisateur
    public function deconnexion()
    {
        if (isset($_SESSION["id"])) {
            session_destroy();
            header("Location: ?action=accueil");
            exit();
        }
    }

    // Suppression d'un utilisateur ou d'un produit
    public function suppressionUtilisateur()
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            switch (true) {
                case isset($_POST["id_produit"]):
                    $etat = $this->connexionProduct->deleteProduct(intval($_POST["id_produit"]));
                    header("Location: ?action=produit");
                    exit();

                case isset($_POST["id_utilisateur"]):
                    $etat = $this->connectDB->deleteUser(intval($_POST["id_utilisateur"]));
                    header("Location: ?action=utilisateur");
                    exit();

                case isset($_POST["id_admin"]):
                    $etat = $this->connectDB->deleteUser(intval($_POST["id_admin"]));
                    header("Location: ?action=utilisateur");
                    exit();

                default:
                    $content = "admin/page_Ubo.php";
                    $this->pageLayout->render($content, $this->params);
            }
        } else {
            // Si non-POST, affichage de la page d'administration
            $content = "admin/page_Ubo.php";
            $this->params["style"] = "style_utilisateurBo.css";
            $this->pageLayout->render($content, $this->params);
        }
    }

    // Vérifie et sécurise les données d'inscription (mot de passe + email)
    public function verifInfoAuth($email, $mdp)
    {
        $regexMdp = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/";

        try {
            if (preg_match($regexMdp, $mdp)) {
                throw new Exception("Mot de passe invalid, respecter le format demandé");
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                throw new Exception("Email invalid, respecter le format demandé");
            } else {
                // Mot de passe hashé pour la base de données
                $mdpHache = password_hash($mdp, PASSWORD_DEFAULT);
                return $mdpHache;
            }
        } catch (Exception $e) {
            return $e->getMessage(); // Retourne un message d’erreur en cas d’exception
        }
    }

    // Vérifie les identifiants de connexion en base de données
    private function verifInfoConn($email, $mdp)
    {
        $utilisateur = $this->connectDB::getUserPerEmail($email);

        if (!empty($utilisateur)) {
            $mdpBdd = $utilisateur[0]["password"];
            if (password_verify($mdp, $mdpBdd)) {
                // Si le mot de passe est correct, on initialise la session
                $_SESSION["email"] = $email;
                $_SESSION["id"] = $utilisateur[0]["id_utilisateur"];
                $_SESSION["role"] = $utilisateur[0]["rôle"];
                return true;
            } else {
                $erreur = "password invalid";
                return $erreur;
            }
        } else {
            $erreur = "email invalid";
            return $erreur;
        }
    }
}
