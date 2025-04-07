
const icon = document.querySelectorAll('.icon');
const content = document.querySelectorAll('.article-content');
const svgIconPlus =  `
<svg width="24" height="24" fill="white" class="bi bi-plus-lg" viewBox="0 0 16 16"> 
  <path fill-rule="evenodd" d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2"/>
</svg>
`;

const svgIconMoins = `
<svg xmlns=width="24" height="24" fill="white" class="bi bi-dash-lg" viewBox="0 0 16 16">
  <path fill-rule="evenodd" d="M2 8a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11A.5.5 0 0 1 2 8"/>
</svg>
`;


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

