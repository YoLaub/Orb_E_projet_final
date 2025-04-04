
const icon = document.querySelector('.icon');
const content = document.querySelector('.article-content');
icon.addEventListener("click", function () {
if (content.style.maxHeight) {
    content.style.maxHeight = null;
    icon.textContent = "+";
} else {
    content.style.maxHeight = content.scrollHeight + "px";
    icon.textContent = "-";
}
})

