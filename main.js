document.addEventListener('DOMContentLoaded', () => {


    if (document.querySelector("#mod-form")) {
        let params = new URLSearchParams(document.location.search);
        if (params.has('id')) {
            let id = params.get('id');
            populateForm(id);
        }
    }

    // Gestion des boutons de navigation
    let btnArray = document.querySelectorAll(".btn-vers-main");
    for (let i = 0; i < btnArray.length; i++) {
        btnArray[i].addEventListener("click", () => {
            console.log("-> main");
            window.location.href = "index.php";
        });
    }

    btnArray = document.querySelectorAll(".btn-vers-liste");
    for (let i = 0; i < btnArray.length; i++) {
        btnArray[i].addEventListener("click", () => {
            console.log("-> liste");
            if (document.getElementById("save")) {
                event.preventDefault();
            }
            window.location.href = "liste-activite.php";
        });
    }

    btnArray = document.querySelectorAll(".btn-vers-formulaire");
    for (let i = 0; i < btnArray.length; i++) {
        btnArray[i].addEventListener("click", () => {
            window.location.href = "formulaire.php";
        });
    }

    btnArray = document.querySelectorAll(".btn-vers-login");
    for (let i = 0; i < btnArray.length; i++) {
        btnArray[i].addEventListener("click", () => {
            window.location.href = "login.php";
        });
    }

    btnArray = document.querySelectorAll(".btn-vers-register");
    for (let i = 0; i < btnArray.length; i++) {
        btnArray[i].addEventListener("click", () => {
            window.location.href = "register.php";
        });
    }

    let logo = document.querySelector(".logo");
    logo.style.cursor = "pointer";
    logo.addEventListener("click", () => {
        window.location.href = "index.php";
    });
});