<h1>Profil de <?=$commande["informations"][0]["prenom"] . " " . $commande["informations"][0]["nom"]; ?></h1>

<h2>Informations Personnelles</h2>
<p><strong>Email :</strong> <?=$commande["email"];?></p>
<p><strong>Nom :</strong> <?=$commande["informations"][0]["nom"];?></p>
<p><strong>Prénom :</strong> <?=$commande["informations"][0]["prenom"]; ?></p>
<p><strong>Adresse :</strong> <?=$commande["informations"][0]["adresse_livraison"]; ?></p>
<p><strong>Ville :</strong> <?=$commande["informations"][0]["ville"]; ?></p>
<p><strong>Code Postal :</strong> <?=$commande["informations"][0]["code_postal"]; ?></p>
<p><strong>Téléphone :</strong> <?=$commande["informations"][0]["telephone"]; ?></p>



<h2>Historique des commandes</h2>

<?php if (!empty($commande["commandes"])) : ?>
    <ul>
        <?php foreach ($commande["commandes"] as $laCommande) : ?>
            <li>Commande #<?=var_dump($laCommande); ?> </li>
        <?php endforeach; ?>
    </ul>
<?php else : ?>
    <p>Aucune commande enregistrée.</p>
<?php endif; ?>

<h2>Mes échanges</h2>
<?=var_dump($commande["mesMessages"])?>

<h2>Les réponses</h2>
<?=var_dump($commande["mesReponses"])?>

<h2>Scores</h2>
<?php if (!empty($commande["score"])) : ?>
    <ul>
        <li><strong>Meilleur Score :</strong> <?php echo $commande["score"][0]["meilleur_score"]; ?></li>
        <li><strong>Score Moyen :</strong> <?php echo number_format($commande["score"][0]["score_moyen"], 2); ?></li>
        <li><strong>Nombre de Parties :</strong> <?php echo $commande["score"][0]["nombre_parties"]; ?></li>
    </ul>
<?php else : ?>
    <p>Aucun score enregistré.</p>
<?php endif; ?>