// Connexion d'un membre
// Date mise à jour : 27/08/2020
"use strict";

window.onload = init;

function init() {
    miseEnPage();
    $('[data-toggle="popover"]').popover();
    login.focus();
    btnValider.onclick = connexion;
    login.onkeypress = function (e) {
        if (e.key === "Enter")
            if (code.value.length === 0)
                code.focus();
            else
                connexion();
    }

    code.onkeypress = function (e) {
        if (e.key === "Enter")
            if (login.value.length === 0)
                login.focus();
            else
                connexion();
    }
}

function connexion() {
    let loginOk = Ctrl.controler(login);
    let codeOk = Ctrl.controler(code)
    if (codeOk && loginOk) connecter();
}

function connecter() {
    let memoriser = chkMemoriser.checked ? 1 : 0;

    $.ajax({
        url: 'ajax/connecter.php',
        type: 'POST',
        data: {login: login.value, code: code.value, memoriser : memoriser},
        dataType: "json",
        error: erreurAjax,
        success: function (data) {
            location.href = "../index.php"
        }
    })
}
