<?php
    require RACINE."app/controleurs/navigation_ctrl.php";
    require_once RACINE . "app/modeles/bddProduit.php";
    require_once RACINE . "app/modeles/bddUtilisateur.php";

   
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        
    
        switch (true) {
            case isset($_POST["id_produit"]):
                $connexion = new DBProduct();
                $etat = $connexion->deleteProduct($_POST["id_produit"]);
                $validation = $etat ? "Produit supprimé !" : "Une erreur s'est produite";
                header("Location: ?action=produit");
                exit;
    
            case isset($_POST["id_utilisateur"]):
                $connexion = new DBUser();
                $etat = $connexion->deleteUser(intval($_POST["id_utilisateur"]));
                $validation = $etat ? "Utilisateur supprimé !" : "Une erreur s'est produite";
                header("Location: ?action=utilisateur");
                exit;
    
            default:
                header("Location: ?action=utilisateur");
                exit;
        }
    } else {
        header("Location: ?action=utilisateur");
        exit;
    }
    
   

