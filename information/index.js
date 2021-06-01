"use strict";

/*

Objectifs :
    modification et suppresion d'une information récente

Tables utilisées :
    information(id, titre, contenu, dateCreation, auteur, idType)
    type(id, nom)

Appels Ajax :
    ajax/getlesinformations.php : chargement des informations sur les deux derniers mois, en fonction du titre
    ajax/modifierdonnees.php : modification d'un information
    ajax/supprimerfichier.php : suppression d'un fichier sur le serveur
    ajax/supprimerinformation.php : suppression d'un information DEFIGNITIVE

Remarque :
    l'information concerné est un zone de liste
    utilisation ckEditor pour le contenu
    Le filtre ce fait sur les 2 derniers mois

*/

// définition des variables globales
let lesInformationsSelectionnee = [];
let indiceInformation;
let leFichier = null; // contient le fichier uploadé pour l'ajout ou le remplacement
// définition des contraintes sur le fichier (utilisé dans les deux fonctions de contrôle)
let tailleMax = 2 * 1024 * 1024;
let lesExtensions = ["pdf"];
let lesTypes = ["application/force-download", "application/pdf"];
let editor;

window.onload = init;

function init() {
    //Chargement des données puis, replissage de la page
    $.getJSON("ajax/getlesinformations.php", remplirLesDonnees).fail(erreurAjax);
    //Chargement du paramètrage de CkEditor
    CKeditor();
    //Lors du changement de selection
    infoSelectionner.onchange = afficher;
    // activation des infobulles de type popover
    $('[data-toggle="popover"]').popover();

    // ------------------------------------------------
    // Gestion de la modification d'un document
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
    // --------------------------------------------------------------------------
    // Gestion des actions à faire lors du clique sur les différents boutons
    // --------------------------------------------------------------------------
    btnSupprimerFichier.onclick = supprimerFichier;
    btnSupprimer.onclick = confirmationSuppresion;
    btnModifier.onclick = controlerTexte;


}

// --------------------------------------------------------------------------
// Gestion des paramètre/de la configuration et affichage de CkEditor
// --------------------------------------------------------------------------

function CKeditor() {
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

//Remplissage des données
function remplirLesDonnees(data) {
    lesInformationsSelectionnee = data.information;
    for (let informations of lesInformationsSelectionnee)
        infoSelectionner.add(new Option(informations.titre, informations.id));
    for (let type of data.type)
        infoConcerne.add(new Option(type.nom, type.id));
    afficher();
}

//Affichage des données
function afficher() {
    // indice de la l'information courante => indiceInformation
    indiceInformation = lesInformationsSelectionnee.findIndex(element => element.id === infoSelectionner.value);
    //Si il n'y a pas eu d'information ses 2 derniers mois, !! On peut le noter d'une autre façon
    if (lesInformationsSelectionnee[indiceInformation] === undefined) {
        pasInformation.innerHTML = "Il n'y as pas eu d'information ses 2 derniers mois. <br> Vous pouvez ajouter une information dans le menu ajouter => information";
    } else {
        selection.style.display = '';
        pasInformation.innerText = '';
        editor.setData(lesInformationsSelectionnee[indiceInformation].contenu);
        titre.value = lesInformationsSelectionnee[indiceInformation].titre
        infoConcerne.value = lesInformationsSelectionnee[indiceInformation].idType;
        ContenueInformation.style.display = '';
        if (lesInformationsSelectionnee[indiceInformation].fichier === 1) {
            cible.innerHTML = 'info' + lesInformationsSelectionnee[indiceInformation].id + '.pdf';
            leFichier = 1;
        } else {
            cible.innerHTML = "Déposez un nouveau fichier <br> ou <br> sélectionnez un fichier en cliquant dans le cadre";
            messageDocument.innerText = '';
            leFichier = null;
        }
    }
}

// ---------------------------------------------------------------------------------------
// Gestion des différents contrôles sur les données avant le lancement des modification
// ----------------------------------------------------------------------------------------

//Controle des données de type "texte"
function controlerTexte() {
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
        modifier();
}


//Contrôle sur le document PDF
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
            cible.innerHTML = "Déposez un nouveau fichier <br> ou <br> sélectionnez un fichier en cliquant dans le cadre";
            leFichier = null;
        }
    }
    return Ctrl.fichierValide(parametre);
}

// -------------------------------------------------------------------------
// Gestion des (ou de la) confirmation(s) avant modification ou suppresion
// -------------------------------------------------------------------------

//Confirmation de la suppresion
function confirmationSuppresion() {
    let n = new Noty({
        text: 'Êtes vous sûr de vouloir supprimer l\'information ?',
        layout: 'center',
        theme: 'sunset',
        modal: true,
        type: 'info',
        animation: {
            open: 'animated lightSpeedIn',
            close: 'animated lightSpeedOut'
        },
        buttons: [
            Noty.button('Oui', 'btn btn-sm btn-success w-50', function () {
                supprimerinformation();
            }),
            Noty.button('Non', 'btn btn-sm btn-danger w-50', function () {
                n.close();
            })
        ]
    }).show();
}

