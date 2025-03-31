<?php
    require RACINE."app/controleurs/navigation_ctrl.php";

    use app\modeles\DBUser;
    use app\modeles\DBProduct;

   
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        
        switch (true) {
            case isset($_POST["id_produit"]):
                $connexion = new DBProduct();
                $etat = $connexion->deleteProduct($_POST["id_produit"]);
                header("Location: ?action=produit");
                exit;
    
            case isset($_POST["id_utilisateur"]):
                $connexion = new DBUser();
                $etat = $connexion->deleteUser(intval($_POST["id_utilisateur"]));
                header("Location: ?action=utilisateur");
                exit;
            case isset($_POST["id_admin"]):
                $connexion = new DBUser();
                $etat = $connexion->deleteUser(intval($_POST["id_admin"]));
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
    
   

