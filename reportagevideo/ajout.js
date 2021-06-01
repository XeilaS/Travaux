"use strict";

window.onload = init

function init() {
    $.getJSON("ajax/getlescourses.php", remplirLesDonnees).fail(erreurAjax);
    btnAjouter.onclick = controlerAvantAjout;
}

function remplirLesDonnees(data) {
    for (const element of data) {
        idCourse.add(new Option(element.libelle, element.id));
    }
}

function controlerAvantAjout() {
    let erreur = false;
    url.nextElementSibling.innerText = url.validationMessage
    if(url.checkValidity()) {
        if(url.value.length !== 41 || !url.startsWith("https://www.youtube.com/embed/")) {
            url.nextElementSibling.innerText  = "Code d'intégration non valide"
            erreur = true;
        }
    } else {
        erreur = true;
    }
    if (!erreur) ajouter();
}

function ajouter() {
    $.ajax({
        url: 'ajax/ajouter.php',
        type: 'POST',
        data: {url : url.value, idCourse : idCourse.value, niveau : niveau.value},
        dataType: "json",
        error: reponse => { msg.innerHTML = Std.genererMessage(reponse.responseText, 'rouge')},
        success: () => { Std.afficherMessage({message : 'reportage ajouté', type :'success'})}
    });
}