let activities = [
    {
        id: 1,
        name: "Boxe",
        description: "La boxe est un sport de combat dans lequel deux participants s'affrontent en utilisant uniquement leurs poings.",
        image: "./assets/sports/tile007.jpg",
        level: "Débutant",
        coach: "Jean Dupont",
        schedule_day: "Lundi",
        schedule_time: "18h - 19h",
        location: "Intérieur",
    },
    {
        id: 2,
        name: "Cyclisme",
        description: "Le cyclisme consiste à se déplacer sur un vélo, que ce soit en compétition ou pour le loisir.",
        image: "./assets/sports/tile006.jpg",
        level: "Tous",
        coach: "Marc Lefevre",
        schedule_day: "Mardi",
        schedule_time: "10h - 11h",
        location: "Extérieur",
    },
    {
        id: 3,
        name: "Escrime",
        description: "L'escrime est un sport de combat qui utilise des armes blanches, comme le fleuret, l'épée et le sabre.",
        image: "./assets/sports/tile017.jpg",
        level: "Intermédiaire",
        coach: "Sophie Martin",
        schedule_day: "Jeudi",
        schedule_time: "15h - 16h",
        location: "Intérieur",
    },
    {
        id: 4,
        name: "Football",
        description: "Le football est un sport collectif où deux équipes s'affrontent pour marquer des buts avec un ballon rond.",
        image: "./assets/sports/tile000.jpg",
        level: "Avancé",
        coach: "Pierre Rousseau",
        schedule_day: "Vendredi",
        schedule_time: "17h - 18h",
        location: "Extérieur",
    },
    {
        id: 5,
        name: "Gym",
        description: "Le gym dispose de différents appareils et d'un équipement spécialisé qui permettent de faire des exercices visant à améliorer ou à maintenir sa condition physique.",
        image: "./assets/sports/tile019.jpg",
        level: "Tous",
        coach: "Claire Lefevre",
        schedule_day: "Lundi",
        schedule_time: "9h - 10h",
        location: "Intérieur",
    },
    {
        id: 6,
        name: "Handball",
        description: "Le handball est un sport collectif où deux équipes de sept joueurs essaient de marquer des buts en lançant un ballon dans le but adverse.",
        image: "./assets/sports/tile005.jpg",
        level: "Intermédiaire",
        coach: "Olivier Dufresne",
        schedule_day: "Mardi",
        schedule_time: "14h - 15h",
        location: "Intérieur",
    },
    {
        id: 7,
        name: "Hockey",
        description: "Le hockey sur glace est un sport d'équipe joué sur une patinoire où deux équipes de six joueurs tentent de marquer des buts avec un palet.",
        image: "./assets/sports/tile015.jpg",
        level: "Expert",
        coach: "Alain Petit",
        schedule_day: "Samedi",
        schedule_time: "16h - 17h",
        location: "Extérieur",
    },
    {
        id: 8,
        name: "Mini-golf",
        description: "Le mini-golf est une version réduite du golf, où les joueurs essaient de placer une balle dans un trou à travers divers obstacles.",
        image: "./assets/sports/tile012.jpg",
        level: "Tous",
        coach: "Isabelle Bernard",
        schedule_day: "Dimanche",
        schedule_time: "10h - 11h",
        location: "Extérieur",
    },
    {
        id: 9,
        name: "Natation",
        description: "La natation est un sport qui consiste à se déplacer dans l'eau, en utilisant différentes techniques de nage comme la brasse ou le crawl.",
        image: "./assets/sports/tile002.jpg",
        level: "Débutant",
        coach: "Marie Leclerc",
        schedule_day: "Mercredi",
        schedule_time: "14h - 15h",
        location: "Intérieur",
    },
    {
        id: 10,
        name: "Tennis",
        description: "Le tennis est un sport de raquette où deux ou quatre joueurs s'affrontent en envoyant une balle au-dessus d'un filet.",
        image: "./assets/sports/tile001.jpg",
        level: "Intermédiaire",
        coach: "Jacques Leroy",
        schedule_day: "Vendredi",
        schedule_time: "16h - 17h",
        location: "Extérieur",
    },
    {
        id: 11,
        name: "Tir à l'arc",
        description: "Le tir à l'arc est un sport de précision où les archers tentent de toucher une cible à l'aide d'un arc et de flèches.",
        image: "./assets/sports/tile009.jpg",
        level: "Avancé",
        coach: "Michel Roche",
        schedule_day: "Mercredi",
        schedule_time: "17h - 18h",
        location: "Extérieur",
    },
    {
        id: 12,
        name: "Volleyball",
        description: "Le volleyball est un sport d'équipe où deux équipes de six joueurs essaient de faire passer un ballon par-dessus un filet sans qu'il touche le sol.",
        image: "./assets/sports/tile021.jpg",
        level: "Intermédiaire",
        coach: "Thomas Gauthier",
        schedule_day: "Lundi",
        schedule_time: "11h - 12h",
        location: "Intérieur",
    }
];

