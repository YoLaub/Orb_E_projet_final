document.addEventListener("DOMContentLoaded", function () {
  let form = document.getElementById("contact");
  let error = document.querySelector(".errorMessage");
  let errorMessage = "";

  form.addEventListener("submit", function (e) {
    let nom = document.querySelector('input[name="nom"]').value;
    let email = document.querySelector('input[name="email"]').value;
    let message = document.querySelector('textarea[name="message"]').value;

    let valid = true;
    // Vérification email
    let emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailPattern.test(email)) {
      valid = false;
      errorMessage += "Veuillez entrer une adresse email valide.";
    }

    if (message.length < 10) {
      valid = false;
      errorMessage += "Minimum 10 caractère";
    }

    if (nom.length < 2) {
      valid = false;
      errorMessage += "Minimum 2 caractère";
    }

    if (!valid) {
      e.preventDefault();
      error.style.display = "block";
      error.textContent = errorMessage;
    } else {
      error.style.display = "none";
    }
  });

  let infoMessage = document.querySelector(".maxChar");
  let maxChar = 3000;
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
