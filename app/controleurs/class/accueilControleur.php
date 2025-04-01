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
            $role = $_SESSION["role"];
            if($role == "utilisateur"){
                $content = "page_accueil.php";
                $this->pageLayout->render($content);
            }else{
                $content = "admin/page_accueil_bo.php";
                $this->pageLayout->render($content);
            }
        }else{
            $content = "page_accueil.php";
                $this->pageLayout->render($content);
        }
    }
}