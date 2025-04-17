document.addEventListener("DOMContentLoaded", function () {
    let cookieBanner = document.getElementById("cookie-banner");
    let acceptButton = document.getElementById("accept-cookies");
    let modal = document.querySelector(".modal");


    // Vérifie si le consentement a déjà été donné
    if (!getCookie("cookieConsent")) {
        cookieBanner.style.display = "block";
        modal.style.display = "block";
    }

    // Lorsque l'utilisateur accepte
    acceptButton.addEventListener("click", function () {
        setCookie("cookieConsent", "accepted", 1); 
        cookieBanner.style.display = "none"; 
        modal.style.display = "none";
    });

    // Fonction pour définir un cookie
    function setCookie(name, value, days) {
        let expires = new Date();
        expires.setTime(expires.getTime() + (days * 24 * 60 * 60 * 1000)); // Expire dans le nombre de jours spécifié
        document.cookie = name + "=" + value + ";expires=" + expires.toUTCString() + ";path=/";
    }

    // Fonction pour récupérer la valeur d'un cookie
    function getCookie(name) {
        let nameEQ = name + "=";
        let ca = document.cookie.split(";");
        for (let i = 0; i < ca.length; i++) {
            let c = ca[i];
            while (c.charAt(0) == " ") c = c.substring(1, c.length);
            if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
        }
        return null;
    }

    let selector = document.querySelector("#successModal");

    function hideModal(selector){
        selector.style.display = "none";
        
    }

    if(selector){
        setTimeout(() => hideModal(selector), 2000);
    }
  
});
