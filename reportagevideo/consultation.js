"use strict";

window.onload = init;

function init() {
    // miseEnPage();
    $.getJSON("ajax/getlesreportages.php", remplirLesDonnees).fail(erreurAjax);

    lesReportages.onchange = afficher;

}

function remplirLesDonnees(data) {
    for (const element of data) {
        lesReportages.add(new Option(element.libelle, element.url));
    }
    afficher();
}


function afficher() {
    leReportage.src = lesReportages.value;
}

