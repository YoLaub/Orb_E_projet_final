<?php
require_once RACINE . "app/modeles/bddUtilisateur.php";
require RACINE."app/controleurs/navigation_ctrl.php";


// recuperation des donnees GET, POST, et SESSION
if (isset($_POST["email"]) && isset($_POST["mdp"])){
    $mailU=$_POST["email"];
    $mdpU=$_POST["mdp"];

    // traitement si necessaire des donnees recuperees
    $connexion = new GestionConnexion;
    $connexion->connexion($email, $mdp);
}
else
{
    $email=null;
    $mdp=null;
}

if(isset($connexion)){
    $etat = false;
    $etat = $connexion->estConnecte();

    if ($etat){ // si l'utilisateur est connecté on redirige vers le controleur monProfil
        include RACINE . "app/controleurs/profil_ctrl.php";
    }
}else{ // l'utilisateur n'est pas connecté, on affiche le formulaire de connexion
    // appel du script de vue 
    include RACINE . "app/vues/page_header.php";
    include RACINE . "app/vues/page_connexion.php";
    include RACINE . "app/vues/page_footer.php";
}

?>