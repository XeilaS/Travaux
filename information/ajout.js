"use strict";

/*
Objectifs :
    Saisie d'une nouvelle information

Tables utilisées :
    type(id, nom)
    information(titre, contenu, auteur, idType, dateCreation)

Appels Ajax :
    ajax/getlesdonnees.php : chargement du type d'information dans la base de données MySQL
    ajax/ajouterdonnees.php : Ajout d'une information avec le page non obligatoire d'un fichier


Remarque :
    l'information concerné est un zone de liste
    utilisation ckEditor pour le contenu
    le fichier est facultatif
    le fichier n'est mit en ligne que lors du clique sur le bouton ajouter,
        et est automatiquement renomé en info'id'.pdf dans le répertoire document


*/

window.onload = init;

// définition des variables globales
let leFichier = null; // contient le fichier uploadé pour l'ajout ou le remplacement
// définition des contraintes sur le fichier (utilisé dans les deux fonctions de contrôle)
let tailleMax = 2 * 1024 * 1024;
let lesExtensions = ["pdf"];
let lesTypes = ["application/force-download", "application/pdf"];
//Ajout d'un Let Editor suite à l'utilisation du use strict qui oblige la déclaration de chaque variabke
let editor;

function init() {
    //Lancement de ckEditor
    ckEditor();
    //Récupération des données pour la Zone de Liste puis, lanement de l'afichage des données
    $.getJSON("ajax/getlesdonnees.php", remplirLesDonnees).fail(erreurAjax);
    // activation des infobulles de type popover
    $('[data-toggle="popover"]').popover();

    // ------------------------------------------------
    // Gestion de l'ajout d'un document
    // ------------------------------------------------
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

    //Action lors du clique sur les différents boutons
    btnAjouter.onclick = controle;
    btnSupprimerFichier.onclick = supprimerFichier;
}


// --------------------------------------------------------------------------
// Gestion des paramètres de la configuration et affichage de CkEditor
// --------------------------------------------------------------------------

function ckEditor() {
    let parametre = {

        toolbar: {
            items: [
                '|',
                'fontColor',
                'fontSize',
                'fontFamily',
                'bold',
                'italic',
                'link',
                'bulletedList',
                'numberedList',
                '|',
                'indent',
                'outdent',
                '|',
                'imageUpload',
                'blockQuote',
                'insertTable',
                'undo',
                'redo',
                'horizontalLine'
            ]
        },
        language: 'fr',
        image: {
            toolbar: [
                'imageTextAlternative',
                'imageStyle:full',
                'imageStyle:side'
            ]
        },
        table: {
            contentToolbar: [
                'tableColumn',
                'tableRow',
                'mergeTableCells'
            ]
        },
        licenseKey: '',

    };
    ClassicEditor.create(contenu, parametre).then(newEditor => {
        editor = newEditor;
    });
}

// --------------------------
// Gestion des données
// --------------------------

//Affichage des données
function remplirLesDonnees(data) {
    for (let lesInformationConcernes of data)
        infoConcerne.add(new Option(lesInformationConcernes.nom, lesInformationConcernes.id));
}


// ---------------------------------------------------------------------------------------
// Gestion des différents contrôles sur les données avant le lancement de l'ajout
// ----------------------------------------------------------------------------------------
//Controle des données de type "texte"
function controle() {
    let contenu = editor.getData();
    let titreVide;
    let contenuVide;
    if (titre.value.length === 0) {
        msgTitre.innerText = "Champ requis";
        titreVide = false;
    } else {
        msgTitre.innerText = "";
        titreVide = true;
    }
    if (contenu.length === 0) {
        msgContenu.innerText = "Champ requis";
        contenuVide = false;
    } else {
        msgContenu.innerText = "";
        contenuVide = true;
    }
    if (titreVide && contenuVide)
        ajouter();
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
// ----------------------------
// Gestion de l'ajout
// -----------------------------

function ajouter() {
    let contenu = editor.getData();
    msg.innerHTML = "";
    let formulaireInformation = new FormData();
    formulaireInformation.append('titre', titre.value);
    formulaireInformation.append('infoConcerne', infoConcerne.value);
    formulaireInformation.append('contenu', contenu);
    if (leFichier !== null) {
        formulaireInformation.append('fichier', leFichier);
    }
    $.ajax({
        url: 'ajax/ajouterdonnees.php',
        type: 'POST',
        data: formulaireInformation,
        processData: false,
        contentType: false,
        dataType: "json",
        error: erreurAjax,
        success: function () {
            titre.value = '';
            editor.setData('');
            cible.innerHTML = "Déposez le document ici <br> ou sélectionnez un document en cliquant dans le cadre";
            //IL faut également mettre le document à null, car en cas de 2 ajout, il y auras un problème
            if(leFichier !== null) { leFichier = null }
            // mise à jour de l'interface
            Std.afficherMessage({message: 'Information ajouté', type: 'success', position: 'topRight'});
        }
    })
}

// -----------------------------------------
// Gestion de la suppresion d'un document
// -----------------------------------------

function supprimerFichier() {
    if(leFichier !== null) {
        leFichier = null
        cible.innerHTML = "Déposez un nouveau fichier <br> ou <br> sélectionnez un fichier en cliquant dans le cadre"
    } else
        messageDocument.innerText = "Il n'y as pas de fichier à suprimer";
}
