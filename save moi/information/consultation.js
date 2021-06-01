"use strict";

/*

Objectifs :
    Consultation d'une information récente

Tables utilisées :
    information(id, titre, contenu, dateCreation, auteur, idType)

Appels Ajax :
    ajax/getinformationbyidtype.php : chargement des infromations en fonction
        type d'information passé en paramètre dans l'URL dans la base de données MySQL

Remarque :
    Le filtre ce fait sur les 2 derniers mois
    le paramètre est le suitant: ?idType="Votre ID"

*/

window.onload = init;

function init () {
    miseEnPage();
    //Chargement des données en fonction du paramètre passé, puis affichage des donnnées via la fontion afficher.
    $.getJSON("ajax/getinformationbyidtype.php" + document.location.search, afficher).fail(erreurAjax);
}

function afficher(data) {
    // affichage des informations par rapport au données data chargée précédément
    if (data.length > 0) {
        for (let information of data) {
            let carte = document.createElement('div');
            carte.classList.add("card", "border-dark", "bg-white", "mb-3");
            let entete = document.createElement('div');
            entete.classList.add("card-header", "text-primary");
            entete.style.fontSize="1.2rem";
            let titre = document.createTextNode(information.titre)
            entete.appendChild(titre);

            // ajouter un icône pour fermer ou ouvrir le corps
            let baliseI = document.createElement('i');
            baliseI.classList.add("fas", "fa-angle-down", "float-right");
            entete.appendChild(baliseI);

            let conteneur = document.createElement('div');
            conteneur.style.display = "none"
            entete.onclick = function () {
                onOff(conteneur, baliseI)
            };

            let p = document.createElement('p');
            p.style.paddingLeft = '10px';
            p.innerHTML = information.contenu
            conteneur.appendChild(p);
            p = document.createElement('p');
            p.classList.add("font-italic", "small", "ml-3");
            p.innerText = 'Publié le ' + information.date + ' par ' + information.auteur;
            conteneur.appendChild(p);
            if (information.fichier === 1) {
                let baliseA = document.createElement('a');
                baliseA.innerText = "Cliquez ici pour visualiser le document joint "
                baliseA.href = '../../document/info' + information.id + '.pdf';
                baliseA.target = 'pdf';
                baliseA.classList.add('btn', 'btn-primary', "m-3");
                conteneur.appendChild(baliseA);
            }
            carte.append(entete);
            carte.append(conteneur);

            liste.appendChild(carte);
        }
        informationRecente.style.display = 'block'
    }
}


function onOff(corps, baliseI) {
    if (corps.style.display === "none") {
        corps.style.display = "block"
        baliseI.classList.remove("fas", "fa-angle-down");
        baliseI.classList.add("far", "fa-window-close");
    } else {
        corps.style.display = "none"
        baliseI.classList.remove("far", "fa-window-close");
        baliseI.classList.add("fas", "fa-angle-down");
    }
}



