<?php

namespace app\controleurs\class;

class accueilControleur{

    private $pageLayout;

    public function __construct()
    {
        $this->pageLayout = new renderLayout;
    }

    public function accueil(){

        if(isset($_SESSION["role"])){
            if($_SESSION["role"] == "utilisateur"){
                $content = "page_accueil.php";
                $this->pageLayout->render($content);
            }elseif($_SESSION["role"] == "admin"){
                $content = "admin/page_accueil_bo.php";
                $this->pageLayout->render($content);
            }
        }else{
            $content = "page_accueil.php";
                $this->pageLayout->render($content);
        }
    }
}