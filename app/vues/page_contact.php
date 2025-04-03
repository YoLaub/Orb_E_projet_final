

<h2>Contactez-nous</h2>

   <p>
    <?php 
    if(isset($_SESSION["message"])){
        echo $_SESSION["message"];
    }else{
        echo $commande["message"];
    }
    ?>
    </p>
    
    <form action="./?action=contact" method="post">
        <label for="name">Nom :</label>
        <input type="text" id="name" name="nom" required><br>

        <label for="email">Email :</label>
        <input type="email" id="email" name="email" required><br>

        <label for="message">Message :</label>
        <textarea id="message" name="message" required></textarea><br>

        <button type="submit">Envoyer</button>
    </form>

