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
        $this->params["scripts"] = '<script type="module" src="./publique/scripts/orbe/ballRun.js" defer></script>';
    }

    public function pageJeu()
    {

        if ($this->connexion->accesMiddleware()) {

            $this->params["lastScore"] = $this->partie->getLastScores($_SESSION['id']);

            if ($_SERVER["REQUEST_METHOD"] === "POST") {

                $idUtilisateur = $_SESSION["id"] ?? "";
                $data = json_decode(file_get_contents("php://input"), true);
                $score = $data["score"] ?? "";

                if (!empty($idUtilisateur) && !empty($score)) {
                    $etat = $this->partie->saveScore($score, $idUtilisateur);
                    if ($etat) {
                        header("Location: ?action=jeu"); // Redirection vers la même page après POST
                        exit;
                    }else{
                        $this->params["message"] = "Une erreur c'est produite !";
                        return $this->pageLayout->render("page_jeu.php",$this->params);
                    }
                    $this->params["message"] = "Vous n'êtes probablement pas autorisé à participer, inscrivez vous !!";
                    return $this->pageLayout->render("page_jeu.php",$this->params);
                }
            }

            $content = "page_jeu.php";
            $this->pageLayout->render($content, $this->params);
        } else {
            header("Location: ?action=connexion");
        }
    }
}
