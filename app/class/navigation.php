<?php

class Navigation {
    private $menu;
    private $nav;

    public function __construct($menu) {
        if (empty($menu)) {
            throw new InvalidArgumentException("L'ID du menu ne peut pas être vide.");
        }
        $this->menu = $menu;
        $this->nav = "<nav id='" . htmlspecialchars($menu, ENT_QUOTES, 'UTF-8') . "'>";
        $this->nav .= "<ul id='listMenu'>";
    }

    public function addItem($link, $nameLink) {
        if (empty($link) || empty($nameLink)) {
            throw new InvalidArgumentException("Le lien et le nom du lien ne peuvent pas être vides.");
        }
        $this->nav .= "<li><a href='" . htmlspecialchars($link, ENT_QUOTES, 'UTF-8') . "'>";
        $this->nav .= htmlspecialchars($nameLink, ENT_QUOTES, 'UTF-8') . "</a></li>";
    }

    public function getNav() {
        $this->nav .= "</ul></nav>";
        return $this->nav;
    }
}
?>