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

        if (!empty($utilisateur)) {
            $mdpBdd = $utilisateur[0]["password"];
            if (password_verify($mdp, $mdpBdd)) {
                $_SESSION["email"] = $email;
                $_SESSION["id"] =  $utilisateur[0]["id_utilisateur"];
                $_SESSION["role"] =  $utilisateur[0]["rôle"];
                return true;
            }else{
                $erreur = "password invalid";
                return $erreur;
            }
        }else{
            $erreur = "email invalid";
            return $erreur;
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

        try {
            if (preg_match($regexMdp, $mdp)) {
                throw new Exception("Mot de passe invalid, respecter le format demandé");
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                throw new Exception("Email invalid, respecter le format demandé");
            } else {
                $mdpHache = password_hash($mdp, PASSWORD_DEFAULT);
                $this->connectDB::addUser($nom, $prenom, $email, $mdpHache);
                return true;
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }


    public function deconnexion()
    {
        if (isset($_SESSION["email"])) {
            unset($_SESSION["email"]);
            unset($_SESSION["id"]);
            unset($_SESSION["role"]);
            session_destroy();
        }
    }
}
