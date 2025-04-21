document.addEventListener("DOMContentLoaded", function () {
    let form = document.querySelector(".connexion-form");
    let emailInput = form.querySelector('input[name="email"]');
    let passwordInput = document.getElementById("passwordInput");

    let passwordError = document.getElementById("passwordError");

    form.addEventListener("submit", function (e) {
        let email = emailInput.value.trim();
        let password = passwordInput.value;

        let valid = true;
        let errorMessage = "";

        // Vérification email
        let emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailPattern.test(email)) {
            valid = false;
            errorMessage = "Veuillez entrer une adresse email valide.";
        }

        // Vérification mot de passe
        let passwordSecure =
            /[A-Z]/.test(password) &&          // au moins une majuscule
            /[a-z]/.test(password) &&          // au moins une minuscule
            /[0-9]/.test(password) &&          // au moins un chiffre
            /[^A-Za-z0-9]/.test(password) &&   // au moins un caractère spécial
            password.length >= 6 ;
            
        if (!passwordSecure) {
            valid = false;
            errorMessage = "Le mot de passe doit contenir au moins 6 caractères, une majuscule, une minuscule, un chiffre et un caractère spécial.";
        }

        if(email.length == 0 && password.length == 0){
            valid = false;
            errorMessage = "Veuillez remplir les champs";
        }

        if (!valid) {
            e.preventDefault();
            passwordError.style.display = "block";
            passwordError.textContent = errorMessage;
        } else {
            passwordError.style.display = "none";
        }
    });

        //::::::::::::::::::::::::::::::::
    // MODAL
    //::::::::::::::::::::::::::::::::
    let inscription = document.querySelector("#gameModal");

    function hideModal(selector){
        selector.style.display = "none";
        
    }

    if(inscription){
        setTimeout(() => hideModal(inscription), 1000);
    }
});
