"use strict";

let confirmationIdentique = false;
let passwordValide = false;

window.onload = init;

function init() {
    btnValider.onclick = controlerAvantModification;

    // Traitement événementiel sur le champ passwordActuel
    passwordActuel.oninput = function () {
        messagePasswordActuel.innerText = "";
        this.classList.remove('erreur');
    }

    passwordActuel.onchange = function () {
        if (Ctrl.controler(this)) {
            $.ajax({
                url: 'ajax/verifierpassword.php',
                type: 'POST',
                data: {password: this.value},
                dataType: "json",
                error: function (request) {
                    messagePasswordActuel.innerText = request.responseText;
                    passwordActuel.classList.add('erreur');
                    passwordValide = false;
                },
                success: function () {
                    passwordActuel.classList.remove('erreur');
                    messagePasswordActuel.innerText = '';
                    passwordValide = true;
                }
            });
        }
    };


// traitement événementiel sur le champ password
    password.oninput = function () {
        messagePassword.innerText = ""
        password.classList.remove('erreur');
    };

    confirmation.oninput = function () {
        messageConfirmation.innerText = ""
        confirmation.classList.remove('erreur');
    };

    // traitement événementiel sur le champ confirmation
    confirmation.onpaste = function () {
        return false;
    };
}

// vérifie l'égalité entre password et confirmation
function controlerConfirmation() {
    if (password.value === confirmation.value) {
        return true;
    } else {
        confirmation.classList.add('erreur');
        messageConfirmation.innerText = "La confirmation n'est pas identique !"
        return false;
    }
}

function controlerPassword() {
    if (Ctrl.controler(password)) {
        if (password.value === passwordActuel.value) {
            messagePassword.innerText = "Le nouveau mot de passe est identique à l'actuel mot de passe";
            password.classList.add('erreur')
            return false;
        } else
            return true;
    } else {
        return false;
    }
}

function controlerAvantModification() {

    // le champ passwordActuel n'est pas lié à une expression régulière
    // la gestion d'erreur est réalisée par le champ sauf s'il n'est pas renseigné

    let passwordOk = controlerPassword();
    let confirmationOk = passwordOk && controlerConfirmation();
    if (confirmationOk && passwordOk && passwordValide ) modifier()
}

function modifier() {
    $.ajax({
        url: "ajax/modifierpassword.php",
        data: {password: password.value, passwordActuel: passwordActuel.value},
        type: 'post',
        dataType: "json",
        error: erreurAjax,
        success: function (data) {
            document.querySelectorAll('input').forEach(element => element.value = "");
            let parametre = {
                message : "Votre nouveau mot de passe est pris en compte.",
                type : 'success',
                fermeture : 1,
                surFermeture : function() {
                    document.location.href = "../index.php";
                }
            }
            Std.afficherMessage(parametre);

        }
    });
}

