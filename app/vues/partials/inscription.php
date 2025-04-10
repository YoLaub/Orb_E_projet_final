<section id="inscription">

    <form class="connexion-form" action="./?action=<?=$commande["action"]?>" method="post">
        <input type="email" name="email" placeholder="votre email">
        <input type="password" name="mdp" placeholder="votre mot de passe">
        <p id = "passwordError"></p>
        <button type="submit">Valider</button>
    </form>
</section>