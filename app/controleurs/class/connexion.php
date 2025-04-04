<?php

namespace app\controleurs\class;

use \Exception;

use app\modeles\DBUser;
use app\controleurs\class\renderLayout;
use app\modeles\DBProduct;

class Connexion
{

    private $connectDB;
    private $connexionProduct;
    private $pageLayout;
    private $home;
    private $params;

    public function __construct()
    {
        $this->connectDB = new DBUser;
        $this->connexionProduct = new DBProduct();
        $this->pageLayout = new renderLayout;
        $this->home = new accueilControleur;
        $this->params = array();
        $this->params["style"] = "style_connexion.css";
    }

    public function connexionUtilisateur()
    {
        
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $email = trim($_POST["email"] ?? '');
            $mdp = trim($_POST["password"] ?? '');
        
        
            if (!empty($email) && !empty($mdp)) {
                $estConnecte = self::verifInfoConn($email, $mdp);
        
                if ($estConnecte==true && isset($_SESSION["role"]) && $_SESSION["role"] == "utilisateur") {
                    // Redirection vers l'accueil si connexion réussie
                    $this->home->accueil();
                }elseif($estConnecte == true && isset($_SESSION["role"]) && $_SESSION["role"] == "admin"){
                    $this->home->accueil();
                }else{
                    $content = "page_connexion.php";
                    $this->pageLayout->render($content, $this->params);
                }   
                exit(); // Assure que le script s'arrête ici
            }else{
                $content = "page_connexion.php";
                $this->pageLayout->render($content, $this->params);
            }
        }else{
        
            if(isset($_SESSION)){
                self::deconnexion();
            }
            
            
            $content = "page_connexion.php";
            $this->pageLayout->render($content, $this->params);
        
        }
    }


    public function estConnecte()
    {
        $etat = false;
        if (isset($_SESSION["email"]) && isset($_SESSION["id"])) {
            $etat = true;
            return $etat;
        } else {
            return $etat;
        }
    }



    public function inscription()
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $email = trim($_POST["email"] ?? '');
            $mdp = trim($_POST["mdp"] ?? '');

            $mdpHache = self::verifInfoAuth($email, $mdp);

            if ($email && $mdpHache) {
                $etat = $this->connectDB::addUser($email, $mdpHache);

                if ($etat) {
                    self::connexionUtilisateur($email, $mdp);
                    // Redirection vers l'accueil si connexion réussie
                    $this->params["style"] = "style_accueil.css";
                    $content = "page_accueil.php";
                    $this->pageLayout->render($content, $this->params);
                } else {
                    $content = "page_inscription.php";
                    $this->pageLayout->render($content, $this->params);
                }
            } else {
                $content = "page_inscription.php";
                $this->pageLayout->render( $content, $this->params);
            }
        } else {
            $content = "page_inscription.php";
            $this->pageLayout->render($content, $this->params);
        }
    }
    
    public function deconnexion()
    {
        if (isset($_SESSION["id"])) {
            unset($_SESSION["email"]);
            unset($_SESSION["id"]);
            unset($_SESSION["role"]);
            session_destroy();

            $this->params["style"] = "style_accueil.css";

            $content = "page_accueil.php";
            $this->pageLayout->render($content, $this->params);
            
        }
    }

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
                    $etat =  $this->connectDB->deleteUser(intval($_POST["id_admin"]));
                    header("Location: ?action=utilisateur");
                exit();
        
                default:
                    $this->pageLayout->render($content, $this->params);
            }
        } else {
            $content = "admin/page_Ubo.php";
            $this->params["style"] = "style_utilisateurBo.css";
            $this->pageLayout->render($content, $this->params);
        }
    }

    public function verifInfoAuth($email, $mdp){

        $regexMdp = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/";

        try {
            if (preg_match($regexMdp, $mdp)) {
                throw new Exception("Mot de passe invalid, respecter le format demandé");
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                throw new Exception("Email invalid, respecter le format demandé");
            } else {
                $mdpHache = password_hash($mdp, PASSWORD_DEFAULT);
                return $mdpHache;
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    private function verifInfoConn($email, $mdp){

        $utilisateur =  $this->connectDB::getUserPerEmail($email);

        if (!empty($utilisateur)) {
            $mdpBdd = $utilisateur[0]["password"];
            if (password_verify($mdp, $mdpBdd)) {
                $_SESSION["email"] = $email;
                $_SESSION["id"] =  $utilisateur[0]["id_utilisateur"];
                $_SESSION["role"] =  $utilisateur[0]["rôle"];
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

