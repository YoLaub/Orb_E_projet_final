<?php

namespace app\controleurs\class;

class ArticleControleur
{
        // Attributs privés pour la gestion du rendu et des paramètres de page
        private $pageLayout; // Objet pour le rendu HTML de la page
        private $params;     // Paramètres à passer à la vue

        public function __construct()
        {
                // Initialisation du moteur de rendu et des paramètres de base
                $this->pageLayout = new RenderLayout;
                $this->params = array();

                // Ajout de la feuille de style commune à toutes les pages articles
                $this->params["style"] = "style_article.css";
        }

        // Affichage de la page "Qui sommes-nous ?"
        public function pageQui()
        {
                $this->params["page"] = "Qui sommes nous ?";
                $content = "page_qui.php";
                $this->pageLayout->render($content, $this->params);
        }

        // Affichage de la page "Nos engagements"
        public function pageEngagement()
        {
                $this->params["page"] = "Nos engagements";
                $content = "page_nos_engagement.php";
                $this->pageLayout->render($content, $this->params);
        }

        // Affichage de la page "Conditions générales de vente"
        public function pageCgv()
        {
                $this->params["page"] = "Conditions de vente";
                $content = "page_cgv.php";
                $this->pageLayout->render($content, $this->params);
        }

        // Affichage de la page "Foire aux questions"
        public function pageFaq()
        {
                $this->params["page"] = "Faq";
                $content = "page_faq.php";
                $this->pageLayout->render($content, $this->params);
        }

        // Affichage de la page "Politique de confidentialité (RGPD)"
        public function pageRgpd()
        {
                $this->params["page"] = "Politique de confidentialité";
                $content = "page_Rgpd.php";
                $this->pageLayout->render($content, $this->params);
        }
}
