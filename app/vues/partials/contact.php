<form class="info-form" action="./?action=<?= $commande["action"] ?>" method="post">

    <label for="message">Message :</label>
    <textarea id="message" name="message" aria-label ="message" required></textarea><br>

    <button type="submit" aria-label ="envoyer">Envoyer</button>
</form>