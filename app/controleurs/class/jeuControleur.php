<?php

namespace app\controleurs\class;

use app\middleware\Middleware;

class jeuControleur
{
    private $pageLayout;
    private $connexion;

    public function __construct()
    {
        $this->pageLayout = new renderLayout;
        $this->connexion = new Middleware;


    }

    public function pageJeu(){

        if($this->connexion->accesMiddleware()){
            $content = "page_jeu.php";
            $this->pageLayout->render($content);
        }else{
            $content = "page_connexion.php";
            $this->pageLayout->render($content);
        
        }
    }


}