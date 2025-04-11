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
    <p class="errorMessage"></p>

    <form action="./?action=contact" method="post" class="contact-form" id = "contact">
        <input type="text" id="name" name="nom" placeholder="Votre nom" required><br>
        <input type="email" id="email" name="email" placeholder="Votre email" required><br>
        <input type="hidden" name= "prtg" id ="">
        <textarea id="message" name="message" placeholder="Votre message" required></textarea><br>
        <p class="maxChar"></p>
        <div class="check">
        <label for = "acceptTerms"> J'accepte les conditions d'utilisation</label>
        <input type="checkbox" name="acceptTerms">
        </div>
        <input type="submit" name="envoyer" value="Envoyer">
    </form>
</section>