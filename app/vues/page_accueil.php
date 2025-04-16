<div class="modal">
    <div id="cookie-banner">
        <p>Nous utilisons des cookies pour analyser le trafic de notre site et améliorer votre expérience.
            <a class="rgpd" href="?action=rgpd">En savoir plus</a>.
        </p>
        <button id="accept-cookies">Accepter</button>
    </div>
</div>

<section class="intro">
    <div class="presentation">
        <h1>orb'e</h1>
        <p class="presParag">Découvrez Orb’E, L'Assistant personnel.</p>
        <a href="?action=produit">En savoir plus !</a>
    </div>
    <div class="orbe">
        <img src="./publique/images/3.webp" alt="orb'e">
    </div>
</section>

<section class="podium"> 
    <h1>Podium</h1>
    <article class="steps">
        
        <div class="step second">
            <div class="rank">#2</div>
            <div class="score" aria-label ="score" ><?= !empty($commande["meilleurJoueur"][1]["meilleur_score"]) 
    ? htmlspecialchars($commande["meilleurJoueur"][1]["meilleur_score"] . " pts") 
    : ""; ?></div>
            <div class="pseudo"  aria-label ="email" ><?=!empty($commande["meilleurJoueur"][1]["pseudo"]) ? htmlspecialchars($commande["meilleurJoueur"][1]["pseudo"]) : "" ?></div>
            </div>

        <!-- 1ère place -->
        <div class="step first">
            <div class="rank">#1</div>
            <div class="score" aria-label ="score" ><?=!empty($commande["meilleurJoueur"][0]["meilleur_score"]) ? htmlspecialchars($commande["meilleurJoueur"][0]["meilleur_score"] . " pts") : ""?></div>
            <div class="pseudo" aria-label ="email" ><?=!empty($commande["meilleurJoueur"][0]["pseudo"]) ? htmlspecialchars($commande["meilleurJoueur"][0]["pseudo"]) : ""?></div>
        </div>

        <!--  3e place -->
        <div class="step third">
            <div class="rank">#3</div>
            <div class="score" aria-label ="score" ><?=!empty($commande["meilleurJoueur"][2]["meilleur_score"]) ? htmlspecialchars($commande["meilleurJoueur"][2]["meilleur_score"] . " pts") : "" ?></div>
            <div class="pseudo" aria-label ="email" ><?=!empty($commande["meilleurJoueur"][2]["pseudo"]) ? htmlspecialchars($commande["meilleurJoueur"][2]["pseudo"]) : "" ?></div>
        </div>
    </article>
    </section>


<section class="jouer">
    <div class="presentationSuite">
        <h1>Jouez</h1>
        <p>Relevez le défi avec le jeu Orb’E ! Évitez les obstacles, profitez d'une météo dynamique et tentez d'obtenir le score le plus élevé pour débloquer une surprise exclusive.</p>
    </div>
    <div class="jeuPresentation">
        <a class="orbe-titre" href="?action=jeu">orb'e</a>
        <img src="./publique/images/mini_jeu1.webp" alt="le jeu orb'e" loading="lazy">

    </div>


</section>

<section class="commander ">

    <div class="catSection">
        <a class="catButton orbe-titre" href="?action=commande">orb'e</a>
        <img class="cat" src="./publique/images/mini_jeu2.webp" alt="le rêve orb'e" loading="lazy">
    </div>

    <div class="presentation">
        <h1>Commandez</h1>
        <p>Prêt à transformer votre quotidien avec Orb’E ? Commandez dès maintenant et découvrez l'Assistant personnel , propulsé par Lya, qui s'adapte à vos besoins.</p>
    </div>

</section>

<aside class="contactAccueil">
    <a href="?action=contact">Contactez nous !</a>
</aside>

