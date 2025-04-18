document.addEventListener("DOMContentLoaded", function () {
  let form = document.getElementById("contact");
  let error = document.querySelector(".errorMessage");
  let send = document.querySelector(".send");

  form.addEventListener("submit", function (e) {
    e.preventDefault(); // on empêche l'envoi immédiat
  
    let nom = document.querySelector('input[name="nom"]').value;
    let email = document.querySelector('input[name="email"]').value;
    let message = document.querySelector('textarea[name="message"]').value;
    let term = document.querySelector("#term");
  
    let valid = true;
    let errorMessage = "";
  
    // Vérification email
    let emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailPattern.test(email)) {
      valid = false;
      errorMessage = "Veuillez entrer une adresse email valide.";
    }
  
    if (message.length < 10) {
      valid = false;
      errorMessage = "Minimum 10 caractères";
    }
  
    if (nom.length < 2) {
      valid = false;
      errorMessage = "Minimum 2 caractères";
    }
  
    if (!term.checked) {
      valid = false;
      errorMessage = "Veuillez cocher les conditions d'utilisation";
    }
  
    if (!valid) {
      error.style.display = "block";
      error.textContent = errorMessage;
    } else {
      error.style.display = "none";
      send.innerHTML = "Envoi en cours... ✈️";

      setTimeout(() => {
        send.innerHTML = "Message envoyé !";
      }, 2000);
  
      // Animation ou effet ici si tu veux (par exemple fade ou logo animé)
  
      // Attente de 3 secondes avant soumission réelle
      setTimeout(() => {
        form.submit();
      }, 3000);
    }
  });

  let infoMessage = document.querySelector(".maxChar");
  let maxChar = 300;
  let inputSubmit = document.querySelector('input[name="envoyer"]');

  document.getElementById("message").addEventListener("input", function (e) {

    infoMessage.innerHTML = `${this.value.length}/ ${maxChar}`;

    if (this.value.length >= maxChar) {
      e.preventDefault();
      valid = false;
      infoMessage.innerHTML = "";
      infoMessage.innerHTML = "Max caractère atteind !";
      inputSubmit.style.display = "none";
    }else{
        inputSubmit.style.display = "block";
    }
  });
});
