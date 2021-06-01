"use strict";

window.onload = init;

function init() {
    $.getJSON("ajax/getlesadmins.php", remplirLesDonnees).fail(erreurAjax);
    lesAdmins.onchange = chargerCompetence;
    btnSupprimer.onclick = supprimer;
}

function remplirLesDonnees(data) {
    // affichage des compétences dans un tableau
    for (const fonction of data.lesFonctions) {
        let tr = document.createElement('tr');
        let td = document.createElement('td');
        td.style.textAlign = 'center';

        let uneCase = document.createElement('input');
        uneCase.type = 'checkbox';
        uneCase.id = fonction.id;
        uneCase.style.display = 'inline-block';  // pour pouvoir centrer la case
        // pour permettre de récupérer toutes les cases
        uneCase.name = 'fonction';
       //controle de la case cochée

        uneCase.onclick = function () {
            $.ajax({
                url: "ajax/majdroitsadmins.php",
                type: 'POST',
                data: {
                    idAdministrateur: lesAdmins.value,
                    idFonction: fonction.id,
                    ajout: uneCase.checked ? 1 : 0,
                },
                dataType: 'json',
                error: erreurAjax,
                success : function (){

                    Std.afficherMessage({
                        message: "droit mis a jour ",
                        type : 'success',
                        position : 'topCenter',
                        fermeture : 0,

                    });
                }
            });
        };
        td.appendChild(uneCase);
        tr.appendChild(td);

        td = document.createElement('td');
        td.innerText = fonction.description;
        tr.appendChild(td);

        lesLignes.appendChild(tr);
    }

    // alimentation de la zone de liste
    for (const admin of data.lesAdmins) {
        lesAdmins.add(new Option(admin.nom, admin.id));
    }
    chargerCompetence();
}

function chargerCompetence() {
    $.post("ajax/getlesdroitsadmins.php", {idAdministrateur: lesAdmins.value}, afficher, 'json').fail(erreurAjax);

}

function afficher(data) {
    decocherCase()
    for (const fonction of data)
        document.getElementById(fonction.idFonction).checked = true;
        // ne fonctionne pas sur firefox
        // window[fonction.idFonction].checked = true;
}

//mise a jour des droit via une case à cocher


function supprimer() {
    $.post("ajax/supprimerlesdroitsadmins.php", {idAdministrateur: lesAdmins.value}, '', 'json').fail(erreurAjax);
    decocherCase();
}

function decocherCase() {
    for (const input of document.getElementsByName("fonction"))
        input.checked = false;
    // $('input:checkbox').each(function() {this.checked = true});
    // $("input:checkbox[name='competence']").each(function() {this.checked = false});
    // for (const uneCase of document.querySelectorAll("input[type='checkbox']")) uneCase.checked = false;
    // $("input:checkbox[name='competence']").each(function() {this.checked = false});
}

//