function erreurAjax(request) {
    msg.innerHTML = Std.genererMessage(request.responseText, 'rouge');
}

"use strict";

window.onload = init

function init() {
    $.getJSON("ajax/getlesmessages.php", ajouter).fail(erreurAjax);
    //chargement des données

    // traitement associé au bouton 'Envoyer'
    btnAjouter.onclick = ControleAvantAjout;


// traitements associés au champ nom
    nom.onkeypress = function (e) {
        if (!/^[A-Za-z]([A-Za-z ]*[A-Za-z])*$/.test(e.key)) return false;
    };
    nom.onchange = controlerNom;
    nom.focus();


// traitements associés au champ email
    email.focus();
    email.onchange = controlerEmail;

}


function ControleAvantAjout(){
    let nomOk = controlerNom();
    let emailOk= controlerEmail();
    if (emailOk && nomOk) ajouter();

}

function controlerNom() {
    nom.value = nom.value.trim();
    return Ctrl.controlerChamp(nom);
}

function controlerEmail(){
    return Ctrl.controlerChamp(email)

}





/*

function controlerDescription() {
    if (description.value.length > 0) {
        messageDescription.innerText = "Vous devez écrire un message";
        return false;
    } else {
        messageDescription.innerText = "";
        return true;

    }

}
*/

function ajouter() {
    $.ajax({
        url: 'ajax/envoyermessage.php',
        type: 'POST',
        data: {
            nom: nom.value,
            description: description.value,
            email: email.value,
        },
        dataType: "json",
        error: function (request) {
            Std.afficherMessage({
                message: request.responseText,
                fermeture: 1
            })
        },
        success: function () {
            Std.afficherMessage({
                message: "Message envoyé",
                type: "success",
                fermeture: 0,
                surFermeture: function () {
                    description.value = '';
                    nom.value = '';
                }
            })
        }
    })
}






