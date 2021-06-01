"use strict";

// définition des variables globales
let lesPages = [];
let indicePage; // indice de la page courante

window.onload = init;

function init() {
    // configuration ckEditor
    let parametre = {
        toolbar: {
            items: [ 'heading', '|', 'bold', 'italic', 'fontBackgroundColor',
                'fontColor',  'fontSize',  'fontFamily', 'link', 'bulletedList', 'numberedList',
                '|', 'indent', 'outdent', '|', 'imageUpload', 'blockQuote',  'insertTable',  'undo',  'redo' ] },
        language: 'fr',
        image: {
            toolbar: [ 'imageTextAlternative', '|', 'imageStyle:alignLeft', 'imageStyle:full', 'imageStyle:alignRight' ],
            styles: ['full', 'alignLeft', 'alignRight']
        },
        table: {
            contentToolbar: ['tableColumn', 'tableRow','mergeTableCells' ]
        },
    };

    parametre =  {

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


    $.getJSON("ajax/getlesdonnees.php", remplirLesDonnees).fail(erreurAjax);
    ClassicEditor.create(contenu, parametre).then( newEditor => { editor = newEditor;});
    liste.onchange = afficher;
    btnModifier.onclick = modifier;
};

function remplirLesDonnees(data) {
    lesPages = data;
    for (let page of lesPages)
        liste.add(new Option(page.nom, page.id));
    afficher();
}

function afficher() {
    indicePage = lesPages.findIndex(element => element.id === liste.value);
    editor.setData(lesPages[indicePage].contenu);
}

// ------------------------------------------
// Modification du contenu d'une page et de son contenu
// -------------------------------------------

function modifier() {
    let contenu = editor.getData();
    // mise à jour de la base de données
    $.ajax({
        url: 'ajax/modifiercontenu.php',
        type: 'POST',
        data: {valeur: contenu, id: liste.value},
        dataType: "json",
        error: erreurAjax,
        success: function () {
            // mise à jour du tableau
            lesPages[indicePage].contenu = contenu;

            // mise à jour de l'interface
            Std.afficherMessage({message : 'Modification enregistrée', type : 'success', position : 'topRight'});
        }
    })
}

