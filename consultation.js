"use strict";

let lesReportages;
window.onload = init;

function init() {
    miseEnPage();
    $.getJSON("ajax/getlesreportages.php", remplirLesDonnees).fail(erreurAjax);
    lesAnnees.onchange = afficher;
}

function remplirLesDonnees(data) {
    lesReportages = data.lesReportages;
    for (const annee of data.lesAnnees)
        lesAnnees.appendChild(new Option(annee.annee, annee.annee));
    afficher()
}

function afficher() {
    lesCartes.innerHTML = "";
    let row = document.createElement('div');
    row.classList.add("row");
    for (const reportage of lesReportages) {
         if (reportage.annee === lesAnnees.value) {
             // Entête de la carte

             let col = document.createElement('div');
             col.classList.add("col-lg-4", "col-md-6");
             let carte = document.createElement('div');
             carte.classList.add('card', 'mt-2');
             let entete = document.createElement('div');
             entete.classList.add('card-header', 'bg-info', 'text-white', 'text-center');

             let a = document.createElement('a');
             a.href = reportage.url;
             a.style.color = 'white';
             a.target = "pdf";
             a.innerText = reportage.titre;
             entete.appendChild(a);
             carte.appendChild(entete);

             let pied = document.createElement('div');
             pied.classList.add('card-footer', 'bg-white', 'text-black',  'font-italic');
             pied.style.fontSize = '0.75rem';
             pied.innerText = "Edition du " + reportage.date
             carte.appendChild(pied);
             lesCartes.appendChild(carte)
             col.appendChild(carte);
             row.appendChild(col);
             lesCartes.appendChild(row);
         }
    }
}
