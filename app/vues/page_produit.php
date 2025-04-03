
<section>

<h1 style="text-align: center;">Fiche Produit</h1>
    <div class="produit-container">
        <img src=<?=$commande["Detail produit"][0]["photo"]?> alt="Drone Orbe" loading="lazy">
        <div class="produit-details">
            <h2><?=$commande["Detail produit"][0]["nom"]?></h2>
            <p><?=$commande["Detail produit"][0]["description"]?></p>
            <p><strong>Prix :</strong><?=$commande["Detail produit"][0]["prix"]?></p>
            <p><strong>Disponibilité :</strong><?=$commande["Detail produit"][0]["disponibilite"]?></p>
            <a href="./?action=<?=$keys[0]?>"><?=$commande[$keys[0]]?></a>
        </div>
    </div>

</section>






