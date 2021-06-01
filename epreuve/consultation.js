"use strict";

window.onload = init;

function init() {
    miseEnPage();
    $.getJSON("ajax/getlesepreuves.php", afficher).fail(erreurAjax);
}

// Cette fonction nous permet de créer et d'afficher des éléments sous un format 'card'
function afficher(data) {
    let row = document.createElement('div');
    row.classList.add("row");
    for (const epreuve of data) {

        // Entête de la carte

        let col = document.createElement('div');
        col.classList.add("col-12");
        let carte = document.createElement('div');
        carte.classList.add('card');
        let entete = document.createElement('div');
        entete.classList.add('card-header', 'bg-info', 'text-white', 'text-center');
        entete.innerText = epreuve.nom;
        carte.appendChild(entete);

        // Corps de la carte

        let corps = document.createElement('div');
        corps.classList.add("card-body", "text-left");
        let img = document.createElement('img');
        // Ici ce n'est pas 'innerText' car la description contient des informations en HTML !
        corps.innerHTML = epreuve.description
        carte.appendChild(corps);

        // Pied de la carte

        let pied = document.createElement('div');
        pied.classList.add('card-footer', 'bg-danger', 'text-white', 'text-center');
        pied.innerText = epreuve.date
        carte.appendChild(pied);
        lesCartes.appendChild(carte)
        col.appendChild(carte);
        row.appendChild(col);
        lesCartes.appendChild(row);
    }
}




