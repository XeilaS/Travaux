function erreurAjax(request) {
    msg.innerHTML = Std.genererMessage(request.responseText, 'rouge');
}

"use strict";


window.onload = init

function init() {

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


    // chargement des données
    $.getJSON("ajax/getlestypes.php", remplirLesDonnees).fail(erreurAjax);
    // traitement associé au bouton 'Ajouter'
    btnAjouter.onclick = ajouter;
}


function remplirLesDonnees(data) {
    for (const type of data) {
        domaine.add(new Option(type.nom, type.id));
    }
}

//Gestion du document ajouté
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

// Controle du nom, description et date
function controlerNom() {
    nom.value = nom.value.replace(/\s{2,}/, " ").trim();
    return Ctrl.controlerChamp(nom);
}


function controleAvantAjout() {
    let nomOk = controlerNom();
    if (nomOk) ajouter();
}


function ajouter() {
    let logo = editor.getData();
    msg.innerHTML = "";
    let formulaireInformation = new FormData();

    formulaireInformation.append('nom', nom.value);
    formulaireInformation.append('domaine', domaine.value);
    formulaireInformation.append('logo', fichier.value);
    if (leFichier !== null) {
        formulaireInformation.append('fichier', leFichier);
    }
    $.ajax({
        url: 'ajax/ajouter.php',
        type: 'POST',
        data: formulaireInformation,
        processData: false,
        contentType: false,
        dataType: "json",
        error: erreurAjax,
        success: function () {
            nom.value = '';
            editor.setData('');
            cible.innerHTML = "Déposez le document ici <br> ou sélectionnez un document en cliquant dans le cadre";
            // mise à jour de l'interface
            Std.afficherMessage({message: 'Information ajouté', type: 'success', position: 'topRight'});
        }
    })
}

function supprimerFichier() {
    leFichier = null
    cible.innerHTML = "Déposez un nouveau fichier <br> ou <br> sélectionnez un fichier en cliquant dans le cadre"
}

