"use strict";

window.onload = init;

/**
 * fonction d'initialisation,
 * cette derniére vas renvoyer a la fonction afficher pour afficher les cartes de la pages.
 * ou, si un probléme est rencontrée, vers la fonction erreurAjax.
 *
 */
function init () {
    //récupére les données dans la table lien
    $.getJSON("ajax/getlesliens.php", afficher).fail(erreurAjax);
}

//stocke les données de la table lien dans des cartes bootstrap
function afficher(data) {
    for (const lien of data) {
        /**
         * création de la carte
         */
        let carte = document.createElement('div');
        carte.classList.add('card');
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
        entete.innerText = lien.nom;
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
        img.src = 'logo/' + lien.logo;
        img.style.width = "150px";
        // img.style.height = "150px";
        img.alt = "";
        corps.appendChild(img);

        carte.appendChild(corps);
        /**
         * pieds de pages
         */
        let pied = document.createElement('div');
        pied.classList.add('card-footer');
        pied.classList.add('text-muted');
        pied.classList.add('text-center');
        pied.innerHTML = lien.description ;
        carte.appendChild(pied);
        /**
         * liens
         */
        let liens = document.createElement('a');
        liens.classList.add('btn');
        liens.classList.add('btn-info');
        liens.classList.add('btn-lg');
        liens.classList.add('btn-block');
        liens.href = lien.url;
		liens.target = 'photo';
        liens.innerText = "visiter ce site";
        carte.appendChild(liens);

        lesCartes.appendChild(carte);
    }
}
