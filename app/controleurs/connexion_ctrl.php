<?php

require RACINE . "app/controleurs/navigation_ctrl.php";


use app\class\GestionConnexion;





// Vérification de la requête POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST["email"] ?? '');
    $mdp = trim($_POST["password"] ?? '');


    if (!empty($email) && !empty($mdp)) {
 
        $connexion = new GestionConnexion();
        $estConnecte = $connexion->connexion($email, $mdp);

        if ($estConnecte==true && isset($_SESSION["role"]) && $_SESSION["role"] == "utilisateur") {
            // Redirection vers l'accueil si connexion réussie
            header("Location: ?action=accueil");
        }elseif($estConnecte == true && isset($_SESSION["role"]) && $_SESSION["role"] == "admin"){
            header("Location: ?action=accueilBo");
        }else{
            header("Location: ?action=connexion");
        }   
        exit(); // Assure que le script s'arrête ici
    }else{
        header("Location: ?action=connexion");
    }
}else{

    if(isset($_SESSION)){
        $connexion = new GestionConnexion();
        $connexion->deconnexion();
    }
    
    
    // Inclusion de la page connexion avec un message d'erreur si nécessaire
    include RACINE . "app/vues/page_header.php";
    include RACINE . "app/vues/page_connexion.php";
    include RACINE . "app/vues/page_footer.php";

}


?>
