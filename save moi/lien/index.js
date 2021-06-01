"use strict";

let laPhoto // contient le nouveau logo controlé
let idLien

window.onload = init;

/**
 * fonction d'initialisation,
 * cette derniére vas renvoyer a la fonction afficher pour afficher les cartes de la pages.
 * ou, si un probléme est rencontrée, vers la fonction erreurAjax.
 *
 */
function init () {
    //récupére les données dans la table lien
    $.getJSON("ajax/getlesliens.php", afficher).fail(erreurAjax);

    photo.onchange = function () {
        if (this.files.length > 0) modifierPhoto(this.files[0]);
    };


}

//stocke les données de la table lien dans des cartes bootstrap
function afficher(data) {
    let row = document.createElement('div');
    row.classList.add("row");
    for (const lien of data) {
        const id = lien.id;
        let col = document.createElement('td');
        col.classList.add("col-sm-6", "col-12");
        /**
         * création de la carte
         */
        let carte = document.createElement('div');
        carte.classList.add('card');
        /**
         * entéte
         */
        let entete = document.createElement('div');
        entete.classList.add('card-header');
        entete.classList.add('bg-dark');
        entete.classList.add('text-white');
        entete.classList.add('text-center');
        entete.style.minHeight = '75px';
        /**
         * input
         */
        let input = document.createElement("input");
        input.type = "text";
        input.value = lien.nom;
        input.dataset.old = lien.nom;
        input.classList.add('form-control');
        input.pattern="^[0-9A-Za-zÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ' ()._-]+$";
        input.maxlength = 50;
        input.onkeypress = function (e) {
            if (e.key === "Enter") modifier('nom',this, id,1);
            else if (!/^[A-Za-z0-9ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ' ()._-]$/.test(e.key)) return false;

        };
        input.onblur = function () { modifier('nom',this, id,1);};


        entete.appendChild(input);
        carte.appendChild(entete);
        /**
         * corps
         */

        let corps = document.createElement('div');
        corps.classList.add("card-body");
        corps.classList.add("text-center");

        let img = new Image();
        img.id = 'effacer' + id;
        img.src = "../img/effacer.png";
        img.style.marginTop = '30px';
        img.style.marginLeft = '20px';
        img.title = "Enlever la photo"
        img.alt = "Enlever la photo"
        img.classList.add('float-right')
        img.onclick = function () {
            effacerPhoto(id);
        };
        corps.appendChild(img);
        if (lien.logo == 'defaut.png' || lien.logo == 'nontrouve.png' ) {
            img.style.visibility = "hidden";
        }


        let div = document.createElement('div');
        div.id = 'photo' + id
        div.classList.add("text-center", "m-3");
       //  div.style.height = "140px";

        div.ondblclick = function () {
            idLien = id;
            photo.click();
        }
        div.ondragover = function (e) {
            e.preventDefault();
        }
        div.ondrop = function (e) {
            idLien = id;
            e.preventDefault();
            modifierPhoto(e.dataTransfer.files[0]);
        };
        /**
         * logo
         */
        img =  document.createElement('img');
        img.src = 'logo/' + lien.logo;
        img.style.width = "150px";
        // img.style.height = "150px";
        img.alt = "";
        img.id = 'logo' + id;
        div.appendChild(img);



        corps.appendChild(div);
        carte.appendChild(corps);
        /**
         * pieds de pages
         */
        let pied = document.createElement('form');
        let pied2 = document.createElement('div');
        pied2.classList.add('form-group')
        pied2.classList.add('card-footer');
        pied2.classList.add('text-muted');
        pied2.classList.add('text-center');

        let textarea = document.createElement("textarea");

        textarea.value = lien.description;
        textarea.dataset.old = lien.description;
        textarea.classList.add('form-control');
        textarea.maxlength = 500;
        textarea.onkeypress = function (hi) {
            if (hi.key === "tab") modifier('description',this, id,0);
        };
        textarea.onblur = function () { modifier('description',this, id,0);};
        pied2.appendChild(textarea);


        textarea = document.createElement("textarea");

        textarea.value = lien.url;
        textarea.dataset.old = lien.url;
        textarea.classList.add('form-control');
        textarea.maxlength = 150;
        textarea.onkeypress = function (hi) {
            if (hi.key === "tab") modifier('url',this, id,0);
        };
        textarea.onchange = function () { modifier('url',this, id,0);};

        pied2.appendChild(textarea);
        let input2 = document.createElement('input');
        input2= document.createElement("input");
        input2.type = "number";
        input2.value = lien.rang;
        input2.dataset.old = lien.rang;
        input2.classList.add('form-control');
        input2.maxlength = 30;
        input2.onkeypress = function (e) {
            if (e.key === "Enter") modifier('rang',this, id,0);

        };
        input2.onblur = function () { modifier('rang',this, id,0);};

        pied2.appendChild(input2);

        pied.appendChild(pied2);

        carte.appendChild(pied);


        /**
         * liens
         */

        let liens = document.createElement('button');
        liens.classList.add('btn');
        liens.classList.add('btn-danger');
        liens.classList.add('btn-lg');
        liens.classList.add('btn-block');
        liens.onclick = function() { confirmerSuppression(lien.id)};
        liens.innerText = "supprimer";
        carte.appendChild(liens);


        col.appendChild(carte);
        row.appendChild(col);
        lesCartes.appendChild(row);

        // lesCartes.appendChild(carte);
    }
}




// ------------------------------------------------------
// Traitement concernant la suppression
// ------------------------------------------------------


function confirmerSuppression(id) {
    let n = new Noty({
        text: 'Confirmer la demande de suppression ',
        layout: 'center', theme: 'sunset', modal: true, type: 'info',
        animation: {
            open: 'animated lightSpeedIn',
            close: 'animated lightSpeedOut'
        },
        buttons: [
            Noty.button('Oui', 'btn btn-sm btn-success marge ', function () {
                supprimer(id);
                n.close();
            }),
            Noty.button('Non', 'btn btn-sm btn-danger', function () { n.close(); })
        ]
    }).show();
}

function supprimer(id) {
    $.ajax({
        url: 'ajax/supprimer.php',
        type: 'POST',
        data: {id: id},
        dataType: "json",
        success: function () {
            Std.afficherMessage( {message : "Suppression réalisée", type : 'success'});

            lesCartes.innerHTML = "";
            $.getJSON("ajax/getlesliens.php", afficher).fail(erreurAjax);

        },
        error: function (request) { msg.innerHTML = Std.genererMessage(request.responseText, 'rouge'); }
    })
}









// ------------------------------------------------------
// Traitement concernant la modification
// ------------------------------------------------------

function modifier(colonne, champ, id, unicite) {
    $.ajax({
        url: 'ajax/modifier.php',
        type: 'POST',
        data: {colonne : colonne, valeur : champ.value, id: id, unicite : unicite},
        dataType: "json",
        success: function () { champ.dataset.old = champ.value; },
        error: function (request) {
            Std.afficherMessage({
                message: request.responseText,
                fermeture: 1,
                surFermeture: function () { champ.value = champ.dataset.old; }
            })
        }
    })
}




// ------------------------------------------------------
// Traitement concernant la gestion des photo
// ------------------------------------------------------


function modifierPhoto(file) {
    let parametre = {
        file: file,
        lesExtensions: ["jpg", "png", "gif"],
        lesTypes: ["image/pjpeg", "image/jpeg", "x-png", "image/gif", "image/png"],
        taille: 300 * 1024,
        error: function (reponse) {
            Std.afficherMessage({message: reponse, fermeture: 1});
        }
    }
    if (Ctrl.fichierValide(parametre)) {
        // vérification des dimensions
        let largeurMax = 150;
        let hauteurMax = 150;

        let img = new Image();
        img.src = window.URL.createObjectURL(file);
        img.id = 'logo' + idLien;
        // il faut attendre que l'image soit chargée pour effectuer les contrôles
        img.onload = function () {
            window.URL.revokeObjectURL(this.src);
            if (img.width > largeurMax && img.height > hauteurMax) {
                Std.afficherMessage({message: "Dimensions non respectées", fermeture: 1});
            } else {
                let monFormulaire = new FormData();
                monFormulaire.append('fichier', file);
                monFormulaire.append('id', idLien);
                $.ajax({
                    url: 'ajax/modifierlogo.php',
                    type: 'POST',
                    data: monFormulaire,
                    processData: false,
                    contentType: false,
                    dataType: "json",
                    error: erreurAjax,
                    success: function () {
                        let cible = document.getElementById('photo' + idLien);
                        cible.innerHTML = "";
                        cible.appendChild(img);
                        img.onload = null;
                        // ajouter la gomme
                        document.getElementById('effacer' + idLien).style.visibility = "visible";
                        idLien = "";
                    }
                })
            }
        }
        img.onerror = function () {
            Std.afficherMessage({message: "Ce n'est pas une photo.", fermeture: 1});
        }
    }
}


// ------------------------------------------------
// fonction de traitement concernant l'effacement du champ photo
// ------------------------------------------------

function effacerPhoto(id) {
    $.ajax({
        url: 'ajax/viderlogo.php',
        type: 'POST',
        data: {id: id},
        dataType: "json",
        success: function () {
            document.getElementById('effacer' + id).style.visibility = 'hidden';
            document.getElementById('logo' + id).src = "logo/defaut.png";
            // $.getJSON("ajax/getlesetudiants.php", afficher)
        },
        error: function (request) {
            Std.afficherMessage({
                message: request.responseText,
                fermeture: 1,
            })
        }
    })
}