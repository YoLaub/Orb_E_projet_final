<?php

namespace app\controleurs\class;

use app\modeles\DBUser;
use app\controleurs\class\Connexion;

class UtilisateurGControleur
{

    private $pageLayout;
    private $gestionProfil;
    private $connexion;
    private $gestionAdmin;
    private $listeUtilisateur;
    private $listeAdmin;


    public function __construct()
    {
        $this->gestionProfil = new DBUser;
        $this->connexion = new Connexion;
        $this->listeUtilisateur = $this->gestionProfil->getUser("utilisateur");
        $this->listeAdmin = $this->gestionProfil->getUser("admin");
        $this->pageLayout = new RenderLayout;
    }

    public function pageGUtilisateur()
    {

        $params = [
            "inscription" => $this->inscriptionAdmin(),
            "liste_utilisateur" => $this->listeUtilisateur,
            "liste_admin" => $this->listeAdmin,
            "style" => "style_profile_bo.css",
            "scripts" => '<script src="./publique/scripts/rechercheUtilisateur.js" defer></script>
            <script src="./publique/scripts/formulaireConnexion.js" defer></script>
    <script src="./publique/scripts/showMdp.js" defer></script>'
        ];


        $content = "admin/page_Ubo.php";
        $this->pageLayout->render($content, $params);
    }

    public function rechercheUtilisateur()
    {

        if (isset($_POST['terme'])) {
            $terme = "%" . trim($_POST['terme']) . "%";


            $utilisateurs = $this->gestionProfil->searchUser($terme); // la méthode qu'on a vue plus haut

            header('Content-Type: application/json');
            echo json_encode($utilisateurs);
            exit;
        }
    }

    public function inscriptionAdmin()
    {
        $params = [
            "action" => "utilisateur"
        ];

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $email = trim($_POST["email"] ?? '');
            $mdp = trim($_POST["mdp"] ?? '');
            $role = $_SESSION["role"];

            $mdpHache = $this->connexion->verifInfoAuth($email, $mdp);

            if ($email && $mdpHache) {
                $etat = $this->gestionProfil->addUser($email, $mdpHache, $role);

                if ($etat) {
                    $_SESSION["message"] = "Nouvel administrateur ajouté !";
                } else {
                    $params["message"] = "Erreur lors de l'inscription !";
                    $content = "partials/inscription.php";
                    return $this->pageLayout->render($content, $params, true);
                }
                header("Location: ?action=utilisateur");
                exit();
            } else {
                $params["message"] = "Remplissez tout les champs !";
                $content = "partials/inscription.php";
                return $this->pageLayout->render($content, $params, true);
            }
        } else {

            if (isset($_SESSION["message"])) {
                unset($_SESSION["message"]);
            }
            $params = [
                "action" => "utilisateur"
            ];
            $content = "partials/inscription.php";
            return $this->pageLayout->render($content, $params, true);
        }
    }
}