// affiche les activités populaires pour la page d'accueil
function displayPopularActivities() {

    // Retourne le sport au complet s'il est trouvé dans activities
    function isInActivities(name) {
        return activities.find(activity => activity.name === name);
    }


    const popularActivities = ['Volleyball', 'Natation', 'Gym', 'Football'];
    const activitiesContainer = document.querySelector('#popular-activities');

    for (let i = 0; i < popularActivities.length; i++) {
        let activityData = isInActivities(popularActivities[i]);
        if (activityData) {
            let activityElement = document.createElement("div");
            activityElement.className = 'sport';

            activityElement.innerHTML = `
                <img src="${activityData.image}" alt="${activityData.name}">
                <div class="text-on-img">
                    <p>${activityData.description}</p>
                </div>
            `;

            activitiesContainer.appendChild(activityElement);
        }
    }
}

// gestion des filtres pour la page des activitÃ©s
function populateFilters() {
    const filtresTable = document.querySelector('.filtre tr');


    // -------- Niveau -----------
    function afficherNiveau() {
        let niveauTh = document.createElement("th");
        filtresTable.append(niveauTh); // ajouter avant le bouton

        let niveauLabel = document.createElement("label");
        niveauLabel.setAttribute("for", "level");
        niveauLabel.innerText = "Niveau :";
        niveauTh.appendChild(niveauLabel);

        let niveauSelect = document.createElement("select");
        niveauSelect.setAttribute("name", "level");
        niveauSelect.setAttribute("id", "level");
        niveauTh.appendChild(niveauSelect);

        const levelsSet = new Set();
        for (const activity of activities) {
            if (activity.level != "Tous") { // Je traite 'Tous' apart
                levelsSet.add(activity.level);
            }
        }

        const levels = ["Tous", ...levelsSet];

        for (let i = 0; i < levels.length; i++) {
            let niveauOption = document.createElement("option");
            niveauOption.value = i;  // Valeur de l'option
            niveauOption.innerText = levels[i];  // Texte de l'option

            niveauSelect.appendChild(niveauOption);
        }
    }



    // ------- place ---------
    function afficherPlace() {
        let placeTh = document.createElement("th");
        filtresTable.append(placeTh);

        let placeLabel = document.createElement("label");
        placeLabel.setAttribute("for", "place");
        placeLabel.innerText = "Lieu :";
        placeTh.appendChild(placeLabel);

        let placeSelect = document.createElement("select");
        placeSelect.setAttribute("name", "place");
        placeSelect.setAttribute("id", "location");
        placeTh.appendChild(placeSelect);

        const placesSet = new Set();
        for (const activity of activities) {
            if (activity.location != "Tous") { // Je traite 'Tous' apart
                placesSet.add(activity.location);
            }
        }

        const places = ["Tous", ...placesSet];

        for (let i = 0; i < places.length; i++) {
            let placeOption = document.createElement("option");
            placeOption.value = i;
            placeOption.innerText = places[i];

            placeSelect.appendChild(placeOption);
        }
    }
        // -------- Coach ---------
    function afficherCoach() {
        let coachTh = document.createElement("th");
        filtresTable.append(coachTh);

        let coachLabel = document.createElement("label");
        coachLabel.setAttribute("for", "coach");
        coachLabel.innerText = "Coach :";
        coachTh.appendChild(coachLabel);

        let coachSelect = document.createElement("select");
        coachSelect.setAttribute("name", "coach");
        coachSelect.setAttribute("id", "coach");
        coachTh.appendChild(coachSelect);

        const coachesSet = new Set();
        for (const activity of activities) {
            if (activity.coach != "Tous") { // Je traite 'Tous' apart
                coachesSet.add(activity.coach);
            }
        }

        const coaches = ["Tous", ...coachesSet];

        for (let i = 0; i < coaches.length; i++) {
            let coachOption = document.createElement("option");
            coachOption.value = i;
            coachOption.innerText = coaches[i];

            coachSelect.appendChild(coachOption);
        }
    }

    // -------- Jour ---------
    function afficherJour() {
        let jourTh = document.createElement("th");
        filtresTable.append(jourTh);

        let jourLabel = document.createElement("label");
        jourLabel.setAttribute("for", "jour");
        jourLabel.innerText = "Jour :";
        jourTh.appendChild(jourLabel);

        let jourSelect = document.createElement("select");
        jourSelect.setAttribute("name", "jour");
        jourSelect.setAttribute("id", "day");
        jourTh.appendChild(jourSelect);

        const jours = ["Tous", "Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi", "Dimanche"];

        for (let i = 0; i < jours.length; i++) {
            let jourOption = document.createElement("option");
            jourOption.value = i;
            jourOption.innerText = jours[i];

            jourSelect.appendChild(jourOption);
        }
    }
    // -------- Bouton appliquer ----------
    function boutonAppliquer() {
        let appliquer = document.createElement("button");
        appliquer.setAttribute('type', 'button');
        appliquer.innerText = 'Appliquer';
        filtresTable.appendChild(appliquer);

        // Ajouter action listener
        appliquer.addEventListener('click', () => {

            // S'assurer que le html est vide
            const activitiesContainer = document.getElementById('sports-liste');
            activitiesContainer.innerHTML = "";

            // DÃ©finir les filtres

            let filters = {
                level: null,
                location: null,
                coach: null,
                day: null,
            };

            // Filtre du niveau
            if (document.getElementById("level").value === "0") {
                filters.level = "Tous";
            } else {
                filters.level = document.getElementById("level").options[document.getElementById("level").selectedIndex].text;
            }

            // Filtre de la place
            if (document.getElementById("location").value === "0") {
                filters.location = "Tous";
            } else {
                filters.location = document.getElementById("location").options[document.getElementById("location").selectedIndex].text;
            }

            // Filtre du coach
            if (document.getElementById("coach").value === "0") {
                filters.coach = "Tous";
            } else {
                filters.coach = document.getElementById("coach").options[document.getElementById("coach").selectedIndex].text;
            }

            // Filtre du jour
            if (document.getElementById("day").value === "0") {
                filters.day = "Tous";
            } else {
                filters.day = document.getElementById("day").options[document.getElementById("day").selectedIndex].text;
            }


            displayFilteredActivities(filters);
        });
    }

    // Tout afficher
    afficherNiveau();
    afficherPlace();
    afficherCoach();
    afficherJour();
    boutonAppliquer();


}

