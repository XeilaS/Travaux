"use strict";

window.onload = init;


function init() {
    $('[data-toggle="popover"]').popover();
    $.getJSON("ajax/getlesclassements.php", afficher);
}

function afficher(data) {
    for (const classement of data) {
        let id = classement.id;
        let tr = document.createElement("tr");
        tr.id = classement.id;
        let td = document.createElement("td");
        if (classement.present == 1) {
            let img = new Image();
            img.src = "../img/pdf.png";
            img.style.marginRight = '10px';
            img.onclick = function () {
                window.open('../archive/' + classement.fichier, 'pdf');
            };
            td.appendChild(img);
            img = new Image();
            img.src = "../img/supprimer.png";
            img.onclick = function () {
                confirmationSuppression(id);
            };
            td.appendChild(img);
        }
        tr.appendChild(td);
        td = document.createElement("td")
        let input = document.createElement("input");
        input.type = 'text';
        input.classList.add('form-control');
        input.value = classement.fichier;
        input.disabled = true;
        td.appendChild(input);
        tr.appendChild(td);

        td = document.createElement("td");
        input = document.createElement("input");
        input.type = "text";
        input.value = classement.nbParticipant;
        input.dataset.old = classement.nbParticipant;
        input.classList.add('form-control');
        input.pattern = "^[0-9]+$";
        input.onkeypress = function (e) {
            if (e.key === "Enter") modifierNbParticipant(this, id);
            else if (!/^[0-9]+$/.test(e.key)) return false;
        };
        input.onchange = function () { modifierNbParticipant(this, id);};
        input.ondrop = function(e) {e.preventDefault(); }
        td.appendChild(input);
        tr.appendChild(td);
        lesLignes.appendChild(tr);
    }
}

function modifier(colonne, champ, id) {
    $.ajax({
        url: 'ajax/modifierNbParticipant.php',
        type: 'POST',
        data: {colonne : colonne, valeur : champ.value, id: id},
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


function modifierNbParticipant(champ, id) {
    if (champ.value !== champ.dataset.old && Ctrl.verifierChamp(champ)) {
        modifier('nbParticipant', champ, id)
    }
}

function confirmationSuppression(id) {
    let n = new Noty({
        text: 'Confirmer la suppression du document ',
        layout: 'center',
        theme: 'sunset',
        type: 'info',
        animation: {
            open: 'animated lightSpeedIn',
            close: 'animated lightSpeedOut'
        },
        buttons: [
            Noty.button('Oui', 'btn btn-sm btn-success marge ', function () {
                supprimer(id);
                n.close();
            }),
            Noty.button('Non', 'btn btn-sm btn-danger', function () {
                n.close();
            })
        ]
    }).show();
}

function supprimer(id) {
    $.ajax({
        url: 'ajax/supprimer.php',
        type: 'POST',
        data: {id: id},
        dataType: "json",
        error: erreurAjax,
        success: function () {
            let ligne = document.getElementById(id);
            ligne.parentNode.removeChild(ligne);
        }
    })
}






