<?php
namespace app\controleurs\class;

use InvalidArgumentException;

class MenuControleur {
    private $menu;
    private $nav;

    public function __construct($menu) {
        if (empty($menu)) {
            throw new InvalidArgumentException("L'ID du menu ne peut pas être vide.");
        }
        $this->menu = $menu;
        $this->nav = "<nav id='" . $menu . "' class='nav-hidden'>";
        $this->nav .= "<ul id='listMenu'>";
    }

    public function prepareNav(){

        if(isset($_SESSION["role"]) && $_SESSION["role"] == "admin"){
            
             $this->nav .= $this->addItem("./?action=accueilBo","Tableau de bord");
             $this->nav .= $this->addItem("./?action=utilisateur","Gestion utilisateur");
             $this->nav .= $this->addItem("./?action=produit","Gestion de produit");
             $this->nav .= $this->addItem("./?action=messagerie","Messagerie");
        
            return $this->nav .= $this->getNav();
        }else{
            //Création du menu
            
            $this->nav .= $this->addItem("./?action=accueil","Accueil");
            $this->nav .= $this->addItem("./?action=jeu","Jouer");
            $this->nav .= $this->addItem("./?action=produit","Orb'E");
            $this->nav .= $this->addItem("./?action=qui","Qui sommes nous ?");
            $this->nav .= $this->addItem("./?action=contact","Contactez-nous");
        
            return $this->nav .= $this->getNav();
        }
    }

    private function addItem($link, $nameLink) {
        if (empty($link) || empty($nameLink)) {
            throw new InvalidArgumentException("Le lien et le nom du lien ne peuvent pas être vides.");
        }
        $this->nav .= "<li><a href='" . $link . "'>";
        $this->nav .= $nameLink . "</a></li>";
    }

    

    private function getNav() {
        $this->nav .= "</ul></nav>";
    }

   
}
?>