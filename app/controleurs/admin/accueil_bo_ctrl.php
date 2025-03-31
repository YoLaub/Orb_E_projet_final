<?php
    require RACINE."app/controleurs/navigation_ctrl.php";


    use app\modeles\DBUser;
    use app\modeles\DBProduct;
    use app\modeles\DBOrder;
    use app\modeles\DBParty;

    $connexionUtilisateur = new DBUser();
    $connexionProduit = new DBProduct();
    $connexionCommande = new DBOrder();
    $connexionJeu = new DBParty();

    $count = 5;
    
    $lesCommandes = $connexionCommande->getAllOrder(); 
    $lesUtilisateurs = $connexionUtilisateur->numberOfUser(); 
    $meilleurJoueur = $connexionJeu->getFiveBestScores($count); 


    //Affichage des vues
    include_once RACINE . "app/vues/page_header.php";
    include_once RACINE . "app/vues/admin/page_accueil_bo.php";
    include_once RACINE . "app/vues/page_footer.php"; 


?>