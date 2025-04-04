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


    public function pageEngagement(){

       
            $content = "page_nos_engagement.php";
            $this->pageLayout->render($content);
        
    }
    public function pageCgv(){

       
            $content = "page_cgv.php";
            $this->pageLayout->render($content);
        
    }
    public function pageFaq(){

       
            $content = "page_Faq.php";
            $this->pageLayout->render($content);
        
    }
    public function pageRgpd(){

       
            $content = "page_rgpd.php";
            $this->pageLayout->render($content);
        
    }
}