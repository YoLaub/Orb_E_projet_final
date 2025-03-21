<?php


// appel des fonctions permettant de recuperer les donnees utiles a l'affichage 
if (isLoggedOn()){
    $mailU = getMailULoggedOn();
    $util = getUtilisateurByMailU($mailU);
    
    $mesRestosAimes = getRestosAimesByMailU($mailU);
    
    $mesTypeCuisineAimes = getTypesCuisinePreferesByMailU($mailU);
    // traitement si necessaire des donnees recuperees


    // appel du script de vue qui permet de gerer l'affichage des donnees
    $titre = "Mon profil";
    include RACINE . "/vue/entete.html.php";
    include RACINE . "/vue/vueMonProfil.php";
    include RACINE . "/vue/pied.html.php";
} else {
    $titre = "Mon profil";
    include RACINE . "/vue/entete.html.php";
    include RACINE . "/vue/pied.html.php";
}

?>