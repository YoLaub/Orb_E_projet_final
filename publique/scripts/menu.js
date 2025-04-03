
document.addEventListener("DOMContentLoaded", function () {
    const menuToggle = document.querySelector(".menu-toggle");
    const nav = document.querySelector("nav");
    const body = document.body;
    let count = 1;
 

    menuToggle.addEventListener("click", function () {
        nav.classList.toggle("open");
        body.classList.toggle("menu-open");
        count ++;
        console.log(count);
    });
});


