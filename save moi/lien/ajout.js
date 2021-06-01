"use strict";

window.onload = init;
let leLogo = null//Variable contenant l'objet file

function init() {

    $('[data-toggle="popover"]').popover();

    btnAjouter.onclick = function () {
        if (nom.value == "" || url.value == "" || rang.value == "") {
            messageErreur.innerHTML = "paramétre manquant";
            messageErreur.style.color = "red";
        } else {
            ajouter();
        }
    };

    // pour l'upload
    cible.onclick = function () {
        fichier.click();
    }

    cible.ondragover = function (e) {
        e.preventDefault();
    };
    cible.ondrop = function (e) {
        e.preventDefault();
        controlerLogo(e.dataTransfer.files[0]);
    }

    fichier.onchange = function () {
        if (this.files.length > 0) controlerLogo(this.files[0]);
    };
    nom.onkeypress = function (e) {
        if (!/^[A-Za-z0-9ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ' ()._-]$/.test(e.key)) return false;
    };
    nom.focus();
}

function controlerLogo(file) {
    function afficherErreurLogo(message) {
        messageLogo.innerText = message;
        cible.innerHTML = "Déposez le logo ici <br> ou <br> sélectionnez-le en cliquant dans le cadre";
        leLogo = null;
    }

    messageLogo.innerText = "";
    let parametre = {
        file: file,
        lesExtensions: ["jpg", "png", "gif"],
        lesTypes: ["image/pjpeg", "image/jpeg", "x-png", "image/gif", "image/png"],
        taille: 300 * 1024,
        error: function (reponse) {
            afficherErreurLogo(reponse);
        }
    }
    if (Ctrl.fichierValide(parametre)) {
        // vérification des dimensions
        let largeurMax = 200;
        let hauteurMax = 200;
        let img = new Image();
        img.src = window.URL.createObjectURL(file);
        // il faut attendre que l'image soit chargée pour effectuer les contrôles
        img.onload = function () {
            if (img.width > largeurMax || img.height > hauteurMax) {
                afficherErreurLogo("Les dimensions de l'image dépassent les dimensions autorisées.");
            } else {
                messageLogo.innerText = "";
                leLogo = file;
                cible.innerHTML = "";
                cible.appendChild(img);
            }
        }
        img.onerror = function () {
            afficherErreurLogo("Il ne s'agit pas d'un fichier image.");
        }
    }
}

function ajouter() {
    msg.innerHTML = "";
    let monFormulaire = new FormData();
    if (leLogo !== null)
        monFormulaire.append('fichier', leLogo);

    monFormulaire.append('nom', nom.value);
    monFormulaire.append('rang', rang.value);
    monFormulaire.append('description', description.value);
    monFormulaire.append('url', url.value);
    $.ajax({
        url: 'ajax/ajouter.php',
        type: 'POST',
        data: monFormulaire,
        processData: false,
        contentType: false,
        dataType: "json",
        error: erreurAjax,
        success: function () {
            // mise à jour de l'interface
            Std.afficherMessage({message : 'Lien enregistré', type : 'success', position : 'topRight'});
            for (const input of document.querySelectorAll('input.ctrl')) {
                input.value = '';
                input.classList.remove('correct');
            }
            cible.innerHTML = "Déposez le logo ici <br> ou <br> sélectionnez-le en cliquant dans le cadre                 <br>\n" +
                "                <img src=\"../img/aide.png\"\n" +
                "                     style=\"width: 20px; height: 20px\"\n" +
                "                     alt=\"Fichiers acceptés\"\n" +
                "                     data-title=\"<b>Fichiers acceptés<b>\"\n" +
                "                     data-toggle=\"popover\"\n" +
                "                     data-trigger=\"hover\"\n" +
                "                     data-html=\"true\"\n" +
                "                     data-placement='left'\n" +
                "                     data-content=\"<div style='font-size:11px'>\n" +
                "\t\t\t\t\t\t<p> Extensions  : png, jpg ou gif </p>\n" +
                "\t\t\t\t\t\t<p> Taille maximale : 30 Ko </p>\n" +
                "\t\t\t\t\t\t<p> Dimension maximale : 150 * 150 </p>\n" +
                "\t\t\t\t\t\t</div>\"\n" +
                "                >";
            leLogo = null;
        }
    });
}
