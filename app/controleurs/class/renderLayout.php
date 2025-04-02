<?php

namespace app\controleurs\class;

class renderLayout
{

    public function __construct()
    {
        
    }

    public function render($target, $params = [], $return = false){

        ob_start();

        $commande = $params;
        $keys = array_keys($params);

        require_once RACINE . 'app/vues/' . $target;

        $pageContent = ob_get_clean();

        if ($return) {
            return $pageContent;
        }

        echo $pageContent;
    }
    }
