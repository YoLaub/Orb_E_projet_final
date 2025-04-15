<section>

    <h1>Contactez-nous</h1>

    <form action="./?action=contact" method="post" class="contact-form" id = "contact">
        <input type="text" id="name" name="nom" placeholder="Votre nom" required><br>
        <input type="email" id="email" name="email" value ="<?=$_SESSION["email"] ?? ""?>" placeholder="Votre email" required><br>
        <input type="hidden" name= "prtg" id ="">
        <textarea id="message" name="message" placeholder="Votre message" required></textarea><br>
        <p class="maxChar"></p>
        <div class="check">
        <label for = "acceptTerms"> J'accepte <a class="rgpd" href="?action=rgpd">la politique de confidentialité</a> de AyLab</label>
        <input type="checkbox" name="acceptTerms" id="term">
        </div>
        <div class = "sendMessage">
            <input type="submit" name="envoyer" value="Envoyer">
            <p class="errorMessage"></p>
            <p class = "send"></p>
        </div>
        
    </form>
</section>