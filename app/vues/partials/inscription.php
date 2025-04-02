<section id="inscription">
    <h2>Ajouter un compte admnistrateur</h2>
    <p><?php if(isset($commande["message"]))
         {
         $commande["message"];
         }
    ?>
</p>
    <form action="./?action=<?=$commande["action"]?>" method="post">
        <input type="text" name="email" placeholder="votre email">
        <input type="text" name="mdp" placeholder="votre mot de passe">
        <button type="submit">Valider</button>
    </form>
</section>