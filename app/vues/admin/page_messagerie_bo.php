<section>
    <h1>Messagerie</h1>

    <div class="messagerie">
        <article class="chat-container">

            <h2>📨 Messages reçus</h2>

            <?php foreach ($commande["lesMessages"] as $message): ?>
                <div class="message-bulle user">
                    <div class="message-header">
                        <strong><?= htmlspecialchars($message["nom"]) ?></strong>
                        <span><?= $message["created_at"] ?></span>
                    </div>
                    <p class="message-text"><?= htmlspecialchars($message["message"]) ?></p>
                    <small><?= htmlspecialchars($message["email"]) ?> — ID: <?= $message["id_contact"] ?></small>

                    <form action="./?action=messagerie" method="post">
                        <input type="hidden" name="id_contact" required value="<?= $message["id_contact"] ?>">

                        <label for="reponse">Votre réponse :</label>
                        <textarea name="reponse" rows="4" required placeholder="Tapez votre message ici..."></textarea>

                        <button type="submit">Envoyer</button>
                    </form>
                </div>

            <?php endforeach; ?>

        </article>


        <article class="chat-container">

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

        </article>


    </div>


</section>