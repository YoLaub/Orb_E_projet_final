<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
        content="Découvrez Orb'E, l'assistant personnel intelligent et innovant. Jouez à notre mini-jeu interactif, cumulez des points et bénéficiez de réductions exclusives sur votre achat. Un mélange unique de technologie !">
    <meta name="language" content="fr">
    <meta name="Geography" content="Vannes, FR, 56000">
    <meta name="customer" content="FR-USER-<?php
                                            if (isset($_SESSION['id'])) {
                                                echo $_SESSION['id'];
                                            } else {
                                                echo "00";
                                            } ?> ">
    <meta name="author" content="AY-Lab">

    <link rel="icon" href="./publique/images/logo/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="./publique/css/style.css">
    <title>Orb'E</title>
</head>

<body>

    <header>

        <?=$navContent?>

        <?=var_dump($_SESSION)?><br>
        <?=var_dump(debug_print_backtrace())  ?><br>

       <?php
       if(isset($_SESSION["id"])){?>
            <a href="./?action=profile">Mon profile</a>
            <a href="./?action=deconnexion">Deconnexion</a>
            
            <?php
       }else{
        ?><a href="./?action=connexion">Connexion</a><?php
       }
       ?>
        
        
    </header>