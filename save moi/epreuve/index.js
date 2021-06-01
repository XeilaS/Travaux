"use strict";

let lesEpreuves;
let id;  // mémorisant l'id de l'enregistrement en cours de modification
let editor;
// variables globales utilisées pour l'intervalle sur les dates des épreuves
let dateJ = new Date();
let max = dateJ.getFullYear() + 1 + "-12-31";
let min = dateJ.toFormatMySQL();


window.onload = init

function init() {

    date.min = min;
    date.max = max;

    $.getJSON("ajax/getlesepreuves.php", remplirListeEpreuves).fail(erreurAjax);
    idEpreuve.onchange = function () {
        getLesEpreuves(this.value);
    }

    //
    // Mise en place de CKEditor ici
    //
    let parametre = {
        toolbar: {
            items: [
                'fontColor', // couleur de police
                'fontSize', // Taille de la police
                'fontFamily', // police de caractères
                'bold', // Mise en gras
                'italic', // mise en italique
                'link', // lien
                'bulletedList', // liste à puces
                'numberedList', // liste numérotée
                '|',
                'indent', // augmenter le retrai
                'outdent', // diminuer le retrait
                '|',
                'imageUpload', // importation d'un image en base 64
                'blockQuote', // citation
                'insertTable', // insérer un tableau
                'undo', // annuler
                'redo', // restaurer
                'horizontalLine' // ajouter un trait horizontal
            ]
        },
        language: 'fr',
        image: {toolbar: ['imageTextAlternative', 'imageStyle:full', 'imageStyle:side']},
        table: {contentToolbar: ['tableColumn', 'tableRow', 'mergeTableCells']},
    };
    ClassicEditor.create(description, parametre).then(newEditor => {
        editor = newEditor;
    });

    idEpreuve.onchange = afficher;

    // Le bouton 'btnModifier'
    btnModifier.onclick = controleAvantModification;

    // le bouton 'btnSupprimer'
    btnSupprimer.onclick = confirmerSuppression;
}

//
// Remplire la liste "Sélectionner le lien à modifier ou à supprimer :" avec les noms des épreuves de la base de donnée
//
function remplirListeEpreuves(data) {
    lesEpreuves = data;
    for (const epreuve of data)
        idEpreuve.appendChild(new Option(epreuve.nom, epreuve.id));
    afficher();
}

function afficher(){
    let i = lesEpreuves.findIndex(x => x.id === idEpreuve.value);
    id = lesEpreuves[i].id;
    date.value = lesEpreuves[i].dateMySQL;
    date.classList.remove('erreur');
    date.nextElementSibling.innerText = '';
    nom.value = lesEpreuves[i].nom;
    nom.classList.remove('erreur');
    nom.nextElementSibling.innerText = '';
    editor.setData(lesEpreuves[i].description);
    messageDescription.innerText = '';
}

//
// Controle du nom
//
function controlerNom() {
    nom.value = nom.value.replace(/\s{2,}/, " ").trim();
    return Ctrl.controler(nom);
}
//
// Controle de la date
//
function controlerDate() {
    return Ctrl.controler(date);
}
//
// Controle de la description
//
function controlerDescription() {
    description.value = editor.getData();
    if (description.value.length < 30) {
        messageDescription.innerText = "Vous devez décrire cette épreuve de façon plus détaillée";
        return false;
    } else {
        messageDescription.innerText = "";
        return true;
    }
}

//
// Gestion de la suppression
//
function confirmerSuppression() {
    let n = new Noty({
        text: 'Confirmer la demande de suppression ',
        layout: 'center', theme: 'sunset', modal: true, type: 'info',
        animation: {
            open: 'animated lightSpeedIn',
            close: 'animated lightSpeedOut'
        },
        buttons: [
            Noty.button('Oui', 'btn btn-sm btn-success marge ', function () {
                supprimer();
                n.close();
            }),
            Noty.button('Non', 'btn btn-sm btn-danger', function () { n.close(); })
        ]
    }).show();
}

function supprimer() {
    $.ajax({
        url: 'ajax/supprimer.php',
        type: 'POST',
        data: {id: id},
        dataType: "json",
        success: function () {
            Std.afficherMessage( {message : "Suppression réalisée", type : 'success'});
            // Suppression dans le tableau
            // Je cherche la ligne qui avait cette index
            let i = lesEpreuves.findIndex(element => element.id === id);
            // Je supprime la ligne voulu
            lesEpreuves.splice(i, 1);
            // Supprimer l'option sélectionné dans la zone de liste
            idEpreuve.removeChild(idEpreuve[idEpreuve.selectedIndex]);
            // Mettre à jour les informations dans les zones de saisie
            afficher();
        },
        error: function (request) { msg.innerHTML = Std.genererMessage(request.responseText, 'rouge'); }
    })
}

//
// Controle avant d'ajouter les éléments
//
function controleAvantModification() {
    let nomOk = controlerNom();
    let descriptionOk = controlerDescription();
    let dateOk = controlerDate();
    if (nomOk && descriptionOk && dateOk) modifier();
}

function modifier() {
    $.ajax({
        url: 'ajax/modifier.php',
        type: 'POST',
        data: {
            id: id,
            nom: nom.value,
            description: editor.getData(),
            date: date.value,
        },
        dataType: "json",
        error: function(request) {
            Std.afficherMessage({
                message: request.responseText,
                fermeture : 1,
                surFermeture : function() {
                    description.value = description.dataset.old;
                }
            });
        },
        success: function () {
            Std.afficherMessage({
                message: "Modification prise en compte",
                type: 'success',
                position: 'topRight'
            })

            // mise à jour des valeurs actuelles
            nom.dataset.old = nom.value;
            description.dataset.olg = nom.value;
        }
    })
}