<?php

namespace app\controleurs\class;

class renderLayout
{

    public function __construct()
    {
        
    }

    public function render($target, $params = []){

        

        ob_start();

        $commande = $params;
        $keys = array_keys($params);

        require_once RACINE . 'app/vues/' . $target;

        $pageContent = ob_get_clean();

        
        echo $pageContent;
        

    }


}