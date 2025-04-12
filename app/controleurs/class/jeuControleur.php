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
        $this->params["style"] = "style_jeu.css";


    }

    public function pageJeu(){

        if($this->connexion->accesMiddleware()){
            $content = "page_jeu.php";
            $this->pageLayout->render($content);
        }else{
            $this->params["style"] = "style_connexion.css";
            $content = "page_connexion.php";
            $this->pageLayout->render($content, $this->params);
        
        }
    }


}