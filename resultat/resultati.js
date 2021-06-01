"use strict";

window.onload = init;

function init() {
    nomR.onkeypress = function(e) { if (!/^[A-Za-z ]$/.test(e.key)) return false;};
    nomR.oninput = function() { if(this.value.length >= 3) getLesCoureurs() }
}

function getLesCoureurs() {
    msg.innerHTML = "";
    lesLignes.innerHTML = '';
    $.ajax({
        url: "ajax/getlesresultatsi.php",
        type: 'post',
        data: {valeur: nomR.value},
        dataType: "json",
        success: afficher,
        error: function (request) {
            msg.innerHTML = Std.genererMessage( request.responseText, "rouge");
        }
    });

}


function afficher(data) {
    for (const resultat of data) {
        let tr = document.createElement('tr');
        let td = document.createElement('td');
        td.innerText = resultat.date;
        tr.appendChild(td);
        td = document.createElement('td');
        td.innerText = resultat.distance;
        tr.appendChild(td);
        td = document.createElement('td');
        td.innerText = resultat.temps;
        tr.appendChild(td);
        td = document.createElement('td');
        td.classList.add('text-center');
        td.innerText = resultat.place;
        tr.appendChild(td);
        td = document.createElement('td');
        td.classList.add('text-center');
        td.innerText = resultat.club;
        tr.appendChild(td);
        td = document.createElement('td');
        td.classList.add('text-center');
        td.innerText = resultat.categorie + ' ' + resultat.placeCategorie;
        tr.appendChild(td);
        lesLignes.appendChild(tr)
        tableau.style.display = 'block';
    }
}


