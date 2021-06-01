"use strict";

let lesDocuments; //id, titre, idtype, date
let id;
window.onload = init;


function init() {
    $.getJSON("ajax/getlesdocuments.php", remplirLesDonnees).fail(erreurAjax);
    idType.onchange = afficher;
}
//permet d'ajouter les données
function remplirLesDonnees(data) {
    lesDocuments = data.lesDocuments;
    for (const type of data.lesTypes) {
        idType.appendChild(new Option(type.nom , type.id));
    }
    afficher();
}
//permet d'afficher les données dans le volet
function afficher() {
    lesLignes.innerHTML = '';
    for (const documents of lesDocuments){
        let valeur = idType.value;
        if( documents.idType === valeur){
            afficherDocument(documents)
        }
    }
}
//permet d'afficher les documents dans le tableau
function afficherDocument(documents) {
    let id = documents.id;
    let tr = document.createElement('tr');
    tr.id = id;
    let td = document.createElement('td');
    let linkDownload = document.createElement('a');
    linkDownload.href = "../document/doc" + id + ".pdf";
    linkDownload.download = "doc" + id + ".pdf";
    td.appendChild(linkDownload);
//permet d'afficher une image de téléchargement pdf
    let img2 = new Image();
    img2.src = "../img/pdf.png";
    img2.style.marginTop = "5px";
    img2.style.marginLeft = "10px";
    linkDownload.appendChild(img2);
//permet d'afficher une image de suppression
    let img = new Image();
    img.src = "../img/supprimer.png";
    img.style.marginTop = "5px";
    img.style.marginLeft = "10px";
    img.onclick = function () {
        confirmerSuppression(id)
    };
    td.appendChild(img);
    tr.appendChild(td);

    td = document.createElement('td');
    td.innerText = documents.titre;
    tr.appendChild(td);

    td = document.createElement('td');
    td.innerText = documents.date;
    tr.appendChild(td);

    lesLignes.appendChild(tr)
}

//fonction permettant d'afficher un message pour la suppression
function confirmerSuppression(id) {
    let n = new Noty({
        text: 'Voulez-vous supprimer le document? ',
        layout: 'center',
        theme: 'sunset',
        modal: true,
        type: 'info',
        animation: {
            open: 'animated lightSpeedIn',
            close: 'animated lightSpeedOut'
        },
        buttons: [
            Noty.button('Oui', 'btn btn-sm btn-success marge', function () {
               supprimerDocument(id)
                n.close();
            }),
            Noty.button('Non', 'btn btn-sm btn-danger', function () {
                n.close();
            })
        ]
    }).show();
}
//fonction permettant la suppression
function supprimerDocument(id){
    $.ajax({
        url: 'ajax/supprimer.php',
        type: 'POST',
        data: {
            id : id
        },
        dataType: "json",
        error: erreurAjax,
        success: function () {
            let ligne = document.getElementById(id);
            ligne.parentNode.removeChild(ligne);
            Std.afficherMessage({message: "Document supprimé", type: 'success', position: 'topRight'});
        }
    })
}

