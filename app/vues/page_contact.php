<section>

    <h1>Contactez-nous</h1>
    <p>
        <?php
        if (isset($_SESSION["message"])) {
            echo $_SESSION["message"];
        } else {
            echo $commande["message"];
        }
        ?>
    </p>

    <form action="./?action=contact" method="post" class="contact-form">
        <input type="text" id="name" name="nom" placeholder="Votre email" required><br>

        <input type="email" id="email" name="email" placeholder="Votre prenom" required><br>

        <textarea id="message" name="message" placeholder="Votre message" required></textarea><br>

        <button type="submit">Envoyer</button>
    </form>

    <div class="imageRogne">
        <img src="./publique/images/contact.webp" alt="Image de lettre design">

    </div>
</section>