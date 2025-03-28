<h1>Profil de <?php echo htmlspecialchars($informations[0]["prenom"] . " " . $informations[0]["nom"]); ?></h1>

<h2>Informations Personnelles</h2>
<p><strong>Email :</strong> <?php echo htmlspecialchars($email); ?></p>
<p><strong>Nom :</strong> <?php echo htmlspecialchars($informations[0]["nom"]); ?></p>
<p><strong>Prénom :</strong> <?php echo htmlspecialchars($informations[0]["prenom"]); ?></p>
<p><strong>Adresse :</strong> <?php echo htmlspecialchars($informations[0]["adresse_livraison"]); ?></p>
<p><strong>Ville :</strong> <?php echo htmlspecialchars($informations[0]["ville"]); ?></p>
<p><strong>Code Postal :</strong> <?php echo htmlspecialchars($informations[0]["code_postal"]); ?></p>
<p><strong>Téléphone :</strong> <?php echo htmlspecialchars($informations[0]["telephone"]); ?></p>

<h2>Modifier les informations</h2>
<form action="./?action=profile" method="post">
    <label>Prénom : <input type="text" name="prenom" value="<?php echo htmlspecialchars($informations[0]["prenom"]); ?>"></label><br>
    <label>Nom : <input type="text" name="nom" value="<?php echo htmlspecialchars($informations[0]["nom"]); ?>"></label><br>
    <label>Adresse : <input type="text" name="adresse" value="<?php echo htmlspecialchars($informations[0]["adresse_livraison"]); ?>"></label><br>
    <label>Ville : <input type="text" name="ville" value="<?php echo htmlspecialchars($informations[0]["ville"]); ?>"></label><br>
    <label>Code Postal : <input type="text" name="cp" value="<?php echo htmlspecialchars($informations[0]["code_postal"]); ?>"></label><br>
    <label>Téléphone : <input type="text" name="tel" value="<?php echo htmlspecialchars($informations[0]["telephone"]); ?>"></label><br>
    <button type="submit">Modifier</button>
</form>

<h2>Historique des commandes</h2>

<?php if (!empty($commandes)) : ?>
    <ul>
        <?php foreach ($commandes as $commande) : ?>
            <li>Commande #<?php echo $commande["id_commande"]; ?> - Montant : <?php echo $commande["montant_total"]; ?> € - Date : <?php echo $commande["date_heure"]; ?>- Status : <?php echo $commande["statut"]; ?></li>
        <?php endforeach; ?>
    </ul>
<?php else : ?>
    <p>Aucune commande enregistrée.</p>
<?php endif; ?>

<h2>Mes échanges</h2>
<?=var_dump($mesMessages)?>

<h2>Les réponses</h2>
<?=var_dump($mesReponses)?>

<h2>Scores</h2>
<?php if (!empty($score)) : ?>
    <ul>
        <li><strong>Meilleur Score :</strong> <?php echo $score[0]["meilleur_score"]; ?></li>
        <li><strong>Score Moyen :</strong> <?php echo number_format($score[0]["score_moyen"], 2); ?></li>
        <li><strong>Nombre de Parties :</strong> <?php echo $score[0]["nombre_parties"]; ?></li>
    </ul>
<?php else : ?>
    <p>Aucun score enregistré.</p>
<?php endif; ?>