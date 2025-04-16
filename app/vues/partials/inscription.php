<div id="inscription">

    <form class="connexion-form" action="./?action=<?= $commande["action"] ?>" method="post">
        <input type="email" name="email" placeholder="votre email" autocomplete="email" aria-label ="email" required>
        <input type="hidden" name="prtg">
        <div class="show_hide">
            <input id="passwordInput" type="password" name="mdp" autocomplete="current-password" placeholder="votre mot de passe" aria-label ="mot de passe" required>
            <div class="show"></div>
            <div class="hide"></div>
        </div>
        <p id="passwordError"></p>
        <button type="submit" aria-label ="envoyer">Valider</button>
    </form>
</div>