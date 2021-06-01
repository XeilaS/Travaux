"use strict";

window.onload = init;

function init() {
    btnEnvoyer.onclick = controleAvantEnvoi;
    $('[data-toggle="popover"]').popover();
}

function controleAvantEnvoi() {
    let emailOk = Ctrl.controler(email);
    if (emailOk) envoyer();
}


function envoyer() {
    $.ajax({
        url: 'ajax/envoyerpassword.php',
        type: 'POST',
        data: {email: email.value},
        dataType: "json",
        error: erreurAjax,
        success: function (data) {
            let parametre = {
                message : "Votre code d'accès vient de vous être envoyé, veuillez consulter votre boîte mail.",
                type : 'success',
                fermeture : 1,
                surFermeture : function() {
                    document.location.href = "../index.php";
                }
            }
            Std.afficherMessage(parametre);
        }
    })
}
