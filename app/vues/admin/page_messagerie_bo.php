<h1>Messagerie</h1>

<section class="chat-container">

    <h2>📨 Messages reçus</h2>

    <?php foreach ($commande["lesMessages"] as $message): ?>
        <div class="message-bulle user">
            <div class="message-header">
                <strong><?= htmlspecialchars($message["nom"]) ?></strong>
                <span><?= $message["created_at"] ?></span>
            </div>
            <p class="message-text"><?= htmlspecialchars($message["message"]) ?></p>
            <small><?= htmlspecialchars($message["email"]) ?> — ID: <?= $message["id_contact"] ?></small>
        </div>
    <?php endforeach; ?>

</section>

<section class="form-container">
    <h2>💬 Répondre</h2>

    <form action="./?action=messagerie" method="post">
        <label for="id">ID du message :</label>
        <input type="number" name="id_contact" required placeholder="Ex : 12">

        <label for="reponse">Votre réponse :</label>
        <textarea name="reponse" rows="4" required placeholder="Tapez votre message ici..."></textarea>

        <button type="submit">Envoyer</button>
    </form>
</section>

<section class="chat-container">
    <h2>✅ Vos réponses envoyées</h2>

    <?php foreach ($commande["lesReponses"] as $reponse): ?>
        <div class="message-bulle admin">
            <div class="message-header">
                <strong>Admin #<?= $reponse["id_admin"] ?></strong>
                <span><?= $reponse["created_at"] ?></span>
            </div>
            <p class="message-text"><?= htmlspecialchars($reponse["reponse"]) ?></p>
            <small>En réponse au message ID <?= $reponse["id_contact"] ?></small>
        </div>
    <?php endforeach; ?>
</section>
