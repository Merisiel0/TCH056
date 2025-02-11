document.addEventListener('DOMContentLoaded', () => {

    let btnArray = document.querySelectorAll(".btn-vers-main");
    for (let i = 0; i < btnArray.length; i++) {
        btnArray[i].addEventListener("click", () => {
            window.location.href = 'index.html'
        });
    }

    btnArray = document.querySelectorAll(".btn-vers-liste");
    for (let i = 0; i < btnArray.length; i++) {
        btnArray[i].addEventListener("click", () => {

            if (document.getElementById("save")) {
                event.preventDefault();
            }

            window.location.href = 'liste-activite.html'
        });
    }

    btnArray = document.querySelectorAll(".btn-vers-formulaire");
    for (let i = 0; i < btnArray.length; i++) {
        btnArray[i].addEventListener("click", () => {
            window.location.href = 'formulaire.html'
        });
    }

    let logo = document.querySelector(".logo");
    logo.style.cursor = "pointer";
    logo.addEventListener("click", () => {
        window.location.href = 'index.html'
    });

});