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

    // Fonction qui affiche un message succès après avoir modifié activité
    function showSuccessMessage(type) {
        // Enlever message existant si existe
        let vieuxMessage = document.getElementById("success");
        let vieuxMessage2 = document.getElementById("fail");

        if (vieuxMessage) {
            vieuxMessage.remove();
        }

        if (vieuxMessage2) {
            vieuxMessage2.remove()
        }

        message = document.createElement('div')
        message.id = "success"

        switch (type) {
            case "ajouter":
                message.innerText = "Activité ajoutée avec succès";
                break;

            case "modifier":
                message.innerText = "Activité modifiée avec succès";
                break;
        }

        // Dernière option
        let lieuOption = document.getElementById("form-location");
        lieuOption.parentNode.appendChild(message);

    }


    function showFailMessage(type) {
        // Enlever message existant si existe
        let vieuxMessage = document.getElementById("success");
        let vieuxMessage2 = document.getElementById("fail");

        if (vieuxMessage) {
            vieuxMessage.remove();
        }

        if (vieuxMessage2) {
            vieuxMessage2.remove()
        }

        message = document.createElement('div')
        message.id = "fail"

        switch (type) {
            case "champ":
                message.innerText = "Champs manquants";
                break;

            case "heure":
                message.innerText = "Veuillez formater l'horaire ainsi: Jour XXh - XXh.";
                break;

            case "image":
                message.innerText = "Veuillez fournir un URL valide pour l'image.";
                break;

        }

        // Dernière option
        let lieuOption = document.getElementById("form-location");
        lieuOption.parentNode.appendChild(message);
    }

    function isValidUrlOrPath(string) {
        try {
            // Try parsing as a full URL
            new URL(string);
            return true;
        } catch (err) {
            // If it's not a full URL, check if it's a valid relative path
            return string.startsWith('/') || string.startsWith('./') || string.startsWith('../');
        }
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
                showFailMessage("heure");
                throw new Error("Format invalide. Le format est: 'Jour HH - HH'.");
            }

            const imgUrl = document.getElementById("form-image").value;
            if(!isValidUrlOrPath(imgUrl)){
                showFailMessage("image");
                throw new Error("URL invalide. Les images doivent êtres représentées par un URL.");
            }

            const activityData = {
                name: document.getElementById("form-name").value,
                description: document.getElementById("form-description").value,
                image: imgUrl,
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
                    .then(response => {
                        if (!response.ok) {
                            return response.json().then(errData => {
                                showFailMessage("champ"); // Message erreur où il manque un champ
                                throw new Error(errData.error); // Raise une erreur (console)
                            });
                        }
                        return response.json();
                    })
                    .then(data => {
                        console.log(data);
                        showSuccessMessage("ajouter");

                        setTimeout(() => {
                            window.location.href = "liste-activite.html";
                        }, 3000); // Redirection 3s après ajout

                    })
                    .catch(error => {
                        console.error("Erreur lors de l'ajout de l'activité:", error);
                    });

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

                .then(response => {
                    if (!response.ok) {
                        return response.json().then(errData => {
                            showFailMessage("champ"); // Message erreur où il manque un champ
                            throw new Error(errData.error); // Raise une erreur (console)
                        });
                    }
                    return response.json();
                })

                .then(data => {
                    console.log(data);
                    showSuccessMessage("modifier");

                    setTimeout(() => {
                        window.location.href = "liste-activite.html";
                    }, 3000); // Redirection 3s après ajout

                })
                .catch(error => {
                    console.error('Erreur en modifiant activité:', error);
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