document.addEventListener('DOMContentLoaded', () => {

  let addActivityButton = document.getElementById("ajouter");
  if (addActivityButton) {
    addActivityButton.addEventListener("click", () => {
      window.location.href = "formulaire.html"; // Redirige vers le formulaire
    });

  }

  // Préparation des filtres
  if (document.querySelector(".filtre")) {
    populateFilters().then(() => {
      initializeFilters();
    }).catch(error => {
      console.error("Erreur lors de l'initialization des filtres", error);
    });
  }

  function initializeFilters() {
    // Ajoute un écouteur d'événement pour chaque filtre
    document.querySelectorAll(".filtre select").forEach(select => {
      select.addEventListener("change", updateURLParams);
    });

    //Bouton Appliquer
    document.getElementById("appliquer").addEventListener("click", () => {
      let filters = getFiltersFromURL();
      fetchFilteredActivities(filters);
    });

    // Charger les filtres au chargement de la page (s'il y en a dans l'URL)
    let filters = getFiltersFromURL();
    fetchFilteredActivities(filters);
  }

  function updateURLParams() {
    let filters = getSelectedFilters();
    let queryParams = new URLSearchParams(filters).toString();
    history.replaceState(null, "", `?${queryParams}`);
  }

  // Récupère les options des filtres
  function getSelectedFilters() {
    return {
      level: document.getElementById("level").value,
      location: document.getElementById("location").value,
      coach: document.getElementById("coach").value,
      day: document.getElementById("day").value
    };
  }

  // Récupère les filtres à partir de l'URL
  function getFiltersFromURL() {
    let params = new URLSearchParams(window.location.search);
    return {
      level: params.get("level") || "",
      location: params.get("location") || "",
      coach: params.get("coach") || "",
      day: params.get("day") || ""
    };
  }

  function fetchFilteredActivities(filters) {
    let query = new URLSearchParams(filters).toString();
    fetch(`http://localhost:8000/api/activities/filter?${query}`)
      .then(response => response.json())
      .then(data => displayFilteredActivities(data))
      .catch(error => console.error('Erreur lors du chargement des activités filtrées:', error));
  }

  // Contacte la DB, récupère toutes les options possibles
  // que l'on peut choisir en filtres
  function populateFilters() {
    return new Promise((resolve, reject) => {
      fetch('http://localhost:8000/api/activities/all')
        .then(response => {
          if (!response.ok) {
            throw new Error("Erreur lors du chargement des filtres");
          }
          return response.json();
        })
        .then(data => {
          const filtresTable = document.querySelector('.filtre tr');
          if (!filtresTable) {
            console.error("Filtres non trouvés");
            return;
          }

          const niveaux = new Set(["Tous"]);
          const lieux = new Set(["Tous"]);
          const coaches = new Set(["Tous"]);

          data.forEach(activity => {
            if (activity.level) niveaux.add(activity.level);
            if (activity.location) lieux.add(activity.location);
            if (activity.coach) coaches.add(activity.coach);
          });

          // Création filtres
          createFilter("level", "Niveau", Array.from(niveaux), filtresTable);
          createFilter("location", "Lieu", Array.from(lieux), filtresTable);
          createFilter("coach", "Coach", Array.from(coaches), filtresTable);
          createFilter("day", "Jour", ["Tous", "Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi", "Dimanche"], filtresTable);


          if (!document.getElementById("appliquer")) {
            let applyTh = document.createElement("th");
            filtresTable.appendChild(applyTh);
            addApplyButton(applyTh);
          }

          resolve(); // Indique que populateFilters() est terminé, pour passer à initialize filters
        })
        .catch(error => {
          console.error("Erreur lors du chargement des filtres:", error);
        });
    });
  }

  // Fonction qui créer et place dynamiquement les filtres
  function createFilter(id, labelText, options, parent) {
    let th = document.createElement("th");
    parent.appendChild(th);

    let label = document.createElement("label");
    label.setAttribute("for", id);
    label.innerText = labelText + " :";
    th.appendChild(label);

    let select = document.createElement("select");
    select.setAttribute("name", id);
    select.setAttribute("id", id);
    th.appendChild(select);

    options.forEach(optionText => {
      let option = document.createElement("option");
      option.value = optionText;
      option.innerText = optionText;
      select.appendChild(option);
    });
  }

  // Fonction pour ajouter le bouton "Appliquer"
  function addApplyButton(parent) {
    let appliquer = document.createElement("button");
    appliquer.setAttribute('type', 'button');
    appliquer.id = "appliquer";
    appliquer.innerText = 'Appliquer';
    parent.appendChild(appliquer);
  }


  // Fonction qui affiche dynamiquement les activités filtrées
  function displayFilteredActivities(activities) {

    const container = document.getElementById("sports-liste");
    container.innerHTML = "";

    let counter = 0;
    activities.forEach(activity => {
      const div = document.createElement("div");

      let className = activity.name.toLowerCase().replace(/\s+/g, '-').replace(/[^a-z0-9-]/g, '');
      div.classList.add(className);

      div.innerHTML = `
              <article>
                  <img src="${activity.image}" alt="${activity.name}" width="150"><br>
                  <h3>${activity.name}</h3>
                  <button class="modifier">Modifier</button>
                  <p>${activity.description}</p><br>
                  <p>Horaire : ${activity.schedule_day}</p><br>
                  <p>Niveau : ${activity.level}</p><br>
                  <p>Entraîneur : ${activity.coach}</p><br>
                  <p>Lieu : ${activity.location}</p><br>
              </article>
          `;

      let btn = div.querySelector('.modifier');
      btn.addEventListener("click", () => {
        window.location.href = "formulaire.html?id=" + activity.id;
      });

      container.append(div);
      counter++;
    });

    // Gestion du footer en fonction du nombre d'activités affichées
    let footerElement = document.querySelector("footer");
    if (counter <= 1) {
      footerElement.style.position = "absolute";
      footerElement.style.bottom = 0;
      footerElement.style.width = "100%";
    } else {
      footerElement.style.position = '';
      footerElement.style.bottom = '';
      footerElement.style.width = '';
    }
  }

});