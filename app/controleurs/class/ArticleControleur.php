<?php

namespace app\controleurs\class;

class ArticleControleur{

    private $pageLayout;

    public function __construct()
    {
        $this->pageLayout = new renderLayout;
    }

    public function pageQui(){

       
            $content = "page_qui.php";
            $this->pageLayout->render($content);
        
    }

    public function pageMention(){

       
            $content = "page_mention.php";
            $this->pageLayout->render($content);
        
    }

    public function pageRgpd(){

       
            $content = "page_Rgpd.php";
            $this->pageLayout->render($content);
        
    }
}