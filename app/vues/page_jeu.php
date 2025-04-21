<section>
        <h1>orbe</h1>

        <p>Participez au tour du monde d'Orb'E en jouant. Tentez de marquer un maximum de points pendant votre balade. Elle se termine à la fin de la musique !</p>
        <p>Évitez les obstacles en sautant par dessus. Des bonus peuvent apparaître pour vous aider... mais attention, certains pourraient bien vous piéger !</p>
        <p>À chaque mort, votre score est réinitialisé, mais la partie continue. Survivez le plus longtemps possible pour cumuler les points. Une surprise vous attend… et peut-être même la première place du podium !</p>

        <!-- Zone de jeu -->
        <div id="console">
                <canvas id="gameCanvas" width="800" height="400">
                </canvas>
                <div class="control">
                        <div id="startRestart">
                                <p id="full"></p>
                                <p id="start">Start</p>
                                <p id="restart">Restart</p>
                        </div>
                        <div id="jump">
                                <img src="./publique/images/jump.png" alt="boule qui rebondit">
                        </div>
                </div>
        </div>

        <!-- Modal de fin de jeu pour le partage -->
        <div id="game-end-modal" class="modal hidden">
                <div class="modal-content">
                        <h2>Bravo ! </h2>
                        <p>Tu as fait un score de <span id="final-score"></span> points !</p>

                        <form action="?action=save" method="post">
                                <input type="text" name="nom" placeholder="Votre nom.." value="<?= $commande["infoProfil"][0]["nom"] ?? "" ?>" aria-label="nom"><br>
                                <div class="btn">
                                        <button id="share-btn">Partager</button>
                                        <button type="submit" id="retry-btn">Rejouer</button>
                                </div>
                        </form>
                        <aside id="partage-alt">
                                <ul id="shareIcon">

                                        <li>
                                                <a href="https://t.me/share/url?url=https://stagiaires-kercode9.greta-bretagne-sud.org/yoann-laubert/Orb_E_projet_final/&text=J'ai fait <?= $_SESSION["score"] ?? "" ?> points sur ce jeu trop cool !">
                                                        <svg class="bi bi-telegram" viewBox="0 0 16 16">
                                                                <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M8.287 5.906q-1.168.486-4.666 2.01-.567.225-.595.442c-.03.243.275.339.69.47l.175.055c.408.133.958.288 1.243.294q.39.01.868-.32 3.269-2.206 3.374-2.23c.05-.012.12-.026.166.016s.042.12.037.141c-.03.129-1.227 1.241-1.846 1.817-.193.18-.33.307-.358.336a8 8 0 0 1-.188.186c-.38.366-.664.64.015 1.088.327.216.589.393.85.571.284.194.568.387.936.629q.14.092.27.187c.331.236.63.448.997.414.214-.02.435-.22.547-.82.265-1.417.786-4.486.906-5.751a1.4 1.4 0 0 0-.013-.315.34.34 0 0 0-.114-.217.53.53 0 0 0-.31-.093c-.3.005-.763.166-2.984 1.09" />
                                                        </svg>
                                                </a>
                                        </li>

                                        <li>
                                                <a href="https://wa.me/?text=J'ai fait <?= $_SESSION["score"] ?? "" ?> points sur ce jeu trop cool ! https://stagiaires-kercode9.greta-bretagne-sud.org/yoann-laubert/Orb_E_projet_final/">
                                                        <svg class="bi bi-whatsapp" viewBox="0 0 16 16">
                                                                <path d="M13.601 2.326A7.85 7.85 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.9 7.9 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.9 7.9 0 0 0 13.6 2.326zM7.994 14.521a6.6 6.6 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.56 6.56 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592m3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.73.73 0 0 0-.529.247c-.182.198-.691.677-.691 1.654s.71 1.916.81 2.049c.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232" />
                                                        </svg>
                                                </a>
                                        </li>
                                        <li>
                                                <a href="https://twitter.com/intent/tweet?text=J'ai%20fait%20un%20score%20de%20<?= $_SESSION["score"] ?? "" ?>%20dans%20ce%20jeu%20!%20Essayez%20le%20aussi%20:%20https://stagiaires-kercode9.greta-bretagne-sud.org/yoann-laubert/Orb_E_projet_final/" target="_blank">
                                                        <svg class="bi bi-twitter-x" viewBox="0 0 16 16">
                                                                <path d="M12.6.75h2.454l-5.36 6.142L16 15.25h-4.937l-3.867-5.07-4.425 5.07H.316l5.733-6.57L0 .75h5.063l3.495 4.633L12.601.75Zm-.86 13.028h1.36L4.323 2.145H2.865z" />
                                                        </svg>
                                                </a>
                                        </li>
                                </ul>
                        </aside>
                </div>
        </div>
</section>

