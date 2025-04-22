<?php

namespace app\middleware;

use app\controleurs\class\Routes;
use app\controleurs\class\RoutesPrive;

class Middleware
{
    // Constructeur sans initialisation spécifique pour l'instant
    public function __construct() {}

    // Middleware pour gérer l'accès en fonction du rôle de l'utilisateur
    public function authMiddleware()
    {
        // Vérifie si un rôle "admin" est défini dans la session
        if (isset($_SESSION["role_visiteur"]) && $_SESSION["role_visiteur"] == "admin") {
            // Si l'utilisateur est admin, retourne un objet de gestion des routes privées (back-office)
            return new RoutesPrive;
        } else {
            // Si l'utilisateur n'est pas admin, retourne un objet de gestion des routes publiques
            return new Routes;
        }
    }

    // Middleware pour vérifier l'accès pour un utilisateur connecté
    public function accesMiddleware($zone = null)
    {
        // Vérifie si un rôle "utilisateur" est défini dans la session
        if (isset($_SESSION["role_visiteur"]) && $_SESSION["role_visiteur"] == "utilisateur") {
            // Si l'utilisateur a un rôle "utilisateur", l'accès est autorisé
            return true;
        } else {
            // Si l'utilisateur n'a pas ce rôle, l'accès est refusé
            if($zone == "jeu"){
                $_SESSION["redirection"] = "Veuillez vous connecter pour jouer !";
            }elseif($zone == "commande"){
                $_SESSION["redirection"] = "Veuillez vous connecter pour commander !";
            }elseif($zone == "profil"){
                $_SESSION["redirection"] = "Veuillez créer un compte !";
            }
            
            return false;
        }
    }
}
