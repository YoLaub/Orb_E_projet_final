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


                $content = "page_qui.php";
                $this->pageLayout->render($content, $this->params);
        }


        public function pageEngagement()
        {


                $content = "page_nos_engagement.php";
                $this->pageLayout->render($content, $this->params);
        }
        public function pageCgv()
        {


                $content = "page_cgv.php";
                $this->pageLayout->render($content, $this->params);
        }
        public function pageFaq()
        {


                $content = "page_faq.php";
                $this->pageLayout->render($content, $this->params);
        }
        public function pageRgpd()
        {


                $content = "page_rgpd.php";
                $this->pageLayout->render($content, $this->params);
        }
}
