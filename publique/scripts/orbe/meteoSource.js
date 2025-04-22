let country = [
  ["PARIS", "48.8534", "2.3488"],
  ["MOSCOU", "55.7522", "37.6156"],
  ["TOKYO", "35.6895", "139.6917"],
  ["RIO", "-22.9064", "-43.1822"],
  ["JOHANNESBURG", "-26,2023", "28,0436"],
  ["NEWYORK", "40.7143", "-74.006"]
]

let city = 0;
let weatherDataCache = null;


export function updateCount(backgroundIndex) {
  if (city >= country.length) return;

  city = backgroundIndex;
  weatherDataCache = null;
}



// Fonction pour récupérer les données
async function fetchUsers(url) {
  if (weatherDataCache) {
    return weatherDataCache;
  }

  try {
    // Effectuer la requête GET
    let response = await fetch(url);

    // Vérifier si la réponse est OK (statut HTTP 200-299)
    if (!response.ok) {
      throw new Error(`Erreur HTTP! Statut: ${response.status}`);
    }

    // Parser la réponse en JSON
    let data = await response.json();
    weatherDataCache = data;
  } catch (error) {
    // Gérer les erreurs
    console.error('Erreur lors de la récupération des données:', error);
  }
}



export async function getValueWeather() {

  let latitude = country[city][1].replace(",", ".");
  let longitude = country[city][2].replace(",", ".");

  let url = "https://api.open-meteo.com/v1/forecast?latitude=" + (latitude) + "&longitude=" + (longitude) + "&hourly=temperature_2m,snowfall,surface_pressure,cloud_cover&forecast_days=1";

  let getValue = async () => {
    try {
      // Récupérer les données météorologiques et les mettre en cache si nécessaire
      await fetchUsers(url);
      let dataResponse = weatherDataCache;


      // let time = `${getCurrentDate()}T17:00`; // Formater la date du jour

      let valueWeather = {
        pressure: dataResponse["hourly"]["surface_pressure"][12],
        temperature: dataResponse["hourly"]["temperature_2m"][12],
        snowfall: dataResponse["hourly"]["snowfall"][12],
        nebulosity: (dataResponse["hourly"]["cloud_cover"][12]) / 10
      };

      return valueWeather;
    } catch (error) {
      console.error('Erreur lors de la récupération des données:', error);
    }
  };

  return getValue();
}

