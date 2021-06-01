"use strict";

window.onload = init;

// déclaration des variables globales
let email;
let password;
let passwordConfirm;

// Tableau contenant le nom de tout les membres
let lesMembres = [];

// Booleen pour savoir si le nom a rentrer dans le champ nom est disponible ou si il est déjà utilisé dans la bd (=>tableau les Membres)
let estDisponible;

function init() {

    $.getJSON("ajax/getdonnees.php", remplirDonnees).fail(erreurAjax);

    // attribution des variables
    email = document.getElementById('email');
    password = document.getElementById('password');
    passwordConfirm = document.getElementById('passwordConfirm');

    // gestionnaire d'evenements

    // Evenements sur le champ Nom
    // On lance la recherche du nom (rechercherNom) a la séléction du champ et a chaque frappe dans le champ
    // Si le nom existe déjà, on fait apparaitre le message 'Ce nom existe déjà' en dessous du btnAjouter
    nom.onfocus = rechercherNom;

    nom.onblur = function (){
        nom.style.color = '#000000';
        nom.style.backgroundColor = 'white';
    };

    nom.onkeyup = function(){
        if (rechercherNom() == 1){
            transition.begin(message, [
                ["transform", "scale(0)", "scale(1)", "0.5s", "ease-in-out"],
                ["color", "red", "red", "0s", "linear"],
            ]);
        }
    };


    // Evenements sur le champ Email
    email.onkeyup = function (){
        iconeDeControle(email, emailCheck, email.checkValidity(), false)
    };

    email.onfocus = function(){
        iconeDeControle(email, emailCheck, email.checkValidity(),false)
    };

    email.onblur = function () {
        email.style.color = '#000000';
        email.style.backgroundColor = 'white';
    };


    // Evenements sur le champ Password
    password.onkeyup = function (){
        iconeDeControle(password, passwordCheck, password.checkValidity(),false);
        if (password.checkValidity() == true){
            passwordConfirm.disabled = false;
            passwordConfirm.style.color = '#000000';
            passwordConfirm.style.backgroundColor = 'white';
            iconeDeControle(null, passwordConfirmCheck, controleValeur(passwordConfirm, password),false);
        }
        else {
            passwordConfirm.style.backgroundColor = 'lightgrey';
            passwordConfirm.disabled = true;
            passwordConfirmCheck.innerHTML = "";
        }
    };

    password.onfocus = function(){
        iconeDeControle(password, passwordCheck, password.checkValidity(),false);
    };

    password.onblur = function () {
        if (password.checkValidity() == true){
            passwordConfirm.disabled = false;
        }
        password.style.color = '#000000';
        password.style.backgroundColor = 'white';
    };


    // Evenements sur le champ PasswordConfirm
    passwordConfirm.style.backgroundColor = 'lightgrey';
    passwordConfirm.disabled = true;

    passwordConfirm.onkeyup = function (){
        iconeDeControle(passwordConfirm, passwordConfirmCheck, controleValeur(passwordConfirm, password),false);
    };

    passwordConfirm.onfocus = function(){
        iconeDeControle(passwordConfirm, passwordConfirmCheck, controleValeur(passwordConfirm, password),false);
    };

    passwordConfirm.onblur = function () {
        passwordConfirm.style.color = '#000000';
        passwordConfirm.style.backgroundColor = 'white';
    };


    // Evenements sur le champ PasswordConfirm
    // Si le montant est négatif, on affiche une fenêtre demandant confirmation
    montant.onblur = function(){
        if (Math.sign(montant.value) == -1){
            let n = new Noty({
                text: '<p>Êtes vous sûr de vouloir utiliser un montant négatif?</p>',
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
                        n.close();
                    }),
                    Noty.button('Non', 'btn btn-sm btn-danger w-50', function () {
                        n.close();
                        montant.value = 0
                    })
                ]
            }).show();
        }
    };


    // Evenements sur le btnAjouter
    // Vérification de la validité de tous les champs précedents
    // Si tout est valide, on lance la fonction de confirmation qui ouvre une fenêtre récapitulant les données à insérer dans la bd
    btnAjouter.onclick = function (){
        if (nom.value == '' || estDisponible == false){
            iconeDeControle(null, nomCheck, estDisponible,true);
        }
        if (email.value == '' || email.checkValidity() == false){
            iconeDeControle(null, emailCheck, email.checkValidity(),true);
        }
        if (password.value == '' || password.checkValidity() == false){
            iconeDeControle(null, passwordCheck, password.checkValidity(),true);
        }
        if (passwordConfirm.value == '' || controleValeur(passwordConfirm, password) == false){
            if (password.checkValidity() == false){
                passwordConfirmCheck.innerHTML ='';
            }
            else {
                iconeDeControle(null, passwordConfirmCheck, false,true);
            }
        }
        if (email.checkValidity() == true && password.checkValidity() == true && controleValeur(passwordConfirm, password) == true && estDisponible == true){
            if (nom.value == ''){
                nom.value = 'Non renseigné';
                nom.style.color = 'red'
            }
            if (prenom.value == ''){
                prenom.value = 'Non renseigné';
                prenom.style.color = 'red'
            }
            confirmerAjout();
        }
    }
}

