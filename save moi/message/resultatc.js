function erreurAjax(request) {
    msg.innerHTML = Std.genererMessage(request.responseText, 'rouge');
}

"use strict";

window.onload = init;

function init() {
    $.getJSON("ajax/getlescourses.php", remplirLesDonnees).fail(erreurAjax);
    idCourse.onchange = getlesresultats;
}

function remplirLesDonnees(data) {
    for (const course of data)
        idCourse.appendChild(new Option(course.Libelle, course.id));
    getlesresultats();
}

function getlesresultats() {
    $.getJSON("ajax/getlesresultatsc.php", remplirLesDonnees).fail(erreurAjax);
    $.ajax({
        url: 'ajax/getlesresultatsc.php',
        type: 'POST',
        data: {idCourse: idCourse.value},
        dataType: "json",
        error: erreurAjax,
        success: afficher
    })

}

function afficher(data) {
    msg.innerHTML = '';
    lesLignes.innerHTML = '';
    for (const resultat of data) {

        afficherResultat(resultat);
    }
}


function afficherResultat(resultat) {
    let tr = document.createElement('tr');
    let td = document.createElement('td');
    td.innerText = resultat.place;
    tr.appendChild(td)
    td = document.createElement('td');
    td.innerText = resultat.temps;
    tr.appendChild(td);
    td = document.createElement('td');
    td.innerText = resultat.club;
    tr.appendChild(td);
    td = document.createElement('td');
    td.innerText = resultat.nom + ' ' + resultat.prenom;
    tr.appendChild(td);
    td = document.createElement('td');
    td.classList.add('text-center');
    td.innerText = resultat.categorie + ' ' + resultat.placeCategorie;
    tr.appendChild(td);
    lesLignes.appendChild(tr)
}