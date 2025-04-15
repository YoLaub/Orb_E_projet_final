document.addEventListener("DOMContentLoaded", function () {
  let menuToggle = document.querySelector(".menu-toggle");
  let nav = document.querySelector("nav");
  let body = document.body;

  menuToggle.addEventListener("click", function () {
    nav.classList.toggle("open");
    body.classList.toggle("menu-open");
  });

  let links = document.querySelectorAll("#main-nav li a");
  links.forEach((link) => {
    if (link.href == window.location.href) {
      console.log(window.location.href);
      console.log(link.href);

      link.classList.add("active");

    }
  });
});
