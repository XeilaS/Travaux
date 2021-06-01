"use strict";

window.onload = init
/** initialisation d'une variable DateJ**/
let dateJ = new Date();

/**fonction d'initialisation**/
function init() {
    /**traitement associé au bouton 'Ajouter'**/
    btnAjouter.onclick = controleAvantAjout;
    date.max = dateJ.toFormatMySQL();
    date.value = dateJ.toFormatMySQL();
    url.onchange = controlerUrl;
    titre.onchange = controlerTitre;
}

/**fonction de control sur l'url qui renvoie au code dans ajout.php et la foonction controlerChamp**/
function controlerUrl() {
    return Ctrl.controler(url);
}

/**fonction de control sur le titre qui renvoie au code dans ajout.php et la foonction controlerChamp**/
function controlerTitre() {
    return Ctrl.controler(titre);
}

/**fonction de control sur la date qui renvoie au code dans ajout.php et la foonction controlerDate**/
function controlerDate() {
    return Ctrl.controler(date);
}

/**Cette fonction verifie si tout les controles sont ok, si ils le sont alors on peux ajouter un nouveau reportage photo**/
function controleAvantAjout() {
    let UrlOk = controlerUrl();
    let TitreOk = controlerTitre();
    let DateOk = controlerDate();
    if (UrlOk && TitreOk && DateOk) ajouter();
}

/**Cette fonction permet l'ajout**/
function ajouter() {
    $.ajax({
        url: 'ajax/ajouter.php',
        type: 'POST',
        data: {
            url: url.value,
            titre: titre.value,
            date: date.value,
        },
        dataType: "json",
        error: function (request) {
            Std.afficherMessage({
                message: request.responseText,
                fermeture: 1
            })
        },
        success: function (id) {
            Std.afficherMessage({
                message: "Reportage ajoutée",
                type: "success",
            })
        }
    })
}
