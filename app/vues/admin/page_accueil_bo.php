
<h1>accès BO ok</h1>

<h2>
    Tableau de bord vente:
</h2>

<?=var_dump($commande["lesCommandes"])?>


<h2>Nombre d'utilisateurs: <?=$commande["lesUtilisateurs"][0]["count(*)"]?></h2>


<h2>
    Tableau de bord Jeu:
</h2>

<?=var_dump($commande["meilleurJoueur"])?>

