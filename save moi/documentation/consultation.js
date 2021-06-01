"use strict";


let lesDocuments; //id, titre, idtype, date

window.onload = init;

function init() {
    miseEnPage();
    const queryString = window.location.search;

    $.getJSON("ajax/getlesdocuments.php" + queryString, remplirLesDonnees).fail(erreurAjax);
}
//fonction permettant d'appeler les documents
function remplirLesDonnees(data) {
    lesDocuments = data.lesDocuments;
    for (const documents of lesDocuments){
        afficherDocument(documents)
    }
}

//fonction qui permet d'afficher les documents dans le tableau
function afficherDocument(documents) {
    let tr = document.createElement('tr');
    let td = document.createElement('td');

    td.innerText = documents.titre;
    tr.appendChild(td);
    td = document.createElement('td');

    td.innerText = documents.date;
    tr.appendChild(td);
    td = document.createElement('td');
    let linkDownload = document.createElement('a');
    linkDownload.href = "../document/doc" + documents.id + ".pdf";
    linkDownload.download = "doc" + documents.id + ".pdf";
    td.appendChild(linkDownload);

    let img2 = new Image();
    img2.src = "../img/pdf.png";
    img2.style.marginTop = "5px";
    img2.style.marginLeft = "10px";
    linkDownload.appendChild(img2);

    tr.appendChild(td);
    lesLignes.appendChild(tr)
}