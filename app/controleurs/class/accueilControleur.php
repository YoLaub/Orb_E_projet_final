<?php

namespace app\controleurs\class;

use app\modeles\DBUser;
use app\modeles\DBProduct;
use app\modeles\DBOrder;
use app\modeles\DBParty;

class accueilControleur{

    private $pageLayout;
    private $connexionUtilisateur;
    private $connexionProduit;
    private $connexionCommande;
    private $connexionJeu;

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
               return $this->accueilBo();
            }
        }else{
            $content = "page_accueil.php";
                $this->pageLayout->render($content);
        }
    }

    public function accueilBo(){
    
        $this->connexionUtilisateur = new DBUser();
        $this->connexionProduit = new DBProduct();
        $this->connexionCommande = new DBOrder();
        $this->connexionJeu = new DBParty();

        $count = 5;

        $params = [
            "lesCommandes" => $this->connexionCommande->getAllOrder(),
            "lesUtilisateurs" =>  $this->connexionUtilisateur->numberOfUser(),
            "meilleurJoueur" => $this->connexionJeu->getFiveBestScores($count)
            
        ];
    
        $content = "admin/page_accueil_bo.php";
        $this->pageLayout->render($content, $params);


    }
}