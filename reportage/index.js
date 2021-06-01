 "use strict";

let lesReportages; // tableau stockant les reportages pour assurer le filtrage sur la l'année

window.onload = init;


/**fonction d'initialisation = renvoie a la fonction afficher() pour afficher les cartes**/
function init() {
    $.getJSON("ajax/getlesreportages.php", remplirLesDonnees).fail(erreurAjax);
    lesAnnees.onchange = afficher;
    }

/**Cette fonction permet de remplir la zone de liste pour filtrer sur les années**/
function remplirLesDonnees(data) {
    lesReportages = data.lesReportages;
    for (const annee of data.lesAnnees)
        lesAnnees.appendChild(new Option(annee.annee, annee.annee));
    afficher()
}

function afficher() {
    lesCartes.innerHTML = "";
    let row = document.createElement('div');
    row.classList.add("row");
    for (const reportage of lesReportages) {
        const id = reportage.id;
        if (reportage.annee === lesAnnees.value) {


            /**Creation de la carte**/
            let col = document.createElement('div');
            col.classList.add("col-4");
            let carte = document.createElement('div');
            carte.id = reportage.id;
            carte.classList.add('card', 'mt-2');

            /**Entête de la carte**/
            let entete = document.createElement('div');
            entete.classList.add('card-header', 'bg-info', 'text-white', 'text-center');
            let a = document.createElement('input');

            a.type = "text";
            a.value = reportage.titre;
            a.dataset.old = reportage.titre;
            a.classList.add('form-control');
            //  a.pattern = "^[0-9A-Za-zÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ'()._ -]+$"
            /** "onkeypress" validation en appuyant sur entrée**/
            a.onkeypress = function (e) {
                if (e.key === "Enter") a.change();
                else if (!/^[0-9A-Za-zÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ.()'_ -]$/.test(e.key)) return false;

            };
            /** "onchange" validation en appuyant sur clic gauche en dehors de la zone de texte**/
            a.onchange = function () {
               modifier('titre', this, id);
            };
            entete.appendChild(a);
            carte.appendChild(entete);

            /**Corp de la carte**/
            let corp = document.createElement('div');
            corp.classList.add('card-footer', 'bg-white', 'text-black', 'font-italic');
            corp.style.fontSize = '0.75rem';
            corp.innerText = "Edition du " + reportage.date
            carte.appendChild(corp);


            let pied = document.createElement('div');
            pied.classList.add('card-footer', 'bg-white', 'text-black', 'font-italic');
            pied.classList.add('text-center');
            pied.style.fontSize = '0.75rem';

            /**Solution où l'on supprime en cliquant sur un bouton supprimer**/
            let Bouton = document.createElement('button');
            Bouton.classList.add('btn');
            Bouton.classList.add('btn-danger');
            Bouton.classList.add('btn-lg');
            Bouton.classList.add('btn-block');
            Bouton.onclick = function () {
                confirmerSuppression(reportage.id)
            };
            Bouton.innerText = "SUPPRIMER";
            carte.appendChild(Bouton);

            /**Solution où l'on supprime en cliquant sur une image**/
            // let img = document.createElement('img');
            // img.title = "Supprimer";
            // img.src = 'supprimer.png';
            // img.onclick = function () {
            //     confirmerSuppression(reportage.id);
            // };

            pied.appendChild(Bouton);
            carte.appendChild(pied);
            // lesCartes.appendChild(carte)
            col.appendChild(carte);
            row.appendChild(col);

        }
    }
    lesCartes.appendChild(row);
}




/**Cette fonction permet la mise en place d'un message de confirmation pour la supression d'une carte**/
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
            Noty.button('Non', 'btn btn-sm btn-danger', function () {
                n.close();
            })
        ]
    }).show();
}

/**Cette fonction permet la mise en place de la supression d'une carte**/
function supprimer(id) {
    $.ajax({
        url: 'ajax/supprimer.php',
        type: 'POST',
        data: {id: id},
        dataType: "json",
        success: function () {
            Std.afficherMessage({message: "Suppression réalisée", type: 'success'});

            let i = lesReportages.findIndex(element => element.id === id);
            lesReportages.splice(i, 1);
            afficher();
        },
        error: function (request) {
            msg.innerHTML = Std.genererMessage(request.responseText, 'rouge');
        }
    })
}

/**Cette fonction permet la mise en place de la modification du titre de la carte**/
function modifier(colonne, champ, id) {
    $.ajax({
        url: 'ajax/modifier.php',
        type: 'POST',
        data: {colonne: colonne, valeur: champ.value, id: id},
        dataType: "json",
        success: function () {
            Std.afficherMessage({
                message: "Modification prise en compte",
                type: 'success',
                position: 'topRight'
            })
            champ.dataset.old = champ.value;
        },
        error: function (request) {
            Std.afficherMessage({
                message: request.responseText,
                fermeture: 1,
                surFermeture: function () {
                    champ.value = champ.dataset.old;
                }
            })
        }
    })
}

function controlerTitre() {
    return Ctrl.controler(titre);
}
