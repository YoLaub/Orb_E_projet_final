var image = document.querySelector(".photo-preview");
image.style.display ="none";

document.getElementById('photo').addEventListener('change', function (event) {
    var file = event.target.files[0];
    
    var preview = document.getElementById('previewImage');

     if (file) {
        image.style.display ="block";
        var reader = new FileReader();

        reader.onload = function (e) {
            preview.src = e.target.result;
        };

        reader.readAsDataURL(file);

    } else {
        preview.src = ""; // réinitialise si aucun fichier sélectionné
    }
});