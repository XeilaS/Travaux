"use strict";

window.onload = init;


// définition des variables globales

let tailleMax = 2 * 1024 * 1024;
let lesExtensions = ["pdf"];
let lesTypes = ["application/force-download", "application/pdf"];
let leFichier; // contient le fichier uploadé
let idDocument; // contient l'identifiant du document dont le fichier doit être remplacé
let dateJ = new Date();
let max = dateJ.toFormatMySQL();



function init() {
    // traitement associé au bouton 'Ajouter'
    btnAjouter.onclick = controleAvantAjout;

    cible.onclick = function () {
        fichier.click();
    }
    cible.ondragover = function (e) {
        e.preventDefault();
    };
    cible.ondrop = function (e) {
        e.preventDefault();
        controlerDocument(e.dataTransfer.files[0]);
    }
    fichier.onchange = function () {
        if (this.files.length > 0) controlerDocument(this.files[0]);
    };
    nbParticipant.onchange = controlerNbParticipant;
    nbParticipant.onkeypress = function (e) { if (!/^[0-9]$/.test(e.key)) return false;};
    dateEpreuve.onblur = controlerDateEpreuve;
    dateEpreuve.max = max;
    dateEpreuve.value = max;

}


function controleAvantAjout() {
    let nbParticipantOk = controlerNbParticipant();
    let dateEpreuveOk = controlerDateEpreuve();
    if (leFichier === null) messageDocument.innerText = "Vous devez sélectionner un document ou le faire glisser dans la zone";
    if (leFichier !== null && nbParticipantOk && dateEpreuveOk ) ajouter();

}

function controlerNbParticipant() {
    return Ctrl.controler(nbParticipant);
}

function controlerDateEpreuve() {
    return Ctrl.controler(dateEpreuve);
}


function controlerDocument(file) {
    messageDocument.innerText = "";
    let parametre = {
        file: file,
        lesExtensions: lesExtensions,
        lesTypes: lesTypes,
        taille: tailleMax,
        success: function () {
            cible.innerText = file.name;
            messageDocument.innerText = '';
            leFichier = file;
        },
        error: function (reponse) {
            messageDocument.innerText = reponse;
            cible.innerHTML = "Déposez le document ici <br> ou sélectionnez un document en cliquant dans le cadre";
            leFichier = null;
        }
    }
    return Ctrl.fichierValide(parametre);
}

function ajouter() {
    msg.innerHTML = "";
    let monFormulaire = new FormData();
    monFormulaire.append('fichier', leFichier);
    monFormulaire.append('dateEpreuve', dateEpreuve.value);
    monFormulaire.append('nomEpreuve', nomEpreuve.value);
    monFormulaire.append('distance', distance.value);
    monFormulaire.append('nbParticipant', nbParticipant.value);
    $.ajax({
        url: 'ajax/ajouter.php',
        type: 'POST',
        data: monFormulaire,
        processData: false,
        contentType: false,
        dataType: "json",
        error: erreurAjax,
        success: function () {
            Std.afficherMessage({message: "Document ajouté", type: 'success', position: 'topRight'});
            date.value = '';
            nom.value = '';
            distance.value = '';
            nbParticipant.value = '';
            cible.innerHTML = "Déposez le document ici <br> ou sélectionnez un document en cliquant dans le cadre"
        }
    })
}


