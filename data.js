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