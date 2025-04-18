<?php

namespace app\controleurs\class;

use app\middleware\Middleware;
use app\modeles\DBParty;
use app\modeles\DBOrder;

class JeuControleur
{
    private $pageLayout;
    private $connexion;
    private $partie;
    private $params;
    private $infoJoueur;

    public function __construct()
    {
        $this->pageLayout = new RenderLayout;
        $this->connexion = new Middleware;
        $this->partie = new DBParty;
        $this->infoJoueur = new DBOrder;
        $this->params["infoProfil"] = $this->infoJoueur->infoUser($_SESSION["email"]);
        $this->params["style"] = "orbe.css";
        $this->params["scripts"] = '<script type="module" src="./publique/scripts/orbe/ballRun.js" defer></script>
        <script src="./publique/scripts/orbe/fullscreen.js" defer></script>';
        $this->params["page"] = "Jouer";
        $this->params["meta"] = '<meta property="og:title" content="Orbe" />
        <meta property="og:image" content="./publique/images/mini_jeu1.webp" />
        <meta property="og:url" content="https://stagiaires-kercode9.greta-bretagne-sud.org/yoann-laubert/Orb_E_projet_final/?action=accueil" />
        <meta property="og:type" content="game" />';
    }

    public function pageJeu()
    {

        if ($this->connexion->accesMiddleware()) {

            if ($_SERVER["REQUEST_METHOD"] === "POST") {

                $idUtilisateur = $_SESSION["id"] ?? "";
                $data = json_decode(file_get_contents("php://input"), true);
                $score = $data["score"] ?? "";
                $_SESSION["score"] = $score;

                if (!empty($idUtilisateur) && !empty($score)) {
                    $etat = $this->partie->saveScore($score, $idUtilisateur);
                    if ($etat) {
                        return $this->pageLayout->render("page_jeu.php", $this->params);
                    } else {
                        $this->params["message"] = "Une erreur c'est produite !";
                        return $this->pageLayout->render("page_jeu.php", $this->params);
                    }
                    $this->params["message"] = "Vous n'êtes probablement pas autorisé à jouer, inscrivez vous !!";
                    return $this->pageLayout->render("page_jeu.php", $this->params);
                }
            }

            $content = "page_jeu.php";
            $this->pageLayout->render($content, $this->params);
        } else {
            $_SESSION["url"] = $_SERVER['REQUEST_URI'];
            header("Location: ?action=connexion");
        }
    }

    public function saveName()
    {
        $infoProfil =  $this->infoJoueur->infoUser($_SESSION["email"]);

        if ($_SERVER["REQUEST_METHOD"] === "POST") {

            $idUtilisateur = $_SESSION["id"] ?? "";
            $nom = trim($_POST["nom"] ?? '');
            $prenom = $infoProfil[0]["prenom"] ?? "";
            $adresse = $infoProfil[0]["adresse_livraison"] ?? "";
            $ville = $infoProfil[0]["ville"] ?? "";
            $cp = $infoProfil[0]["code_postal"] ?? "";
            $tel = $infoProfil[0]["telephone"] ?? "";
            $pays = $infoProfil[0]["pays"] ?? "";
            $paiement = $infoProfil[0]["prenom"] ?? "";


            if (!empty($idUtilisateur)) {
                if (empty($infoProfil[0]["nom"])) {
                    $etat =  $this->infoJoueur->createInfoUser($idUtilisateur, $prenom, $nom, $adresse, $ville, $cp, $tel, $pays, $paiement);
                    if ($etat) {
                        header("Location: ?action=jeu");
                        exit();
                    } else {
                        $_SESSION["message"] = "Une erreur c'est produite !";
                        header("Location: ?action=jeu");
                        exit();
                    }
                }
                $this->params["message"] = "Vous avez déjà entré votre nom !";
                return $this->pageLayout->render("page_jeu.php", $this->params);
            }
            $content = "page_jeu.php";
            $this->pageLayout->render($content, $this->params);
        }
    }
}
