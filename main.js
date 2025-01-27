document.addEventListener('DOMContentLoaded', () => {
    // Vérifiez que la page est loadée

    if (document.querySelector('#popular-activities')) {
        // Page d'accueil
        displayPopularActivities();
    }

    if (document.querySelector(".filtre")) {
        populateFilters();
    }

    if (document.querySelector('#sports-liste')) {
        let filtres = {};

        let sel = document.getElementById("level");
        filtres.level = sel.options[sel.selectedIndex].text;

        sel = document.getElementById("location");
        filtres.location = sel.options[sel.selectedIndex].text;

        sel = document.getElementById("coach");
        filtres.coach = sel.options[sel.selectedIndex].text;

        sel = document.getElementById("day");
        filtres.day = sel.options[sel.selectedIndex].text;


        displayFilteredActivities(filtres);
    }

    if (document.querySelector("#mod-form")) {
        let params = new URLSearchParams(document.location.search);
        if(params.has('id')){
            let id = params.get('id');
            populateForm(id);
        }
    }

    let btnArray = document.querySelectorAll(".btn-vers-main");
    for (let i = 0; i < btnArray.length; i++) {
        btnArray[i].addEventListener("click", () => {
            console.log("-> main");
            window.location.href = "main.html";
        });
    }

    btnArray = document.querySelectorAll(".btn-vers-liste");
    for (let i = 0; i < btnArray.length; i++) {
        btnArray[i].addEventListener("click", () => {
            console.log("-> liste");

            if (document.getElementById("save")) {
                event.preventDefault();
            }

            window.location.href = "liste-activite.html";
        });
    }

    btnArray = document.querySelectorAll(".btn-vers-formulaire");
    for (let i = 0; i < btnArray.length; i++) {
        btnArray[i].addEventListener("click", () => {
        window.location.href = "formulaire.html";
        });
    }

    let logo = document.querySelector(".logo");
    logo.style.cursor = "pointer";
    logo.addEventListener("click", () => {
        window.location.href = "main.html";
    });
});