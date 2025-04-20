// Attend que le DOM soit complètement chargé avant d'exécuter le code
document.addEventListener("DOMContentLoaded", function () {
    // Récupère l'élément contenant l'image d'aperçu et le masque par défaut
    var image = document.querySelector(".photo-preview");
    image.style.display = "none";

    // Écoute le changement de fichier sur l'input "photo"
    document.getElementById('photo').addEventListener('change', function (event) {
        var file = event.target.files[0]; // Récupère le fichier sélectionné

        var preview = document.getElementById('previewImage'); // L'élément <img> destiné à l'aperçu

        if (file) {
            // Si un fichier est sélectionné, on affiche l'aperçu
            image.style.display = "block";

            var reader = new FileReader(); // Crée un lecteur de fichier

            // Quand le fichier est chargé, on l'affiche dans l'élément <img>
            reader.onload = function (e) {
                preview.src = e.target.result;
            };

            reader.readAsDataURL(file); // Convertit le fichier en URL base64
        } else {
            // Réinitialise l'aperçu si aucun fichier n'est sélectionné
            preview.src = "";
        }
    });
});
