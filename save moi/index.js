/*
Fonctions :
    affichage de la page d'accueil : Prochaine épreuve

Tables utilisées :
    epreuve(id, nom, desscription, date)

Appels Ajax :
    ajax/getdonneesaccueil.php :  récupération de la prochaine épreuve

*/

"use strict";

window.onload = init;

function init () {
    $.getJSON("ajax/getdonneesaccueil.php", afficher).fail(erreurAjax);
    $('[data-toggle="tooltip"]').tooltip ();
    let div = document.getElementById('club');
    transition.begin(titre, [
        ["transform", "scale(0)", "scale(1)", "2s", "linear"],
        ["color", "black", "white", "1s", "linear", function (element, finished) {
                if (!finished) return;
                // titre.style.display = 'none';
            }],
        ], { timingFunction: "linear"});

    transition.begin(facebook1, [
        ["transform", "scale(0)", "scale(1)", "2s", "linear"],
    ]);
    transition.begin(logo, [
        ["transform", "scale(0)", "scale(1)", "2s", "linear"],
    ]);



    transition.begin(photos, [
        ["transform", "scale(0)", "scale(1)", "2s", "linear"],
    ]);

    transition.begin(club, [
        ["transform", "scale(0)", "scale(1)", "2s", "linear"],
    ]);


    transition.begin(saisons, [
        ["transform", "scale(0)", "scale(1)", "2s", "linear"],
    ]);
    pied.style.visibility = "visible";
}

function afficher(data) {
    // affichage de la prochaine épreuve si renseigné
    if (data.prochaineEpreuve) {
        let epreuve = data.prochaineEpreuve;
        let date = new Date(epreuve.date);
        dateEpreuve.innerText = Std.ucWord(date.toFormatLong());
        nomEpreuve.innerText = epreuve.nom;
        descriptionEpreuve.innerHTML = epreuve.description;
        // mise en route du compte à rebours
        initialiser(date);
        prochaineEpreuve.style.display = 'block'
        transition.begin(prochaineEpreuve, [
            ["transform", "scale(0)", "scale(1)", "2s", "linear"],
            ["color", "black", "white", "1s", "linear"],
        ]);
    }
}

// ------------------------------------------------
// Fonction pour gérer le compte à rebours
// ------------------------------------------------

function initialiser(date) {
   setInterval(function() {majHorloge(date, this)}, 1000);
}

function majHorloge(date, timer) {
    let lesElements = getTempsRestant(date);
    jour.innerHTML = lesElements.jour;
    heure.textContent = ('0' + lesElements.heure).slice(-2);
    minute.textContent = ('0' + lesElements.minute).slice(-2);
    seconde.textContent = ('0' + lesElements.seconde).slice(-2);
    if (lesElements.difEnMs <= 0) {
        clearInterval(timer);
    }
}

function getTempsRestant(uneDate) {
    let difEnMs = Date.parse(uneDate) - Date.parse(new Date());
    let seconde = Math.floor((difEnMs / 1000) % 60);
    let minute = Math.floor((difEnMs / 1000 / 60) % 60);
    let heure = Math.floor((difEnMs / (1000 * 60 * 60)) % 24);
    let jour = Math.floor(difEnMs / (1000 * 60 * 60 * 24));
    return {'difEnMs': difEnMs, 'jour': jour, 'heure': heure, 'minute': minute, 'seconde': seconde};
}