"use strict";

window.onload = init;

function init() {
    miseEnPage();
    $('#contenu').load('ajax/getpagebyid.php' + document.location.search);
}

