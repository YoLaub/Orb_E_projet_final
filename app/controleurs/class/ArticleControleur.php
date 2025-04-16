<?php

namespace app\controleurs\class;

class ArticleControleur
{

        private $pageLayout;
        private $params;

        public function __construct()
        {
                $this->pageLayout = new RenderLayout;
                $this->params = array();
                $this->params["style"] = "style_article.css";
        }

        public function pageQui()
        {

                $this->params["page"] = "Qui sommes nous ?";
                $content = "page_qui.php";
                $this->pageLayout->render($content, $this->params);
        }


        public function pageEngagement()
        {

                $this->params["page"] = "Nos engagements";
                $content = "page_nos_engagement.php";
                $this->pageLayout->render($content, $this->params);
        }
        public function pageCgv()
        {

                $this->params["page"] = "Conditions de vente";
                $content = "page_cgv.php";
                $this->pageLayout->render($content, $this->params);
        }
        public function pageFaq()
        {

                $this->params["page"] = "Faq";
                $content = "page_faq.php";
                $this->pageLayout->render($content, $this->params);
        }
        public function pageRgpd()
        {

                $this->params["page"] = "Politique de confidentialité";
                $content = "page_rgpd.php";
                $this->pageLayout->render($content, $this->params);
        }
}
