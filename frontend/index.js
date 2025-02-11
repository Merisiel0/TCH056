document.addEventListener('DOMContentLoaded', () => {

  if (document.querySelector('#popular-activities')) {
    fetch('http://localhost:8000/api/activities/random')
      .then(response => {
        if (!response.ok) {
          throw new Error('Network response was not ok');
        }
        console.log(response);
        return response.json();
      })
      .then(data => displayPopularActivities(data))
      .catch(error => console.error('Erreur lors du chargement des activités populaires:', error));
  }

  function displayPopularActivities(data) {
    const activitiesContainer = document.querySelector('#popular-activities');

    for (let i = 0; i < data.length; i++) {
      let activityElement = document.createElement("div");
      activityElement.className = 'sport';

      activityElement.innerHTML = `
            <img src="${data[i]['image']}" alt="${data[i]['name']}">
            <div class="text-on-img">
                <p>${data[i]['description']}</p>
            </div>
        `;

      activitiesContainer.appendChild(activityElement);
    }
  }

});