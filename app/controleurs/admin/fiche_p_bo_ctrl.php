<?php
    require RACINE."app/controleurs/navigation_ctrl.php";
    require_once RACINE . "app/modeles/bddProduit.php";


    $id_produit = $_SESSION["id_produit"];
    $connexion = new DBProduct();
    $detailProduit = $connexion->getProductById($id_produit);

    

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $nom = trim($_POST["nom"] ?? '');
        $description = trim($_POST["description"] ?? '');
        $prix = trim($_POST["prix"] ?? '');
        $photo = trim($_POST["photo"] ?? '');
        $dispo = trim($_POST["dispo"] ?? '');
        
       
        if ($nom && $description &&  $prix && $photo && $dispo) {
           $etat = $connexion->updateProduct($id_produit, $nom, $description, $prix, $photo, $dispo);
    
            if ($etat) {
                unset($_SESSION["id_produit"]);
                $validation = "Les modifications ont été enregstrée";
                header("Location: ?action=produit");
            } else {
                $validation = "Une erreur c'est produite";
                // Redirection vers l'accueil si connexion réussie
                header("Location: ?action=fiche");
            }
        }
    } else {
    
        //Affichage des vues
        include_once RACINE . "app/vues/page_header.php";
        include_once RACINE . "app/vues/admin/page_ficheP_bo.php";
        include_once RACINE . "app/vues/page_footer.php"; 
    }


?>