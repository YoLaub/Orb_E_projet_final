<section class="contenaire">

    <h2><?= $commande["Detail produit"][0]["nom"] ?></h2>
    <div class=fiche_produit>
        <div id="visualisation-3d"></div>
        <div class="produit-details">
            <p><?= $commande["Detail produit"][0]["description"] ?></p>
            <p><strong>Prix : </strong><?= $commande["Detail produit"][0]["prix"] ?>
                <svg class="bi bi-currency-euro" viewBox="0 0 16 16">
                    <path d="M4 9.42h1.063C5.4 12.323 7.317 14 10.34 14c.622 0 1.167-.068 1.659-.185v-1.3c-.484.119-1.045.17-1.659.17-2.1 0-3.455-1.198-3.775-3.264h4.017v-.928H6.497v-.936q-.002-.165.008-.329h4.078v-.927H6.618c.388-1.898 1.719-2.985 3.723-2.985.614 0 1.175.05 1.659.177V2.194A6.6 6.6 0 0 0 10.341 2c-2.928 0-4.82 1.569-5.244 4.3H4v.928h1.01v1.265H4v.928z" />
                </svg>
            </p>
            <p><strong>Disponibilité : </strong><?= $commande["Detail produit"][0]["disponibilite"] ?></p>
            <button><a href="./?action=<?= $keys[0] ?>"><?= $commande[$keys[0]] ?></a></button>

            <?= $commande["partage"] ?>

        </div>

    </div>

</section>

<section class="contenaire">
    <article>
        <div class="article-header">
            <h2>Antigravitation !</h2>
            <div class="icon"></div>
        </div>
        <div class="article-content">
            <img src="./publique/images/noyaux.webp" alt="Technologie d'Antigravitation">
            <div>
                <h3>Introduction à l'Antigravitation :</h3>
                <p>L'une des innovations les plus révolutionnaires d'Orb'E réside dans sa capacité à défier la gravité. Grâce à une percée majeure dans notre compréhension des forces gravitationnelles, AY-Lab a développé une technologie d'antigravitation qui permet à Orb'E de flotter librement dans l'espace.</p>
                <h3>Principe de Fonctionnement :</h3>
                <p>Bien que les détails exacts de cette technologie restent confidentiels pour des raisons économique, nous pouvons révéler qu'elle repose sur une manipulation avancée des champs gravitationnels. En exploitant les relations entre la densité énergétique et la gravité, Orb'E est capable d'annuler les effets de la gravité terrestre, lui permettant de se déplacer sans contrainte.</p>
                <h3>Applications et Avantages :</h3>
                <p>Cette technologie ouvre la voie à de nouvelles possibilités dans divers domaines, de la mobilité personnelle à l'exploration spatiale. Orb'E, en tant que pionnier, démontre comment l'antigravitation peut transformer notre interaction avec l'environnement, offrant une liberté de mouvement inégalée.</p>

            </div>

        </div>
    </article>
    <article>
        <div class="article-header">
            <h2>Projection d'Image !</h2>
            <div class="icon"></div>
        </div>
        <div class="article-content">
            <img src="./publique/images/projection.webp" alt="Projection d'Image sur Orb'E">
            <div>
                <h3>Technologie de Projection Holographique :</h3>
                <p>Orb'E est équipé d'une technologie de projection d'image avancée qui transforme sa surface sphérique en un écran interactif. Cette innovation permet de projeter des images en donnant une impression de 3D, en jouant avec la courbure naturelle de la sphère.</p>
                <h3>Fonctionnement et Caractéristiques :</h3>
                <p>La projection est réalisée grâce à des micro-LEDs intégrées dans la surface d'Orb'E, capables de produire des images nettes et lumineuses. En utilisant des algorithmes de rendu avancés, les images semblent flotter au-dessus de la surface, créant une expérience visuelle immersive.</p>
                <h3>Utilisations et Bénéfices :</h3>
                <p>Cette technologie est idéale pour des applications allant du divertissement à l'éducation. Les utilisateurs peuvent visualiser des informations, regarder des vidéos ou même interagir avec des interfaces utilisateur directement sur la surface d'Orb'E, offrant une expérience utilisateur unique et engageante.</p>

            </div>

        </div>
    </article>
    <article>
        <div class="article-header">
            <h2>Énergie Infinie !</h2>
            <div class="icon"></div>
        </div>
        <div class="article-content">
            <img src="./publique/images/photosynth.webp" alt="Captation d'Énergie Lumineuse">
            <div>
                <h3>Énergie Lumineuse et Photosynthèse :</h3>
                <p>Orb'E utilise une technologie de captation d'énergie lumineuse inspirée par les processus naturels de la photosynthèse. Cette approche permet à Orb'E de convertir la lumière en énergie, offrant une source d'alimentation quasi infinie.</p>
                <h3>Principe de la Captation Lumineuse :</h3>
                <p>La surface d'Orb'E est recouverte de cellules photovoltaïques ultra-efficaces qui capturent la lumière ambiante et la convertissent en énergie électrique. En optimisant le rapport entre la consommation d'énergie et la masse, Orb'E est capable de fonctionner avec une consommation minimale, tout en offrant des performances optimales.</p>
                <h3>Impact et Avantages :</h3>
                <p>Cette technologie rend Orb'E écologique et autonome, réduisant la dépendance aux sources d'énergie traditionnelles. En s'inspirant des mécanismes naturels, AY-Lab prouve qu'il est possible de créer des technologies durables et efficaces, ouvrant la voie à un avenir où l'énergie est abondante et respectueuse de l'environnement.</p>

            </div>

        </div>
    </article>
</section>