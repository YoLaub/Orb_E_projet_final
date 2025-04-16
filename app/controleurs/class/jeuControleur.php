<?php

namespace app\controleurs\class;

use app\middleware\Middleware;
use app\modeles\DBParty;

class JeuControleur
{
    private $pageLayout;
    private $connexion;
    private $partie;
    private $params;

    public function __construct()
    {
        $this->pageLayout = new RenderLayout;
        $this->connexion = new Middleware;
        $this->partie = new DBParty;
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

            $this->params["lastScore"] = $this->partie->getLastScores($_SESSION['id']);

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
}
