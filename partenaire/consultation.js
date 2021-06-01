"use strict";

function erreurAjax(request) {
    msg.innerHTML = Std.genererMessage(request.responseText, 'rouge');
}

window.onload = init;

function init () {
    $.getJSON("ajax/getleslogos.php", afficher).fail(erreurAjax);

}




function afficher(data) {
    let row = document.createElement('div');
    row.classList.add("row");
    for (const partenaire of data) {
        let col = document.createElement('div');
        col.classList.add("col-xl-3", "col-lg-4", "col-md-4", "col-sm-6", "col-12");
        let carte = document.createElement('div');
        carte.classList.add('card');
        let entete = document.createElement('div');
        entete.classList.add('card-header', 'bg-dark', 'text-white', 'text-center');
        entete.style.minHeight = '75px';
        entete.innerText = partenaire.nom;
        carte.appendChild(entete);
        let corps = document.createElement('div');
        corps.classList.add("card-body", "text-center");
        let img = document.createElement('img');
        img.src = 'logo/' + partenaire.logo;
        img.style.width = "150px";
        img.style.height = "150px";
        img.alt = "";
        corps.appendChild(img);
        carte.appendChild(corps);
        col.appendChild(carte);
        row.appendChild(col);
        lesCartes.appendChild(row);
    }
}





