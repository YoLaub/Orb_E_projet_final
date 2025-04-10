let countriesData = []; // stockera les pays

// Charger les données JSON (assure-toi que le chemin est correct)
fetch('curiexplore-pays.json')
  .then(response => response.json())
  .then(data => {
    countriesData = data;
  });

// Gérer la recherche en fonction des lettres tapées
document.getElementById('searchInput').addEventListener('input', function () {
  const query = this.value.toLowerCase();
  const results = countriesData.filter(pays =>
    pays.name_fr.toLowerCase().startsWith(query)
  );

  displayResults(results);
});

// Affiche les résultats dans une liste
function displayResults(results) {
  const list = document.getElementById('resultList');
  list.innerHTML = '';

  results.forEach(pays => {
    const li = document.createElement('li');
    li.textContent = pays.name_fr;
    list.appendChild(li);
  });
}
