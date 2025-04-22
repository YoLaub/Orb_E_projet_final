<?php

namespace app\controleurs\class;

use app\modeles\DBUser;
use app\controleurs\class\Connexion;

class UtilisateurGControleur
{
    private $pageLayout;         // Objet de gestion des layouts
    private $gestionProfil;      // Objet d'accès aux utilisateurs en base
    private $connexion;          // Gestion des connexions (authentification)
    private $listeUtilisateur;   // Liste des utilisateurs standards
    private $listeAdmin;         // Liste des administrateurs

    public function __construct()
    {
        // Instanciation des objets nécessaires
        $this->gestionProfil = new DBUser;
        $this->connexion = new Connexion;

        // Chargement des listes d'utilisateurs
        $this->listeUtilisateur = $this->gestionProfil->getUser("utilisateur");
        $this->listeAdmin = $this->gestionProfil->getUser("admin");

        // Instanciation du système de mise en page
        $this->pageLayout = new RenderLayout;
    }

    // Affiche la page de gestion des utilisateurs et administrateurs
    public function pageGUtilisateur()
    {
        $params = [
            "inscription" => $this->inscriptionAdmin(), // Formulaire d’inscription d’admin
            "liste_utilisateur" => $this->listeUtilisateur,
            "liste_admin" => $this->listeAdmin,
            "style" => "style_profile_bo.css",
            "scripts" => '
                <script src="./publique/scripts/rechercheUtilisateur.js" defer></script>
                <script src="./publique/scripts/formulaireConnexion.js" defer></script>
                <script src="./publique/scripts/showMdp.js" defer></script>'
        ];

        $content = "admin/page_Ubo.php";
        $this->pageLayout->render($content, $params);
    }

    // Traitement AJAX pour la recherche d’utilisateurs
    public function rechercheUtilisateur()
    {
        if (isset($_POST['terme'])) {
            $terme = "%" . trim($_POST['terme']) . "%";

            // Recherche via la méthode du modèle
            $utilisateurs = $this->gestionProfil->searchUser($terme);

            // Retourne les résultats en JSON
            header('Content-Type: application/json');
            echo json_encode($utilisateurs);
            exit;
        }
    }

    // Gère l'inscription d'un administrateur
    public function inscriptionAdmin()
    {
        $params = [
            "action" => "utilisateur"
        ];

        // Si le formulaire a été soumis
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $email = trim($_POST["email"] ?? '');
            $mdp = trim($_POST["mdp"] ?? '');
            $role = $_SESSION["role_visiteur"]; // rôle récupéré via la session

            // Vérifie et hache le mot de passe
            $mdpHache = $this->connexion->verifInfoAuth($email, $mdp);

            // Si les champs sont valides
            if ($email && $mdpHache) {
                // Tente l’ajout en base
                $etat = $this->gestionProfil->addUser($email, $mdpHache, $role);

                if ($etat) {
                    $_SESSION["message"] = "Nouvel administrateur ajouté !";
                } else {
                    $params["message"] = "Erreur lors de l'inscription !";
                    $content = "partials/inscription.php";
                    return $this->pageLayout->render($content, $params, true);
                }

                // Redirige vers la page utilisateur
                header("Location: ?action=utilisateur");
                exit();
            } else {
                $params["message"] = "Remplissez tous les champs !";
                $content = "partials/inscription.php";
                return $this->pageLayout->render($content, $params, true);
            }
        } 
        // Si aucun formulaire soumis, affiche simplement le formulaire
        else {
            if (isset($_SESSION["message"])) {
                unset($_SESSION["message"]);
            }

            $content = "partials/inscription.php";
            return $this->pageLayout->render($content, $params, true);
        }
    }
    // Gère l'inscription d'un administrateur
    public function modifierPasswordAdmin()
    {
        $params = [
            "action" => "utilisateur"
        ];

        // Si le formulaire a été soumis
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $email = trim($_POST["email"] ?? '');
            $mdp = trim($_POST["mdp"] ?? '');
            $newMdp = trim($_POST["newMdp"] ?? '');
            $role = $_SESSION["role_visiteur"]; // rôle récupéré via la session

            // Vérifie et hache le mot de passe
            $mdpHache = $this->connexion->verifInfoAuth($email, $mdp);
            $newMdpHache = password_hash($newMdp, PASSWORD_DEFAULT);

            // Si les champs sont valides
            if ($email && $mdpHache) {
                // Tente l’ajout en base
                $etat = $this->gestionProfil->updateAdmin($email, $newMdpHache, $role);

                if ($etat) {
                    $_SESSION["message"] = "Mot de pass modifié avec succès";
                } else {
                    $params["message"] = "Erreur lors de la modification !";
                    $content = "partials/inscription.php";
                    return $this->pageLayout->render($content, $params, true);
                }

                // Redirige vers la page utilisateur
                header("Location: ?action=utilisateur");
                exit();
            } else {
                $params["message"] = "Remplissez tous les champs !";
                $content = "partials/inscription.php";
                return $this->pageLayout->render($content, $params, true);
            }
        } 
        // Si aucun formulaire soumis, affiche simplement le formulaire
        else {
            if (isset($_SESSION["message"])) {
                unset($_SESSION["message"]);
            }

            $content = "partials/inscription.php";
            return $this->pageLayout->render($content, $params, true);
        }
    }
}
