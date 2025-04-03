<?php

namespace app\controleurs\class;

use app\controleurs\class\MenuControleur;

class renderLayout
{
    private $menuPrincipale;

    public function __construct()
    {
        $this->menuPrincipale = new MenuControleur("menu_principale"); 

        
    }

    public function render($target, $params = [], $return = false){

        ob_start();

        $navContent = $this->menuPrincipale->prepareNav();
        $commande = $params;
        $keys = array_keys($params);
        


        require_once RACINE . "app/vues/page_header.php";
        require_once RACINE . 'app/vues/' . $target;
        require_once RACINE . "app/vues/page_footer.php";

        $pageContent = ob_get_clean();

        if ($return) {
            return $pageContent;
        }

        echo $pageContent;
    }
    }
