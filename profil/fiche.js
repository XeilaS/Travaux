"use strict";

window.onload = init;

// déclaration des variables globales
let email;
let fixe;
let mobile;
let bin;
let nomPrenom;


function init() {
    $.getJSON("ajax/getdonnees.php", afficher).fail(erreurAjax);

    // attribution des variables
    email = document.getElementById('email');
    fixe = document.getElementById('fixe');
    mobile = document.getElementById('mobile');
    bin = document.getElementById('bin');

    // gestionnaire d'evenements

    // Evenements sur le champ email
    // Si le champ est incorrect, le focus est gardé sur le champ et l'icone de iconeDeControle est répétée
    email.onkeyup = function (){
        iconeDeControle(email, emailCheck, email.checkValidity(), false)
    };

    email.onfocus = function(){
        iconeDeControle(email, emailCheck, email.checkValidity(), false)
    };

    email.onkeypress = function (e) {
        if (e.key === "Enter") {
            fixe.focus();
        }
    };

    email.onblur = function () {
        email.style.backgroundColor = 'white';
        email.style.color = 'black';
        if (email.checkValidity() === true){
            miseAJour();
        }
        else{
            iconeDeControle(null, emailCheck, false, true);
            email.focus();
        }
    };


    // Evenements sur le champ fixe
    // Si le champ est incorrect, le focus est gardé sur le champ et l'icone de iconeDeControle est répétée
    fixe.onkeyup = function (){
        iconeDeControle(fixe, fixeCheck, fixe.checkValidity(), false)
    };

    fixe.onfocus = function (){
        iconeDeControle(fixe, fixeCheck, fixe.checkValidity(), false)
    };

    fixe.onkeypress = function (e) {
        if (e.key === "Enter") {
            mobile.focus();
        }
        if (!/[0-9]/.test(e.key)) return false
    };

    fixe.onblur = function () {
        fixe.style.backgroundColor = 'white';
        fixe.style.color = 'black';
        if (fixe.checkValidity() === true){
            miseAJour();
        }
        else{
            iconeDeControle(null, fixeCheck, false, true);
            fixe.focus();
        }
    };

    // Evenements sur le champ mobile
    // Si le champ est incorrect, le focus est gardé sur le champ et l'icone de iconeDeControle est répétée
    mobile.onkeyup = function (){
        iconeDeControle(mobile, mobileCheck, mobile.checkValidity(), false)
    };

    mobile.onfocus = function (){
        iconeDeControle(mobile, mobileCheck, mobile.checkValidity(), false)
    };

    mobile.onkeypress = function (e) {
        if (e.key === "Enter") {
            email.focus();
        }
        if (!/[0-9]/.test(e.key)) return false
    };

    mobile.onblur = function () {
        mobile.style.backgroundColor = 'white';
        mobile.style.color = 'black';
        if (mobile.checkValidity() === true){
            miseAJour();
        }
        else{
            iconeDeControle(null, mobileCheck, false, true);
            mobile.focus();
        }
    };

    // Evenement btnAttestation
    btnAttestation.onclick = function() {
        $.ajax({
            url: "ajax/genererattestation.php",
            type: 'post',
            dataType: "json",
            error: erreurAjax,
            success: function () {
                window.open('document/attestation' + nomPrenom + '.pdf', 'pdf');
            }
        });
    };

    // Evenements cases à cochées
    autMail.onclick = miseAJour;
    abtInformation.onclick = miseAJour;


    // Evenement et Effets de la poubelle (suppression image de profil)
    bin.onclick = function () {
        confirmationNoty('Êtes vous sûr de vouloir supprimer votre image de profil ?');
    };

    bin.onmouseover = function (){
        bin.style.transform = "scale(1.3)";
    };

    bin.onmouseleave = function (){
        bin.style.transform = "scale(1)";
    };


    // pour le glisser déposer d'une photo
    cible.onclick = function () { photo.click(); };
    cible.ondragover = function (e) { e.preventDefault(); };
    cible.ondrop = function (e) {
        e.preventDefault();
        modifierPhoto(e.dataTransfer.files[0]);
    };

    // pour la sélection à partir d'un champ file nommé ici photo
    photo.onchange = function () { if (this.files.length > 0) modifierPhoto(this.files[0]); };


    // popover
    $('[data-toggle="popover"]').popover({trigger: 'hover'});

    // tooltip
    $('[data-toggle="tooltip"]').tooltip();
}


// ------------------- Affichage des données ------------------- //

