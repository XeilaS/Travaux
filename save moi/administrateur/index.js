let id = null;
let lesMembres = [];
"use strict";
//variables globales

window.onload = init;

function init() {
    //getlesadmins : les membres déjà administrateur pour alimenter le corps de l'interface
    $.getJSON("ajax/getlesadmins.php", afficher).fail(erreurAjax);

    //getlesmembres : les membres qui ne sont pas administrateur
    //pour alimenter l'input et le easyAutoComplete
    $.getJSON("ajax/getlesmembres.php", remplirEAC).fail(erreurAjax);
    // lors du clique sur le bouton d'ajout on appel la fonction ajouter.
    btnAjouter.onclick = controleAvantAjout;
}


//----------------------------------------------------
// aliementation de la zone autocomplete avec les membres
//----------------------------------------------------

function remplirEAC(data) {
    //remplissage du tableau lesMembres avec les données du script php getlesmembres.php
    lesMembres = data;
    // la variable $nomR contient la balise nomR
    let $nomR = $("#nomR");

    let option = {

        data: lesMembres,
        //valeur de la requete
        getValue: "nomPrenom",
        list: {
            match: {
                enabled: true,
                // correspondance à partir du premier caractère
                method: function (element, phrase) {
                    return element.indexOf(phrase) === 0;
                }
            },
            onChooseEvent: function () {
                // récupération de l'id du nom sélectionné
                id = $nomR.getSelectedItemData().id;
                nomR.classList.remove("erreur");


            },
            onLoadEvent : function (){
                let lesValeurs = $nomR.getItems();
                if(lesValeurs.length === 0){
                    nomR.classList.add("erreur");
                    id =null;
                }
            }
        }
    }
    //alimentation de la zone input
    $nomR.easyAutocomplete(option);
}

//---------------------------------------------
//aliementation du tableau avec les administrateur.
//-------------------------------------------

function afficher(data) {

    for (const admin of data) {
        const id = admin.id;
        //création des colones du tableau
        let tr = document.createElement("tr");
        //l'id de la colone est égale a l'id du de l'admin
        tr.id = id;
        //création des lignes du tableau
        let td = document.createElement("td");
        // création d'un objet image
        let img = new Image();
        //source de l'image
        img.src = "../img/supprimer.png";
        //placement de l'image
        img.style.marginLeft = '20px';
        //l'id de l'image est = à l'id du membre
        img.id = id;
        //lorsqu'on clique sur l'image la fonction confirmerSuppression se lance
        // avec en parametre l'id du membre
        img.onclick = function () {
            confirmerSuppression(id)
        };
        //ajout de l'image dans le tableau
        td.appendChild(img);
        tr.appendChild(td);

        //ajout du nom dans le tableau
        td = document.createElement("td");
        td.innerText = admin.nom;
        tr.appendChild(td);

        //ajout du prenom dans le tableau
        td = document.createElement("td");
        td.innerText = admin.prenom;
        tr.appendChild(td);

        lesLignes.appendChild(tr);
    }

}

function confirmerSuppression(id) {

    let n = new Noty({
        text: 'Confirmer la demande de suppression ',
        layout: 'center',
        theme: 'sunset',
        modal: true,
        type: 'info',
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


function ajouter() {
    msg.innerHTML = '';
    //ajout de l'id du membre dans la table administrateur
    $.ajax({
        url: 'ajax/ajouter.php',
        type: 'POST',
        data: {
            id: id
        },
        dataType: "json",
        error: erreurAjax,
        success: function () {
            lesLignes.innerHTML = '';
            //rechargement du tableau des administrateur
            $.getJSON("ajax/getlesadmins.php", afficher).fail(erreurAjax);
            nomR.value = '';
            id=null;
            //il faut mettre à jour le tableau les membres comme source de l'auto completion
            // Il faut récuperer l'indice de la ligne a partir de l'id du membre
            let i = lesMembres.findIndex(x => x.id === id);
            lesMembres.splice(i, 1);
        }
    })
}

function controleAvantAjout(){
    if(id !== null){
        ajouter()
    }else{
        Std.beep()
    }
}


function supprimer(id) {
    //supprimer les administrateur et donc tout leurs droits
    $.ajax({
        url: 'ajax/supprimer.php',
        type: 'POST',
        data: {id: id},
        dataType: "json",
        error: erreurAjax,
        success: function () {
            let ligne = document.getElementById(id);
            ligne.parentNode.removeChild(ligne);
            //on doit regénérer le tableau lesMembre
            $.getJSON("ajax/getlesmembres.php", remplirEAC).fail(erreurAjax);

        }
    })
}

