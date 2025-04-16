export class Texte {
    constructor({ id, text, font = "'Poppins'", size = 20, x = 0, y = 0, color = "#000", justify = "left", visible = true }) {
        this.id = id; // identifiant unique pour modifier facilement un texte
        this.text = text;
        this.font = font;
        this.size = size;
        this.x = x;
        this.y = y;
        this.color = color;
        this.justify = justify;
        this.visible = visible;
    }

    draw(context) {
        if (!this.visible) return;
        context.fillStyle = this.color;
        context.font = `${this.size}px ${this.font}`;
        context.textAlign = this.justify;
        context.fillText(this.text, this.x, this.y);
    }

    updateText(newText) {
        this.text = newText;
    }

    updatePosition(newX) {
        this.x = newX;
    }

    hide() {
        this.visible = false;
    }

    show() {
        this.visible = true;
    }
}



const modal = document.getElementById("game-end-modal");
const retryBtn = document.getElementById("retry-btn");
const share = document.getElementById("share-btn");

// Ouvre la modale
export function openModal(score) {
    document.getElementById("final-score").textContent = score;
    modal.classList.remove("hidden");
    modal.classList.add("show");

    share.addEventListener("click", function () {

        if (window.innerWidth < 768) {
            if (navigator.share) {
                navigator.share({
                    title: 'Mon score',
                    text: `Regarde mon score de fou : ${score} ! `,
                    url: window.location.href
                });
            } else {
                // Affiche un menu personnalisé avec liens de partage
                document.querySelector('#partage-alt').style.display = "block";
  
            }
        }else{
            // Affiche un menu personnalisé avec liens de partage
            document.querySelector('#partage-alt').style.display = "block";

        }


    })
}

// Ferme la modale
function closeModal() {
    modal.classList.remove("show");
}

// Fermer en cliquant en dehors de .modal-content
modal.addEventListener("click", (e) => {
    if (e.target.dataset.close !== undefined) {
        closeModal();
    }
});

// Bouton rejouer
retryBtn.addEventListener("click", () => {
    location.reload();
    // ici tu peux relancer ton jeu
});




