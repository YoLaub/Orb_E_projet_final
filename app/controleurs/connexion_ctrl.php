<?php
require_once RACINE . "modeles/bddUtilisateur.php";


// recuperation des donnees GET, POST, et SESSION
if (isset($_POST["mailU"]) && isset($_POST["mdpU"])){
    $mailU=$_POST["mailU"];
    $mdpU=$_POST["mdpU"];
}
else
{
    $mailU=null;
    $mdpU=null;
}

// appel des fonctions permettant de recuperer les donnees utiles a l'affichage 


// traitement si necessaire des donnees recuperees
login($mailU,$mdpU);

if (isLoggedOn()){ // si l'utilisateur est connecté on redirige vers le controleur monProfil
    include RACINE . "app/controleurs/profil_ctrl.php";
}
else{ // l'utilisateur n'est pas connecté, on affiche le formulaire de connexion
    // appel du script de vue 
    $titre = "authentification";
    include RACINE . "/vues/page_header.php";
    include RACINE . "/vues/page_connexion.php";
    include RACINE . "/vues/page_footer.php";
}

?>