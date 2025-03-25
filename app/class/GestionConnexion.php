<?php

class GestionConnexion
{

    private $connectDB;

    public function __construct()
    {
        if (!isset($_SESSION)) {
            session_start();
        }
        $this->connectDB = new DBPage2;
    }

    public function connexion($email, $mdp)
    {
        $utilisateur =  $this->connectDB::getUserPerEmail($email);

        if ($utilisateur && isset($utilisateur["mdp"])) {
            $mdpBdd = $utilisateur["mdp"];
            if (password_verify($mdp, $mdpBdd)) {
                $_SESSION["email"] = $email;
                $_SESSION["id"] =  $utilisateur["id_utilisateur"];
            }
        }
    }

    public function estConnecte()
    {
        $etat = false;
        if (isset($_SESSION["email"]) && isset($_SESSION["id_utilisateur"])) {
            $etat = true;
            return $etat;
        } else {
            return $etat;
        }
    }


    public function inscription($nom, $prenom, $email, $mdp)
    {
        $regexMdp = "/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[\W_]).{8,}$/";
        $regexEmail = "/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/";

        try {
            if (!isset($nom) && !isset($prenom) && !isset($email) && !isset($mdp)) {
                throw new Exception("Aucune valeur");
            } elseif (preg_match($regexMdp, $mdp)) {
                throw new Exception("Mot de passe invalid, respecter le format demandé");
            } elseif (preg_match($regexEmail, $email)) {
                throw new Exception("Email invalid, respecter le format demandé");
            } else {
                $mdpHache = password_hash($mdp, PASSWORD_DEFAULT);
                $this->connectDB::addUser($nom, $prenom, $email, $mdpHache);
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }


    public function Deconnexion()
    {
        if (isset($_SESSION["email"])) {
            unset($_SESSION["email"]);
            session_destroy();
        }
    }
}
