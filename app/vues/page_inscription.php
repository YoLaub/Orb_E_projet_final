<section id="inscription">
    <h2>inscription</h2>
    <form action="./?action=inscription_ctrl">
        <input type="text" name="prenom" placeholder="votre prénom">
        <p class ="alert"><?=$validation?></p>
        <input type="text" name="nom" placeholder="votre nom">
        <p class ="alert"><?=$validation?></p>
        <input type="text" name="email" placeholder="votre email">
        <p class ="alert"><?=$validation?></p>
        <input type="text" name="mdp" placeholder="votre mot de passe">
        <p class ="alert"><?=$validation?></p>
        <button type="submit">Valider</button>
    </form>
</section>