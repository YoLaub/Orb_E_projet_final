document.addEventListener("DOMContentLoaded", function () {

  let countriesData = [];

  let cpData = [];

  // Charger les données JSON (assure-toi que le chemin est correct)
  fetch('./publique/json/curiexplore-pays.json')
    .then(response => response.json())
    .then(data => {

      countriesData = data;
    });

  // Gérer la recherche en fonction des lettres tapées
  document.getElementById('searchInput').addEventListener('input', function () {
    console.log(countriesData)
    let query = this.value.toLowerCase();
    let results = countriesData.filter(pays =>
      pays.name_fr.toLowerCase().startsWith(query)
    );

    displayResults(results);
  });

  // Affiche les résultats dans une liste
  function displayResults(results) {
    let select = document.getElementById('resultList');
    select.innerHTML = '';

    results.forEach(pays => {

      select.innerHTML = `<option value="${pays.name_fr}">
                            ${pays.name_fr}
                        </option>`;

    });
  }



  // Gérer la recherche en fonction des lettres tapées
  document.getElementById("cpInput").addEventListener('input', function () {
    fetch(`https://apicarto.ign.fr/api/codes-postaux/communes/${this.value}`)
      .then(response => response.json())
      .then(data => {
        cpData = data;
  
        console.log(cpData)
        console.log(this.value)
  
        let select = document.getElementById("resultListCp");
        select.innerHTML = '';
  
        cpData.forEach(ville => {
          displayResultsCp(ville.nomCommune);
        });
      });
  });
  



  // Affiche les résultats dans une liste
  function displayResultsCp(nomCommune) {
    let select = document.getElementById("resultListCp"); // il manquait ça ici
    const option = document.createElement('option');
    option.value = nomCommune;
    option.textContent = nomCommune;
    select.appendChild(option);
  }



});
