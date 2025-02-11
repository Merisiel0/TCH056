document.addEventListener('DOMContentLoaded', () => {

  if (document.querySelector("#mod-form")) {
      let params = new URLSearchParams(document.location.search);
      if (params.has('id')) {
          fetchActivityDetails(params.get('id'));
      }
  }

  // Auto-remplissage du formulaire (quand on modifie)
  function fetchActivityDetails(id) {
      fetch(`http://localhost:8000/api/activities/${id}`)
          .then(response => response.text())
          .then(data => { return JSON.parse(data) })
          .then(data => populateActivityForm(data))
          .catch(error => console.error('Erreur lors du chargement des détails de l\'activité:', error));
  }

  // --- FORM BOUTON DANS FORMULAIRE ---
  let saveFormBtn = document.querySelector("#save");
  if (saveFormBtn) {
      saveFormBtn.addEventListener("click", () => {
          const params = new URLSearchParams(window.location.search);
          const id = params.get('id');

          const schedule = document.getElementById('form-day').value;
          const regex = /(\D+)\s(\d{2}h\s-\s\d{2}h)/;
          const match = schedule.match(regex);
          let day, hour;
          if (match) {
              day = match[1];
              hour = match[2];
          } else {
              throw new Error("Invalid input format. The expected format is 'Day HH - MM'.");
          }

          const activityData = {
              name: document.getElementById("form-name").value,
              description: document.getElementById("form-description").value,
              image: document.getElementById("form-image").value,
              level_name: document.getElementById("form-level").value,
              coach_name: document.getElementById("form-coach").value,
              schedule_day: day,
              schedule_time: hour,
              location_name: document.getElementById("form-location").value
          };
          console.log(activityData);

          // Si le lien est vide, cela veut dire qu'on AJOUTE une activité, et non modifie.
          // Méthode POST
          if (id === null || isNaN(id)) {
              fetch("http://localhost:8000/api/activities/", {
                  method: "POST",
                  headers: {
                      "Content-Type": "application/json",
                  },
                  body: JSON.stringify(activityData)
              })
                  .then(response => response.json())
                  .then(data => {
                      console.log("Activité ajoutée !", data);
                      alert("Activité ajoutée!");
                      window.location.href = "liste-activite.html"; // Redirection après ajout
                  })
                  .catch(error => console.error("Erreur lors de l'ajout de l'activité:", error));
              return;
          }

          // Fetch Si le lien n'est PAS vide, alors on modifie une activité
          // Méthode PUT
          fetch(`http://localhost:8000/api/activities/${id}`, {
              method: 'PUT',
              headers: {
                  'Content-Type': 'application/json',
              },
              body: JSON.stringify(activityData)
          })
          
            .then(data => {
                console.log("Activité modifiée !", data);
                alert("Activité modifiée!");
                window.location.href = "liste-activite.html"; // Redirection après ajout
              })
              .catch(error => {
                  console.error('Error updating activity:', error);
              });

      });
  }

  // Génère dynamiquement le form
  function populateActivityForm(activity) {
    document.querySelector("#form-name").value = activity[0].name;

    document.querySelector("#form-description").value = activity[0].description;

    document.querySelector("#form-image").value = activity[0].image;

    document.querySelector("#form-level").value = activity[0].level_name;

    document.querySelector("#form-coach").value = activity[0].coach_name;

    let date = activity[0].schedule_day + " " + activity[0].schedule_time;
    document.querySelector("#form-day").value = date;

    document.querySelector("#form-location").value = activity[0].location_name;

}

});