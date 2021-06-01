function erreurAjax(request) {
    msg.innerHTML = Std.genererMessage(request.responseText, 'rouge');
}

"use strict";

let lesMessages; //message

window.onload = init;

function init() {
    $.getJSON("ajax/getlesmessages2", remplirLesDonnees).fail(erreurAjax);

}

function remplirLesDonnees(data) {
    lesMessages = data.lesMessages;
    for (const message of data.lesEmails) {
        idMessage.appendChild(new Option(message.message, message.reponse));
    }
    afficher();
}
function afficher() {
    lesDonnees.innerHTML = '';
    for (const message of lesMessages) {
    }
    if (lesDonnees.childNodes.length === 0)
        idMessage.innerHTML = Std.genererMessage("Aucun message correspondant", 'rouge')
}


function afficherMessage(message) {
    let tr = document.createElement('tr');
    let td = document.createElement('td');
    td.innerText = message.message;
    tr.appendChild(td);
    td = document.createElement('td');
    td.innerHTML = message.reponse;
    tr.appendChild(td);
    lesDonnees.appendChild(tr);

}
/*
function init() {
    // $.getJSON("ajax/getlesmessages.php", remplirLesDonnees).fail(erreurAjax);
   // idMessage.onchange = getlesmessages;
   }

 */
/*
function remplirLesDonnees(data) {
    for (const message of data.lesMesssages)
        idMessage.add(new Option(message.email));
    getlesmessages();
}

function getlesmessages() {
    $.getJSON("ajax/getlesmessages2.php", remplirLesDonnees).fail(erreurAjax);
    $.ajax({
        url: 'ajax/getlesmessages2.php',
        type: 'POST',
        data: {idMessage: idMessage.value},
        dataType: "json",
        error: erreurAjax,
        success: afficher
    })

}

function afficher(data) {
    message.innerHTML = '';
    lesDonnees.innerHTML = '';
    for (const message of data) {
        afficherMessage(message);
    }
}


function afficherMessage(message) {
    let tr = document.createElement('tr');
    let td = document.createElement('td');
    td.innerText = message.message;
    tr.appendChild(td)
    td = document.createElement('td');
    td.innerText = message.reponse;
    tr.appendChild(td);
    lesDonnees.appendChild(tr)
}
*/