// Rempli le tableau lesMembres pour chaques membres de la bd
function remplirDonnees(data){
    for (const membre of data){
        lesMembres.push(membre.nom)
    }
}


function confirmerAjout() {
    let n = new Noty({
        text: '<p>Êtes vous sûr de vouloir ajouter ce membre?</p>' +
            'Nom : ' + nom.value + '</br>' +
            'Prenom : ' + prenom.value + '</br>' +
            'Montant : ' + montant.value + ' €' + '</br>' +
            'Adresse e-mail : ' + email.value + '</br>' +
            'Mot de passe : ' + password.value + '</br>',
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
                n.close();
                // affiche "non renseigné" si le nom n'est pas renseigné. Si l'utilisateur valide l'action, la valeur du nom reprend "" pour l'insertion dans la bd
                if (prenom.value == 'Non renseigné'){
                    prenom.value = ''
                }
                ajouter();
            }),
            Noty.button('Non', 'btn btn-sm btn-danger w-50', function () {
                n.close();
            })
        ]
    }).show();
}

function ajouter() {
    $.ajax({
        url: 'ajax/ajouter.php',
        type: 'POST',
        data: {
            nom: nom.value,
            prenom: prenom.value,
            email: email.value,
            montant: montant.value,
            password: password.value,
        },
        dataType: "json",
        error: erreurAjax,
        success: function (data) {
            if (data == 1)
                Std.afficherMessage({ message : "Membre Ajouté", type : 'success', position : 'topRight' });
			nom.value = '';
            prenom.value = '';
            montant.value = 0;
            email.value = '';
            password.value = '';
            passwordConfirm.value = '';
            passwordConfirm.style.backgroundColor = 'lightgrey';
            passwordConfirm.disabled = true;
            nomCheck.innerHTML = '';
            emailCheck.innerHTML = '';
            passwordCheck.innerHTML = '';
            passwordConfirmCheck.innerHTML = '';
        }
    })
}


// ------------------- Autres fonctions ------------------- //

function rechercherNom() {
    nom.value = nom.value.toUpperCase();

    for (const membre of lesMembres){
        if (nom.value == membre){
            message.innerHTML = 'Ce nom est déjà utilisé';
            iconeDeControle(nom, nomCheck, false,false);
            estDisponible = false;
            return 1;
            break;
        }
        else if(nom.value ==''){
            iconeDeControle(nom, nomCheck, false,false);
            estDisponible = false;
            break;
        }
        else{
            iconeDeControle(nom, nomCheck, true,false);
            estDisponible = true;
            message.innerText = "";
        }
    }
}

