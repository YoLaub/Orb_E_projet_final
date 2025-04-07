document.addEventListener("DOMContentLoaded", () => {
    // Ouvrir la modal
    document.querySelectorAll('[data-modal-target]').forEach(btn => {
      btn.addEventListener("click", (e) => {
        const modal = document.querySelector(btn.dataset.modalTarget);
        if (modal) modal.style.display = "flex";
      });
    });
  
    // Fermer la modal via le bouton close
    document.querySelectorAll('[data-close]').forEach(closeBtn => {
      closeBtn.addEventListener("click", () => {
        closeBtn.closest(".modal-overlay").style.display = "none";
      });
    });
  
    // Fermer la modal en cliquant en dehors du contenu
    document.querySelectorAll(".modal-overlay").forEach(modal => {
      modal.addEventListener("click", (e) => {
        if (e.target === modal) modal.style.display = "none";
      });
    });

    let window_width = window.innerWidth;
    let table = document.querySelectorAll(".commande-table");

    
    if(window_width < 768){
      table.forEach(element => {
        element.style.display = "none";
      });
    }
  });
  