function afficher(membre) {
    // Récuperation du nom et du prénom pour alimenter la variable nomPrenom
    nomPrenom = membre.nom.toUpperCase() + membre.prenom.toUpperCase();

    let Prenom = $('<p>', {class: "ml-1 font-weight-bold"}).text(membre.prenom);
    $('#prenom').append(Prenom);

    let nom = $('<p>', {class: "ml-1 font-weight-bold"}).text(membre.nom);
    $('#nom').append(nom);

    let dateNaissance = $('<p>', {class: "ml-1 font-weight-bold"}).text(membre.dateNaissance);
    $('#dateNaissance').append(dateNaissance);	

    email.value = membre.email;

    // Si le fixe n'existe pas, la valeur du champ est le placeholder = Non renseigné.
    if (membre.fixe !== null) {
        fixe.value = membre.fixe;
    }
    // Si le mobile n'existe pas, la valeur du champ est le placeholder = Non renseigné.
    if (membre.mobile !== null) {
        mobile.value = membre.mobile;
    }

    // Cases abonnements et autorisations
    autMail.checked = membre.autMail == 1;
    abtInformation.checked = membre.abtInformation == 1;


    // Si la photo existe on alimente la div qui a pour id img
    // On fait apparaitre la poubelle avec animation
    // Sinon on retire la poubelle
    if (membre.photo) {
        let img = document.createElement('img');
        img.src = "photo/" + membre.photo;
        img.alt = "";
        img.style.maxWidth = '150px';
        img.style.maxHeight = '150px';
        cible.innerHTML = '';
        cible.appendChild(img);
        let icon = document.createElement('div');
        transition.begin(icon, [
            ["transform", "scale(0)", "scale(1)", "1s", "ease-in-out"],
            ["color", "white", "black", "1s", "linear"],
        ]);
        icon.innerHTML = "<i class=\"fa fa-trash-o fa-lg\" aria-hidden=\"true\"></i>";
        bin.innerHTML = "";
        bin.appendChild(icon);
    } else {
        bin.innerHTML = ""
    }
}

// ------------------- Gestion de la mise à jour des données ------------------- //



function miseAJour() {
    $.ajax({
        url: 'ajax/modifier.php',
        type: 'POST',
        data: {
            email: email.value,
            fixe: fixe.value,
            mobile: mobile.value,
            autMail : autMail.checked ? 1 : 0,
            abtInformation : abtInformation.checked ? 1 : 0
        },
        dataType: "json",
        error: erreurAjax,
        success: function (data) {
            if (data == 1)
                Std.afficherMessage({ message : "Les données ont bien été modifié", type : 'success', position : 'topRight' });
        }
    })
}


// ------------------- Gestion de la photo ------------------- //


function modifierPhoto(file) {
    let parametre = {
        file: file,
        lesExtensions: ["jpg", "png", "gif"],
        lesTypes: ["image/pjpeg", "image/jpeg", "x-png", "image/gif", "image/png"],
        taille : 300 * 1024,
        error : function(reponse) {
            Std.afficherMessage({ message : reponse, fermeture : 1});
        }
    };
    if (Ctrl.fichierValide(parametre)) {
        // vérification des dimensions
        let largeurMax = 150;
        let hauteurMax = 150;
        let img = new Image();
        img.src = window.URL.createObjectURL(file);
        // il faut attendre que l'image soit chargée pour effectuer les contrôles
        img.onload = function () {
            window.URL.revokeObjectURL(this.src);
            if (img.width > largeurMax || img.height > hauteurMax) {
                Std.afficherMessage({ message : "Dimensions non respectées", fermeture : 1});
            }
            else {
                let monFormulaire = new FormData();
                monFormulaire.append('fichier', file);
                $.ajax({
                    url: 'ajax/modifierphoto.php',
                    type: 'POST',
                    data: monFormulaire,
                    processData: false,
                    contentType: false,
                    dataType: "json",
                    error: erreurAjax,
                    success: function () {
                        cible.innerHTML = "";
                        cible.appendChild(img);
                        let trash = document.createElement('div');
                        trash.innerHTML = "<i class=\"fa fa-trash-o fa-lg\" aria-hidden=\"true\"></i>";
                        transition.begin(bin,[
                            ["transform", "scale(0)", "scale(1)", "1s", "ease-in-out"],
                            ["color", "white", "red", "1s", "linear"],
                        ]);
                        bin.innerText = "";
                        bin.appendChild(trash);
                    }
                })
            }
        };
        img.onerror = function () {
            Std.afficherMessage({ message : "Ce n'est pas une photo.", fermeture : 1} );
        }
    }
}


function effacerPhoto() {
    $.ajax({
        url: 'ajax/supprimerphoto.php',
        dataType: "json",
        success: function (data) {
            if (data == 1){
                Std.afficherMessage({ message : "Suppression effectuée", type : 'success', position : 'topRight' });
                cible.innerHTML = "Déposez la photo ici <br> ou <br> sélectionnez une photo en cliquant dans le cadre";
                transition.begin(bin,[
                    ["transform", "scale(1)", "scale(0)", "1s", "ease-in-out"],
                    ["color", "red", "white", "1s", "linear"],
                ])
            }
        },
        error: erreurAjax
    })
}



// ------------------- Autres fonctions ------------------- //

function confirmationNoty(txt) {
    let n = new Noty({
        text: txt,
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
                effacerPhoto();
                n.close();
            }),
            Noty.button('Non', 'btn btn-sm btn-danger', function () {
                n.close();
            })
        ]
    }).show();
}