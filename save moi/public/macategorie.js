"use strict";

let dateJour = new Date();

window.onload = init;

function init() {
    btnCalculer.onclick = controleAvantEnvoi;
    dateCourse.value = dateJour.toFormatMySQL();
}

function controleAvantEnvoi() {
    let dateNaissanceOk = Ctrl.controler(dateNaissance);
    let dateCourseOk = Ctrl.controler(dateCourse);
    let ecartOk = false
    if (dateNaissanceOk && dateCourseOk)
        ecartOk =  controlerEcart();
    if (ecartOk) envoyer();
}

function controlerEcart() {
    let anneeD = dateNaissance.value.substr(0, 4);
    let anneeF = dateCourse.value.substr(0, 4);
    let ecart = anneeF - anneeD;
    if (ecart < 10 || ecart > 90) {
        Std.afficherMessage({message : "les dates ne sont pas cohérentes pour calculer la catégorie"})
        return false
    } else {
        return true;
    }
}


function envoyer() {
    reponse.innerHTML = ""
    $.ajax({
        url: 'ajax/getcategorie.php',
        type: 'POST',
        data: {dateNaissance : dateNaissance.value, dateCourse : dateCourse.value},
        dataType: "json",
        error: erreurAjax,
        success: function (data) {
          msg.innerHTML = "";
          reponse.innerHTML = "Votre catégorie : " + data.nom + ' (<b>' + data.id + "</b>)<br>Vous aurez ce jour là <b>" + data.age + "</b> ans";
        }
    })
}
