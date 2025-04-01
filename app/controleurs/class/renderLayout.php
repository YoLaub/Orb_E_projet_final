<?php

namespace app\controleurs\class;

class renderLayout
{

    public function __construct()
    {
        
    }

    public function render($target){

        $pageLayout = null;

        ob_start();

        require_once RACINE . 'app/vues/' . $target;

        $pageContent = ob_get_clean();

        if ($pageLayout !== null) {
            require_once $pageLayout;
        }
        else {
            echo $pageContent;
        }

    }


}