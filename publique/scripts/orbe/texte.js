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

    hide() {
        this.visible = false;
    }

    show() {
        this.visible = true;
    }
}
