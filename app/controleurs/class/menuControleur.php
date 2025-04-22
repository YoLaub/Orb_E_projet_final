<?php

namespace app\controleurs\class;

use InvalidArgumentException;

class MenuControleur
{
    private $menu; // ID du menu HTML
    private $nav;  // Contenu HTML du menu (balise <nav> + <ul>)

    public function __construct($menu)
    {
        // Vérifie que l'ID du menu est bien fourni
        if (empty($menu)) {
            throw new InvalidArgumentException("L'ID du menu ne peut pas être vide.");
        }

        $this->menu = $menu;

        // Initialise la balise <nav> avec l'ID et une classe cachée par défaut
        $this->nav = "<nav id='" . $menu . "' class='nav-hidden'>";
        $this->nav .= "<ul id='listMenu'>"; // Début de la liste d'éléments du menu
    }

    // Prépare le contenu HTML du menu selon le rôle de l'utilisateur
    public function prepareNav()
    {
        // Si l'utilisateur est un administrateur
        if (isset($_SESSION["role_visiteur"]) && $_SESSION["role_visiteur"] == "admin") {

            $this->nav .= $this->addItem("accueilBo", "Tableau de bord");
            $this->nav .= $this->addItem("utilisateur", "Gestion utilisateur");
            $this->nav .= $this->addItem("produit", "Gestion de produit");
            $this->nav .= $this->addItem("messagerie", "Messagerie");

            return $this->nav .= $this->getNav(); // Termine et retourne le menu admin
        } else {
            // Sinon, on crée le menu pour un utilisateur standard

            $this->nav .= $this->addItem("accueil", "Accueil");
            $this->nav .= $this->addItem("jeu", "Jouer");
            $this->nav .= $this->addItem("produit", "Orb'E");
            $this->nav .= $this->addItem("qui", "Qui sommes nous ?");
            $this->nav .= $this->addItem("contact", "Contactez-nous");

            return $this->nav .= $this->getNav(); // Termine et retourne le menu utilisateur
        }
    }

    // Génère un élément <li><a></a></li> pour un item du menu
    private function addItem($link, $nameLink)
    {
        // Vérifie que le lien et son nom ne sont pas vides
        if (empty($link) || empty($nameLink)) {
            throw new InvalidArgumentException("Le lien et le nom du lien ne peuvent pas être vides.");
        }

        // Crée et retourne un item HTML
        $this->nav .= "<li><a href='" . $link . "'>";
        $this->nav .= $nameLink . "</a></li>";
    }

    // Termine la structure HTML du menu
    private function getNav()
    {
        $this->nav .= "</ul></nav>";
    }
}
