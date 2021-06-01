/**
 * fonction d'erreur,
 * cette derniére renvoie une erreur si la fonction init n'arrive pas a lancer la fonction afficher
 */

function erreurAjax(request) {
    msg.innerHTML = Std.genererMessage(request.responseText, 'rouge');
}

"use strict";

window.onload = init;

/**
 * fonction d'initialisation,
 * cette derniére vas renvoyer a la fonction afficher pour afficher les cartes de la pages.
 * ou, si un probléme est rencontrée, vers la fonction erreurAjax.
 *
 */
function init () {

    $.getJSON("ajax/getleslogos.php", afficher).fail(erreurAjax);


}

function afficher(data) {
    for (const partenaire of data) {
        const id = partenaire.id;
        /**
         * création de la carte
         */
        let carte = document.createElement('div');
        carte.classList.add('card');
        /**
         * entéte
         */
        let entete = document.createElement('div');
        entete.classList.add('card-header');
        entete.classList.add('bg-dark');
        entete.classList.add('text-white');
        entete.classList.add('text-center');
        entete.style.minHeight = '75px';
        /**
         * input
         */
        let input = document.createElement("input");
        input.type = "text";
        input.value = partenaire.nom;
        input.dataset.old = partenaire.nom;
        input.classList.add('form-control');
        input.pattern="^[0-9A-Za-zÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ' ()._-]+$";
        input.maxlength = 50;
        input.onkeypress = function (e) {
            if (e.key === "Enter") modifier('nom',this, id,1);
            else if (!/^[A-Za-z0-9ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ' ()._-]$/.test(e.key)) return false;
        };
        input.onblur = function () { modifier('nom',this, id,1);};


        entete.appendChild(input);
        carte.appendChild(entete);
        /**
         * corps
         */
        let corps = document.createElement('div');
        corps.classList.add("card-body");
        corps.classList.add("text-center");
        /**
         * logo
         */
        let img =  document.createElement('img');
        img.src = 'logo/' + partenaire.logo;
        img.style.width = "200px";
        // img.style.height = "150px";
        img.alt = "";
        corps.appendChild(img);

        carte.appendChild(corps);
        /**
         * pieds de pages
         */
        let pied = document.createElement('form');
        let pied2 = document.createElement('div');
        pied2.classList.add('form-group')
        pied2.classList.add('card-footer');
        pied2.classList.add('text-muted');
        pied2.classList.add('text-center');

        let textarea = document.createElement("textarea");

        textarea.value = partenaire.domaine;
        textarea.dataset.old = partenaire.domaine;
        textarea.classList.add('form-control');
        textarea.maxlength = 500;
        textarea.onkeypress = function (hi) {
            if (hi.key === "tab") modifier('domaine',this, id,0);
        };
        textarea.onblur = function () { modifier('domaine',this, id,0);};
        pied2.appendChild(textarea);

        pied.appendChild(pied2);

        carte.appendChild(pied);


        /**
         * liens
         */

        let liens = document.createElement('button');
        liens.classList.add('btn');
        liens.classList.add('btn-danger');
        liens.classList.add('btn-lg');
        liens.classList.add('btn-block');
        liens.onclick = function() { confirmerSuppression(partenaire.id)};
        liens.innerText = "supprimer";
        carte.appendChild(liens);

        lesCartes.appendChild(carte);
    }
}




// ------------------------------------------------------
// Traitement concernant la suppression
// ------------------------------------------------------


function confirmerSuppression(id) {
    let n = new Noty({
        text: 'Confirmer la demande de suppression ',
        layout: 'center', theme: 'sunset', modal: true, type: 'info',
        animation: {
            open: 'animated lightSpeedIn',
            close: 'animated lightSpeedOut'
        },
        buttons: [
            Noty.button('Oui', 'btn btn-sm btn-success marge ', function () {
                supprimer(id);
                n.close();
            }),
            Noty.button('Non', 'btn btn-sm btn-danger', function () { n.close(); })
        ]
    }).show();
}

function supprimer(id) {
    $.ajax({
        url: 'ajax/supprimer.php',
        type: 'POST',
        data: {id: id},
        dataType: "json",
        success: function () {
            Std.afficherMessage( {message : "Suppression réalisée", type : 'success'});

            lesCartes.innerHTML = "";
            $.getJSON("ajax/getleslogos.php", afficher).fail(erreurAjax);

        },
        error: function (request) { msg.innerHTML = Std.genererMessage(request.responseText, 'rouge'); }
    })
}









// ------------------------------------------------------
// Traitement concernant la modification
// ------------------------------------------------------

function modifier(colonne, champ, id) {
    $.ajax({
        url: 'ajax/modifier.php',
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
