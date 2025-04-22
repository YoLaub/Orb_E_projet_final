// Classe Texte permettant d'afficher et de gérer dynamiquement du texte dans un canvas
export class Texte {
    constructor({ id, text, font = "'Poppins'", size = 20, x = 0, y = 0, color = "#000", justify = "left", visible = true }) {
        this.id = id;             // identifiant unique du texte (pratique pour le retrouver et le modifier)
        this.text = text;         // contenu textuel à afficher
        this.font = font;         // police utilisée
        this.size = size;         // taille de la police
        this.x = x;               // position horizontale du texte
        this.y = y;               // position verticale du texte
        this.color = color;       // couleur du texte
        this.justify = justify;   // alignement du texte (left, center, right)
        this.visible = visible;   // contrôle la visibilité du texte
    }

    // Méthode d'affichage du texte sur un contexte canvas si visible est true
    draw(context) {
        if (!this.visible) return;    // ne rien afficher si invisible
        context.fillStyle = this.color;
        context.font = `${this.size}px ${this.font}`;
        context.textAlign = this.justify;
        context.fillText(this.text, this.x, this.y);
    }

    // Met à jour le contenu du texte
    updateText(newText) {
        this.text = newText;
    }

    // Met à jour la position horizontale du texte
    updatePosition(newX) {
        this.x = newX;
    }

    // Rend le texte invisible
    hide() {
        this.visible = false;
    }

    // Rend le texte visible
    show() {
        this.visible = true;
    }
}

// Récupération des éléments du DOM liés à la modale de fin de jeu
const modal = document.getElementById("game-end-modal");
const retryBtn = document.getElementById("retry-btn");
const share = document.getElementById("share-btn");

// Fonction qui ouvre la modale de fin de jeu avec le score final
export function openModal(score) {
    // Mise à jour du score affiché dans la modale
    document.getElementById("final-score").textContent = score;
    // Affiche la modale en retirant la classe hidden et ajoutant showModale
    modal.classList.remove("hidden");
    modal.classList.add("showModale");

    // Gestion du clic sur le bouton de partage
    share.addEventListener("click", function () {
        // Si la fenêtre est étroite (mobile)
        if (window.innerWidth < 768) {
            // Utilisation de l'API native de partage si disponible
            if (navigator.share) {
                navigator.share({
                    title: 'Mon score',
                    text: `Regarde mon score de fou : ${score} ! `,
                    url: window.location.href
                });
            } else {
                // Sinon affiche un menu de partage personnalisé
                document.querySelector('#partage-alt').style.display = "block";
            }
        } else {
            // Sur écran large, affiche également le menu de partage personnalisé
            document.querySelector('#partage-alt').style.display = "block";
        }
    })
}

// Fonction pour fermer la modale
function closeModal() {
    modal.classList.remove("show");
}

// Gestion du clic sur la modale : ferme si l'élément cliqué contient un attribut data-close
modal.addEventListener("click", (e) => {
    if (e.target.dataset.close !== undefined) {
        closeModal();
    }
});


