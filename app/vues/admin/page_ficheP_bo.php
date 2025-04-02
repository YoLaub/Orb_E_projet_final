<?php
require_once RACINE . "app/controleurs/navigation_ctrl.php";
include RACINE . "app/vues/page_header.php";

?>

 
 <h1>Edition de la fiche produit</h1>

 <h2>Modifier les informations</h2>
 <p>
    <?php
    if(isset($_SESSION["message"])){
        echo $_SESSION["message"];
    }else{
        echo $commande["message"];
    }
    ?>
</p>
<form action="./?action=fiche" method="post">
    <label>Nom : <input type="text" name="nom" value="<?=$commande["detailProduit"][0]["nom"]; ?>"></label><br>
    <label>Description : 
    <textarea name="description" > <?=$commande["detailProduit"][0]["description"]; ?>
    </textarea></label><br>
    <label>Prix : <input type="text" name="prix" value="<?=$commande["detailProduit"][0]["prix"]; ?>"></label><br>
    <label>Photo : <input type="text" name="photo" value="<?=$commande["detailProduit"][0]["photo"]; ?>"></label><br>
    <label>Disponibilité : <input type="text" name="dispo" value="<?=$commande["detailProduit"][0]["disponibilite"]; ?>"></label><br>
   
    <button type="submit">Valider</button>
</form>

<?php

include RACINE . "app/vues/page_footer.php";

?>