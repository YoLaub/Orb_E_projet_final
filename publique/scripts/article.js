
let svgIcon = document.querySelectorAll('.icon');
let content = document.querySelectorAll('.article-content');
let svgIconPlus =  `
<svg class="bi bi-plus-lg" viewBox="0 0 16 16"> 
  <path fill-rule="evenodd" d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2"/>
</svg>
`;

let svgIconMoins = `
<svg class="bi bi-dash-lg" viewBox="0 0 16 16">
  <path fill-rule="evenodd" d="M2 8a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11A.5.5 0 0 1 2 8"/>
</svg>
`;


svgIcon.forEach(element => {

    element.innerHTML = svgIconPlus;
    
});

let count = 0;

svgIcon[0].addEventListener("click", function () {
if (content[0].style.maxHeight) {
    content[0].style.maxHeight = null;
   svgIcon[0].innerHTML = svgIconPlus;
    
    console.log(count);
} else {
    content[0].style.maxHeight = content[0].scrollHeight + "px";
   svgIcon[0].innerHTML = svgIconMoins;
    
    console.log(count);
}
})
svgIcon[1].addEventListener("click", function () {
if (content[1].style.maxHeight) {
    content[1].style.maxHeight = null;
   svgIcon[1].innerHTML = svgIconPlus;
    
    console.log(count);
} else {
    content[1].style.maxHeight = content[1].scrollHeight + "px";
   svgIcon[1].innerHTML = svgIconMoins;
    
    console.log(count);
}
})
svgIcon[2].addEventListener("click", function () {
if (content[2].style.maxHeight) {
    content[2].style.maxHeight = null;
   svgIcon[2].innerHTML = svgIconPlus;
    
    console.log(count);
} else {
    content[2].style.maxHeight = content[2].scrollHeight + "px";
   svgIcon[2].innerHTML = svgIconMoins;
    
    console.log(count);
}
})