function isValidActivity(i, filters){
  return (activities[i].level === filters.level || filters.level === "Tous")
  && (activities[i].location === filters.location || filters.location === "Tous")
  && (activities[i].coach === filters.coach || filters.coach === "Tous")
  && (activities[i].schedule_day === filters.day || filters.day === "Tous")
}

function createActivity(i){
  let activityElement = document.createElement("div");
  activityElement.className = activities[i].name.toLowerCase();

  activityElement.innerHTML = `
      <article>
          <img src="${activities[i].image}" alt="${activities[i].name}" width="150"><br>
          <h3>${activities[i].name}</h3>
          <button class="modifier">Modifier</Button>
          <p>${activities[i].description}</p><br>
          <p>Horaire : ${activities[i].schedule_day}</p><br>
          <p>Niveau : ${activities[i].level}</p><br>
          <p>Entraîneur : ${activities[i].coach}</p><br>
          <p>Lieu : ${activities[i].location}</p><br>
      </article>
  `;

  let btn = activityElement.querySelector('.modifier');
  btn.addEventListener("click", () => {
      window.location.href = "formulaire.html?id=" + activities[i].id;
  });

  return activityElement;
}

// affiche toutes les activitÃ©s filtres pour la page des activitÃ©s
function displayFilteredActivities(filters) {
    const activitiesContainer = document.getElementById('sports-liste');

    let counter = 0;
    for (let i = 0; i < activities.length; i++) {
        if (isValidActivity(i, filters)) {

            let activityElement = createActivity(i);

            activitiesContainer.append(activityElement);
            
            counter++;
        }
    }

    if (counter <= 1) {
        let footerElement = document.querySelector("footer");
        footerElement.style.position = "absolute";
        footerElement.style.bottom = 0;
        footerElement.style.width = "100%";
    } else {
        let footerElement = document.querySelector("footer");
        footerElement.style.position = '';
        footerElement.style.bottom = '';
        footerElement.style.width = '';
    }
}

function populateForm(id) {
    let activity = activities.find((element) => element.id == id);

    document.querySelector("#form-name").value = activity.name;
    
    document.querySelector("#form-description").value = activity.description;

    document.querySelector("#form-image").value = activity.image;

    document.querySelector("#form-level").value = activity.level.toString();

    document.querySelector("#form-coach").value = activity.coach;

    let date = activity.schedule_day + " " + activity.schedule_time;
    document.querySelector("#form-day").value = date;

    document.querySelector("#form-location").value = activity.location;

}