// ----------------------------
// Gestion des modifications
// -----------------------------

//modification de l'information
function modifier() {
    let contenu = editor.getData();
    msg.innerHTML = "";
    //Creation d'un formulaire
    let formulaireInformation = new FormData();
    formulaireInformation.append('id', lesInformationsSelectionnee[indiceInformation].id);
    formulaireInformation.append('titre', titre.value);
    formulaireInformation.append('infoConcerne', infoConcerne.value);
    formulaireInformation.append('contenu', contenu);
    //Si un fichier à été ajouté, alors on le passe dans le formulaire
    if (leFichier !== null) {
        formulaireInformation.append('fichier', leFichier);
    }
    $.ajax({
        url: 'ajax/modifierdonnees.php',
        type: 'POST',
        data: formulaireInformation,
        processData: false,
        contentType: false,
        dataType: "json",
        error: erreurAjax,
        success: function () {
            // information via une notification en haut à droite puis mise à jours des données via un rechargement de la page
            Std.afficherMessage({message: 'Modification effectué', type: 'success', position: 'topRight'});
            // window.location.reload();
            //Mise à jours du titre dans la selection
            infoSelectionner[infoSelectionner.selectedIndex].text = titre.value;
            //Mise à jours du tableau
            lesInformationsSelectionnee[indiceInformation].titre = titre.value;
            lesInformationsSelectionnee[indiceInformation].contenue = editor.getData();
            lesInformationsSelectionnee[indiceInformation].idType = infoConcerne.value;

            if (leFichier !== null)
                lesInformationsSelectionnee[indiceInformation].fichier = 1;
            else {
                lesInformationsSelectionnee[indiceInformation].fichier = 0;
            }
        }
    })
}

// ----------------------------
// Gestion des modifications
// -----------------------------

//Gestion de la suppresion du fichier lors du clique sur le bonton supprimerFichier
function supprimerFichier() {
    //Si un fichier été déjà existant sur le serveur
    if (lesInformationsSelectionnee[indiceInformation].fichier === 1) {
        // messageDocument.innerText = "Le fichier à déjà été supprimer";
        $.ajax({
            url: 'ajax/supprimerfichier.php',
            type: 'POST',
            data: {fichier: cible.innerHTML},
            dataType: "json",
            error: erreurAjax,
            success: function (data) {
                if (data === 2) {
                    messageDocument.innerText = "Il n'y as pas de fichier à suprimer";
                } else {
                    cible.innerHTML = "Déposez le document ici <br> ou sélectionnez un document en cliquant dans le cadre";
                    // mise à jour de l'interface
                    Std.afficherMessage({message: 'Document supprimé', type: 'success', position: 'topRight'});
                }
                leFichier = null;
                //Mise à jours du tableau
                lesInformationsSelectionnee[indiceInformation].fichier = 0;
            }
        })
    }
    //Si un fichier vient d'être mit
    else if (leFichier !== null) {
        leFichier = null
        cible.innerHTML = "Déposez un nouveau fichier <br> ou <br> sélectionnez un fichier en cliquant dans le cadre";
    }
    //Si il n'y avais rien mais n'est pas encore envoyer sur le serveur
    else
        messageDocument.innerText = "Il n'y as pas de fichier à suprimer";
}

//Après confirmation, gestion de la suppresion
function supprimerinformation() {
    let formulaireInformation = new FormData();
    formulaireInformation.append('id', lesInformationsSelectionnee[indiceInformation].id);
    //Si il y avais un fichier, passage dans le formulaire
    if (lesInformationsSelectionnee[indiceInformation].fichier === 1)
        formulaireInformation.append('fichier', cible.innerHTML);
    $.ajax({
        url: 'ajax/supprimerinformation.php',
        type: 'POST',
        data: formulaireInformation,
        processData: false,
        contentType: false,
        dataType:	 "json",
        error: erreurAjax,
        success: function () {
            // information via une notification en haut à droite puis mise à jours des données via un rechargement de la page
            Std.afficherMessage({message: 'Suprresion du fichier effectué', type: 'success', position: 'topRight'});
           // window.location.reload();
           // // mise à jour du tableau (il est synchronisé avec la zone de liste
            lesInformationsSelectionnee.splice(indiceInformation, 1)
           // mise à jour interface
           if (lesInformations.length === 0) {
               // zone.style.visibility = "hidden"
               msg.innerHTML = Std.genererMessage("Il n'a à plus de message adressé aux membres", 'rouge');
           } else {
               infoSelectionner.removeChild(infoSelectionner[infoSelectionner.selectedIndex]);
              afficher();
           }
        }
    })
}
