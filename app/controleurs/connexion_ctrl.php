<?php
require_once RACINE . "app/modeles/bddUtilisateur.php";


// recuperation des donnees GET, POST, et SESSION
if (isset($_POST["email"]) && isset($_POST["mdp"])){
    $mailU=$_POST["email"];
    $mdpU=$_POST["mdp"];
}
else
{
    $email=null;
    $mdp=null;
}

// appel des fonctions permettant de recuperer les donnees utiles a l'affichage 


// traitement si necessaire des donnees recuperees
$connexion = new GestionConnexion;
$connexion->connexion($email, $mdp);


if ($connexion->estConnecte()){ // si l'utilisateur est connecté on redirige vers le controleur monProfil
    include RACINE . "app/controleurs/profil_ctrl.php";
}
else{ // l'utilisateur n'est pas connecté, on affiche le formulaire de connexion
    // appel du script de vue 
    $titre = "Se connecter";
    include RACINE . "app/vues/page_header.php";
    include RACINE . "app/vues/page_connexion.php";
    include RACINE . "app/vues/page_footer.php";
}

?>