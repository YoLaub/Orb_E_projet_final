<section>
    <h1>Mon profile</h1>
<article>

<h2>Mon score</h2>
<?php if (!empty($commande["score"])) : ?>
    <ul>
        <li><strong>Meilleur Score :</strong> <?= $commande["score"][0]["meilleur_score"] ?></li>
        <li><strong>Score Moyen :</strong> <?= number_format($commande["score"][0]["score_moyen"], 2, ',', ' ') ?></li>
        <li><strong>Nombre de Parties :</strong> <?= $commande["score"][0]["nombre_parties"] ?></li>
    </ul>
<?php else : ?>
    <p>Aucun score enregistré.</p>
<?php endif; ?>

<div class="remise-container">
  <h3>Votre remise</h3>
  <div class="remise-bar">
    <div class="remise-progress" style="width: <?= min(100, ($commande["score"][0]["meilleur_score"] / 1500) * 100) ?>%;"></div>
    <div class="remise-step" style="left: 33%;">5%</div>
    <div class="remise-step" style="left: 66%;">10%</div>
    <div class="remise-step" style="left: 100%;">15%</div>
  </div>
  <p class="remise-texte">
    Remise actuelle :
    <strong>
      <?php
        $score = $commande["score"][0]["meilleur_score"];
        if ($score >= 1500) echo "15%";
        elseif ($score >= 1000) echo "10%";
        elseif ($score >= 500) echo "5%";
        else echo "0%";
      ?>
    </strong>
  </p>
</div>


</article>

<article>

<div class = "mesInfos">
<h2>Mes informations</h2>
<p><span>Email :</span> <?=$commande["email"];?></p>
<p><span>Nom :</span> <?=$commande["informations"][0]["nom"];?></p>
<p><span>Prénom :</span> <?=$commande["informations"][0]["prenom"]; ?></p>
<p><span>Adresse :</span> <?=$commande["informations"][0]["adresse_livraison"]; ?></p>
<p><span>Ville :</span> <?=$commande["informations"][0]["ville"]; ?></p>
<p><span>Code Postal :</span> <?=$commande["informations"][0]["code_postal"]; ?></p>
<p><span>Téléphone :</span> <?=$commande["informations"][0]["telephone"]; ?></p>
<p><span>Paiement :</span> <?=$commande["informations"][0]["mode_paiement"]; ?></p>

</div>


<div>
<button class="btn-modifier" data-modal-target="#modalInfos">Modifier mes informations</button>

<div id="modalInfos" class="modal-overlay">
  <div class="modal-content">
    <span class="modal-close" data-close>&times;</span>
    <?= $commande["formulaire"] ?>
  </div>
</div>

</div>

</article>

<article id = "commande_contenair">

<h2>Historique des commandes</h2>

<script id ="detail_commande" type="application/json">
    <?=$commande["commandes"]?>
</script>

</article>

<article>

<h2>Mes échanges</h2>
<div class="echange">
<?php if (!empty($commande["mesMessages"])) : ?>
    <ul>
        <?php foreach ($commande["mesMessages"] as $msg) : ?>
            <li><strong>[<?= $msg["Date_message"] ?>]</strong> <?= htmlspecialchars($msg["Message"]) ?></li>
        <?php endforeach; ?>
    </ul>
<?php else : ?>
    <p>Aucun message.</p>
<?php endif; ?>

<h2>Les réponses</h2>
<?php if (!empty($commande["mesReponses"])) : ?>
    <ul>
        <?php foreach ($commande["mesReponses"] as $rep) : ?>
            <li><strong>[<?= $rep["Date_message"] ?>]</strong> <?= htmlspecialchars($rep["Message"]) ?></li>
        <?php endforeach; ?>
    </ul>
<?php else : ?>
    <p>Aucune réponse.</p>
<?php endif; ?>
</div>

<div>

<?=$commande["reponse"]?>

</div>

</article>

</section>



