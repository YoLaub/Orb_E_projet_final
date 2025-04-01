<?php

namespace app\controleurs\class;

use \Exception;

use app\modeles\DBUser;
use app\controleurs\class\renderLayout;

class Connexion
{

    private $connectDB;
    private $pageLayout;
    private $home;

    public function __construct()
    {
        $this->connectDB = new DBUser;
        $this->pageLayout = new renderLayout;
        $this->home = new accueilControleur;
    }

    public function connexionUtilisateur()
    {
        
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $email = trim($_POST["email"] ?? '');
            $mdp = trim($_POST["password"] ?? '');
        
        
            if (!empty($email) && !empty($mdp)) {
         
                $connexion = new GestionConnexion();
                $estConnecte = self::verifInfoConn($email, $mdp);
        
                if ($estConnecte==true && isset($_SESSION["role"]) && $_SESSION["role"] == "utilisateur") {
                    // Redirection vers l'accueil si connexion réussie
                    $this->home->accueil($_SESSION["role"]);
                }elseif($estConnecte == true && isset($_SESSION["role"]) && $_SESSION["role"] == "admin"){
                    $this->home->accueil($_SESSION["role"]);
                }else{
                    $content = "page_connexion.php";
                    $this->pageLayout->render($content);
                }   
                exit(); // Assure que le script s'arrête ici
            }else{
                $content = "page_connexion.php";
                $this->pageLayout->render($content);
            }
        }else{
        
            if(isset($_SESSION)){
                $connexion = new GestionConnexion();
                $connexion->deconnexion();
            }
            
            
            $content = "page_connexion.php";
            $this->pageLayout->render($content);
        
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
                    $content = "page_accueil.php";
                    $this->pageLayout->render($content);
                } else {
                    $content = "page_inscription.php";
                    $this->pageLayout->render($content);
                }
            } else {
                $content = "page_inscription.php";
                $this->pageLayout->render( $content);
            }
        } else {
            $content = "page_inscription.php";
            $this->pageLayout->render($content);
        }
    }
    
    public function deconnexion()
    {
        if (isset($_SESSION["id"])) {
            unset($_SESSION["email"]);
            unset($_SESSION["id"]);
            unset($_SESSION["role"]);
            session_destroy();
        }
    }

    private function verifInfoAuth($email, $mdp){

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

