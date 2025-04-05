
const icon = document.querySelectorAll('.icon');
const content = document.querySelectorAll('.article-content');
const svgIconPlus =  `<svg width="24" height="24" fill="white" class="bi bi-zoom-in" viewBox="0 0 16 16">
<path fill-rule="evenodd" d="M6.5 12a5.5 5.5 0 1 0 0-11 5.5 5.5 0 0 0 0 11M13 6.5a6.5 6.5 0 1 1-13 0 6.5 6.5 0 0 1 13 0"/>
<path d="M10.344 11.742q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1 6.5 6.5 0 0 1-1.398 1.4z"/>
<path fill-rule="evenodd" d="M6.5 3a.5.5 0 0 1 .5.5V6h2.5a.5.5 0 0 1 0 1H7v2.5a.5.5 0 0 1-1 0V7H3.5a.5.5 0 0 1 0-1H6V3.5a.5.5 0 0 1 .5-.5"/>
</svg>`;

const svgIconMoins = `<svg width="24" height="24" fill="white" class="bi bi-zoom-out" viewBox="0 0 16 16">
  <path fill-rule="evenodd" d="M6.5 12a5.5 5.5 0 1 0 0-11 5.5 5.5 0 0 0 0 11M13 6.5a6.5 6.5 0 1 1-13 0 6.5 6.5 0 0 1 13 0"/>
  <path d="M10.344 11.742q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1 6.5 6.5 0 0 1-1.398 1.4z"/>
  <path fill-rule="evenodd" d="M3 6.5a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5"/>
</svg>`;


icon.forEach(element => {

    element.innerHTML = svgIconPlus;
    
});

let count = 0;

icon[0].addEventListener("click", function () {
if (content[0].style.maxHeight) {
    content[0].style.maxHeight = null;
    icon[0].innerHTML = svgIconPlus;
    count ++;
    console.log(count);
} else {
    content[0].style.maxHeight = content[0].scrollHeight + "px";
    icon[0].innerHTML = svgIconMoins;
    count ++;
    console.log(count);
}
})
icon[1].addEventListener("click", function () {
if (content[1].style.maxHeight) {
    content[1].style.maxHeight = null;
    icon[1].innerHTML = svgIconPlus;
    count ++;
    console.log(count);
} else {
    content[1].style.maxHeight = content[1].scrollHeight + "px";
    icon[1].innerHTML = svgIconMoins;
    count ++;
    console.log(count);
}
})
icon[2].addEventListener("click", function () {
if (content[2].style.maxHeight) {
    content[2].style.maxHeight = null;
    icon[2].innerHTML = svgIconPlus;
    count ++;
    console.log(count);
} else {
    content[2].style.maxHeight = content[2].scrollHeight + "px";
    icon[2].innerHTML = svgIconMoins;
    count ++;
    console.log(count);
}
})

