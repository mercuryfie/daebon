const API_KEY = 'a7a8d602d83ea75568ff18ac7d879325';
const CITY = 'Seoul';

async function getWeather() {
  const response = await fetch(`http://api.openweathermap.org/data/2.5/weather?q=${CITY}&appid=${API_KEY}&units=metric`);
  const data = await response.json();
  
  document.getElementById('city').textContent = data.name;
  document.getElementById('temperature').textContent = `${data.main.temp}°C`;
  document.getElementById('description').textContent = data.weather[0].description;
}

getWeather();
