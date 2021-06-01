"use strict";

window.onload = init;

function init() {
    miseEnPage();
    $.getJSON("ajax/getlesclassements.php", afficher).fail(erreurAjax);
}

function afficher(data) {
    for (const classement of data) {
        let id = classement.id;
        let tr = document.createElement("tr");
        tr.id = classement.id;
        let td = document.createElement("td");
        if (classement.present == 1) {
            let img = new Image();
            img.src = "../img/pdf.png";
            img.style.marginLeft = '10px';
            img.onclick = function () {
                window.open('../archive/' + classement.fichier, 'pdf');
            };
            td.appendChild(img);
        }
        tr.appendChild(td);
        td = document.createElement("td");
        td.innerText = classement.dateCourse;
        tr.appendChild(td);
        td = document.createElement('td');
        td.innerText = classement.nom;
        tr.appendChild(td);
        td = document.createElement('td');
        td.innerText = classement.distance;
        tr.appendChild(td);
        td = document.createElement('td');
        td.classList.add('text-center');
        td.innerText = classement.nbParticipant;
        tr.appendChild(td);
        lesLignes.appendChild(tr);
    }
    $.fn.dataTable.moment('DD/MM/YYYY');
    $(function () {
        $("#leTableau").DataTable({
            language: {url:"../composant/datatables/french.json"},
            ordering : true,
            bLengthChange : false,
            aaSorting: [[ 1, "desc" ]],
            aoColumnDefs:  [{bSortable: false, aTargets: [ 0, 2,4]}],
            pageLength: 50
        });
    });
}

