<div id="inscription">

    <form class="connexion-form" action="./?action=<?=$commande["action"]?>" method="post">
        <input type="email" name="email" placeholder="votre email" require>
        <input type="hidden" name="prtg">
        <div class="show_hide">
            <input id="passwordInput" type="password" name="mdp" placeholder="votre mot de passe" require>
            <div class = "show"></div>
            <div class = "hide"></div>
        </div>
        <p id = "passwordError"></p>
        <button type="submit">Valider</button>
    </form>
</div>