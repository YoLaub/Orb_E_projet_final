<?php

namespace app\controleurs\class ;

use app\controleurs\class\GestionConnexion;
use app\modeles\DBUser;
use app\modeles\DBContacts;
use app\modeles\DBResponse;

class FluxControleur
{
    public function pageConnexion()
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $email = trim($_POST["email"] ?? '');
            $mdp = trim($_POST["password"] ?? '');

            if (!empty($email) && !empty($mdp)) {
                $connexion = new GestionConnexion();
                $estConnecte = $connexion->connexion($email, $mdp);

                if ($estConnecte && isset($_SESSION["role"])) {
                    if ($_SESSION["role"] == "utilisateur") {
                        $this->rediriger("?action=accueil");
                    } elseif ($_SESSION["role"] == "admin") {
                        $this->rediriger("?action=accueilBo");
                    }
                }
            }
            
            // Redirection en cas d’échec de connexion
            $this->rediriger("?action=connexion");
        } else {
            if(isset($_SESSION)){
                $connexion = new GestionConnexion();
                $connexion->deconnexion();
            }
            $this->affichage("page_connexion.php");
        }
    }

    public function pageInscription()
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $email = trim($_POST["email"] ?? '');
            $mdp = trim($_POST["mdp"] ?? '');

            if (!empty($email) && !empty($mdp)) {
                $connexion = new GestionConnexion();
                $etat = $connexion->inscription($email, $mdp);

                if ($etat) {
                    $connexion->connexion($email, $mdp);
                    $this->rediriger("?action=accueil");
                } else {
                    $_SESSION["validation"] = "Erreur lors de l'inscription.";
                    $this->rediriger("?action=inscription");
                }
            } else {
                $_SESSION["validation"] = "Tous les champs sont requis.";
                $this->rediriger("?action=inscription");
            }
        } else {
            $this->affichage("page_inscription.php");
        }
    }

   

    private function rediriger($url)
    {
        header("Location: $url");
        exit();
    }

    private function affichage($cible)
    {
        require RACINE."app/controleurs/navigation_ctrl.php";

        include RACINE . "app/vues/page_header.php";
        include RACINE . "app/vues/" . $cible;
        include RACINE . "app/vues/page_footer.php";
    }
}



