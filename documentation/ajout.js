"use strict";

window.onload = init;

// définition des variables globales
let lesDocuments;
let tailleMax = 2 * 1024 * 1024;
let lesExtensions = ["pdf"];
let lesTypes = ["application/force-download", "application/pdf"];
let leFichier = null; // contient le fichier uploadé

function init() {

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

// activation des infobulles de type popover
    $('[data-toggle="popover"]').popover();
    $.getJSON("ajax/getlesdocuments.php", remplirLesDonnees).fail(erreurAjax);

}

//permet d'afficher les types de documents dans le volet roulant
function remplirLesDonnees(data) {
    lesDocuments = data.lesDocuments;
    for (const type of data.lesTypes) {
        idType.appendChild(new Option(type.nom , type.id));

    }
}
// ------------------------------------------------
// Fonctions de traitement concernant l'ajout
// ------------------------------------------------

function controleAvantAjout() {
    let titreOk = controlerTitre();
    if (leFichier === null)
        messageDocument.innerText = "Vous devez sélectionner un document ou le faire glisser dans la zone";
    if (titreOk && leFichier !== null)
        ajouter();
    else
        Std.beep();
}
/**
 * Contrôle la valeur du titre et son unicité
 * @returns {boolean}
 */
function controlerTitre() {
    titre.value = titre.value.replace(/\s{2,}/, " ").trim();
    return Ctrl.controler(titre);
}
/**
 * Contrôle le document sélectionné au niveau de son type mime de son extension et de sa taille
 * @returns {boolean}
 */
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
//permet d'ajouter le document dans la base de donnée
function ajouter() {
    msg.innerHTML = "";
    let monFormulaire = new FormData();
    monFormulaire.append('fichier', leFichier);
    monFormulaire.append('titre', titre.value);
    monFormulaire.append('idType', idType.value);
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
            titre.value = '';
            cible.innerHTML = "Déposez le document ici <br> ou sélectionnez un document en cliquant dans le cadre"
        }
    })
}

function remplacer(file) {
    let parametre = {
        file: file,
        lesExtensions: lesExtensions,
        lesTypes: lesTypes,
        taille: tailleMax,
        error: function (reponse) {
            Std.afficherMessage({message: reponse, fermeture: 1})
        }
    }
    if (Ctrl.fichierValide(parametre)) {
        let monFormulaire = new FormData();
        monFormulaire.append('fichier', file);
        monFormulaire.append('id', idDocument);
        $.ajax({
            url: 'ajax/remplacer.php',
            type: 'POST',
            data: monFormulaire,
            processData: false,
            contentType: false,
            dataType: "json",
            error: function (request) {
                Std.afficherMessage({message: request.responseText, fermeture: 1})
            },
            success: function () {
                Std.afficherMessage({message: "Document mise à jour", type: 'success', position: 'topRight'})
                $.getJSON("ajax/getlesdocuments.php", afficher);
            }
        })
    }

}
