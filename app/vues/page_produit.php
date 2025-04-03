
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
    <div class="partage">
                <p>Partager sur :</p>
                <a href="https://www.facebook.com/sharer/sharer.php?u=<?=urlencode('https://ton-site.com/produit.php?id='.$commande["Detail produit"][0]["id"])?>" target="_blank">
                    <img src="facebook-icon.png" alt="Partager sur Facebook">
                </a>
                <a href="https://twitter.com/intent/tweet?text=<?=urlencode($commande["Detail produit"][0]["nom"].' - '.$commande["Detail produit"][0]["description"])?>&url=<?=urlencode('https://ton-site.com/produit.php?id='.$commande["Detail produit"][0]["id"])?>" target="_blank">
                    <img src="twitter-icon.png" alt="Partager sur Twitter">
                </a>
                <a href="https://api.whatsapp.com/send?text=<?=urlencode($commande["Detail produit"][0]["nom"].' - '.$commande["Detail produit"][0]["description"].' '. 'https://ton-site.com/produit.php?id='.$commande["Detail produit"][0]["id"])?>" target="_blank">
                    <img src="whatsapp-icon.png" alt="Partager sur WhatsApp">
                </a>
            </div>

</section>






