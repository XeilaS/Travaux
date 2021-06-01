"use strict";


window.onload = init;

function init() {
    $.getJSON("ajax/getdonnees.php", afficher).fail(erreurAjax);


    // Evenement btnImpression (pdf)
    btnImpression.onclick = function() {
        $.ajax({
            url: "ajax/genererPdf.php",
            type: 'post',
            dataType: "json",
            error: erreurAjax,
            success: function () {
                window.open('listePdf/listeMembres.pdf', 'pdf');
            }
        });
    };


    // tooltip
    $('[data-toggle="tooltip"]').tooltip ();
}

function afficher(lesMembres) {
    msg.innerHTML = '';
    lesLignes.innerHTML = '';

    // Tableau des Membres utilisant composant Datatables
    for (const membre of lesMembres) {
        let nomPrenom = membre.nom + " " + membre.prenom;
        let tr = document.createElement('tr');

        let td = document.createElement('td');
        td.innerText = membre.nom;
        tr.appendChild(td);
        td = document.createElement('td');
        td.innerText = membre.prenom;
        tr.appendChild(td);
        td = document.createElement('td');
        td.innerText = membre.email;
        tr.appendChild(td);
        td = document.createElement('td');

        // Si le mobile n'existe pas, on remplace la case par un tiret
        if (membre.mobile == "" || membre.mobile == null) {
            td.innerText = "-";
            td.classList.add('text-info');
        } else {
            td.innerText = membre.mobile;
        }
        td.classList.add('text-center');
        tr.appendChild(td);
        td = document.createElement('td');

        // Si le fixe n'existe pas, on remplace la case par un tiret
        if (membre.fixe == "" || membre.fixe == null) {
            td.innerText = "-";
            td.classList.add('text-info');
        } else {
            td.innerText = membre.fixe;
        }
        td.classList.add('text-center');
        tr.appendChild(td);
        td = document.createElement('td');
        td.innerText = membre.montantLicence + "€";
        td.classList.add('text-center');
        tr.appendChild(td);

        td = document.createElement('td');
        td.classList.add('text-center');

        // Si la photo existe, on affiche un btn qui permet de supprimer la photo (avec message de confirmation)
        // Sinon, on remplace la case par un tiret
        if (membre.photo){
            let btn = document.createElement('button');
            btn.style.paddingTop = '0px';
            btn.style.paddingBottom = '0px';
            btn.style.paddingRight = '5px';
            btn.style.paddingLeft = '5px';
            btn.style.fontSize = "10px";
            btn.innerHTML = "<i class=\"fa fa-times\" aria-hidden=\"true\"></i>";
            btn.classList.add('btn');
            btn.classList.add('btn-danger');
            btn.onclick = function () {
                let n = new Noty({
                    text: 'Êtes vous sûr de vouloir supprimer l\'image de profil de ' + nomPrenom + " ?",
                    layout: 'center',
                    theme: 'sunset',
                    modal: true,
                    type: 'info',
                    animation: {
                        open: 'animated lightSpeedIn',
                        close: 'animated lightSpeedOut'
                    },
                    buttons: [
                        Noty.button('Oui', 'btn btn-sm btn-success w-50', function () {
                            supprimerPhoto(membre.id);
                            n.close();
                            $(this).remove();
                            td.innerText = "-";
                            td.classList.add('text-info');
                        }),
                        Noty.button('Non', 'btn btn-sm btn-danger w-50', function () {
                            n.close();
                        })
                    ]
                }).show();
            };
            td.appendChild(btn);
        } else {
            td.innerText = "-";
            td.classList.add('text-info');
        }
        tr.appendChild(td);

        lesLignes.appendChild(tr)
    }
    $("#leTableau"). DataTable({
        "language": { "url": "../composant/datatables/french.json" },
        "paging": true,
        "bLengthChange": false,
        "pageLength": 50, // fixer le nombre d'enregistrements par page
        "bProcessing": true,
        "bSort": true,
    });
}


function supprimerPhoto(id){
    $.ajax({
        url: 'ajax/supprimerphoto.php',
        data: {
            id : id
        },
        type: 'post',
        dataType: "json",
        success: function (data) {
            if (data == 1){
                Std.afficherMessage({ message : "Suppression effectuée", type : 'success', position : 'topRight' });
            }
        },
        error: erreurAjax
    })
}


