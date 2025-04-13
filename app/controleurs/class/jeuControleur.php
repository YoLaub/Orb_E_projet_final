<?php

namespace app\controleurs\class;

use app\middleware\Middleware;

class JeuControleur
{
    private $pageLayout;
    private $connexion;
    private $params;

    public function __construct()
    {
        $this->pageLayout = new RenderLayout;
        $this->connexion = new Middleware;
        $this->params["style"] = "orbe.css";
        $this->params["scripts"] = '<script type="module" src="./publique/scripts/orbe/ballRun.js" defer></script>';


    }

    public function pageJeu(){

        if($this->connexion->accesMiddleware()){
            $content = "page_jeu.php";
            $this->pageLayout->render($content, $this->params);
        }else{
            header("Location: ?action=connexion");
        
        }
    }


}