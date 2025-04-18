<?php

namespace app\controleurs\class;

use InvalidArgumentException;

class MenuControleur
{
    private $menu;
    private $nav;

    public function __construct($menu)
    {
        if (empty($menu)) {
            throw new InvalidArgumentException("L'ID du menu ne peut pas être vide.");
        }
        $this->menu = $menu;
        $this->nav = "<nav id='" . $menu . "' class='nav-hidden'>";
        $this->nav .= "<ul id='listMenu'>";
    }

    public function prepareNav()
    {

        if (isset($_SESSION["role"]) && $_SESSION["role"] == "admin") {

            $this->nav .= $this->addItem("accueilBo", "Tableau de bord");
            $this->nav .= $this->addItem("utilisateur", "Gestion utilisateur");
            $this->nav .= $this->addItem("produit", "Gestion de produit");
            $this->nav .= $this->addItem("messagerie", "Messagerie");

            return $this->nav .= $this->getNav();
        } else {
            //Création du menu

            $this->nav .= $this->addItem("accueil", "Accueil");
            $this->nav .= $this->addItem("jeu", "Jouer");
            $this->nav .= $this->addItem("produit", "Orb'E");
            $this->nav .= $this->addItem("qui", "Qui sommes nous ?");
            $this->nav .= $this->addItem("contact", "Contactez-nous");

            return $this->nav .= $this->getNav();
        }
    }

    private function addItem($link, $nameLink)
    {
        if (empty($link) || empty($nameLink)) {
            throw new InvalidArgumentException("Le lien et le nom du lien ne peuvent pas être vides.");
        }
        $this->nav .= "<li><a href='" . $link . "'>";
        $this->nav .= $nameLink . "</a></li>";
    }



    private function getNav()
    {
        $this->nav .= "</ul></nav>";
    }
}
