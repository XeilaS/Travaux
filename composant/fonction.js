function miseEnPage() {
    transition.begin(corps, [
        ["transform", "translateY(400px)", "translateY(0px)", "2s", "ease-out"],
    ]);
    pied.style.visibility = "visible";
}


function erreurAjax(request) {
    msg.innerHTML = Std.genererMessage(request.responseText, 'rouge');
}


/* -------- Controle par la Valeur  ---------*/
function controleValeur(champ, champAControler) {
    return champ.value === champAControler.value;
}

/* -------- Icone de controle  ---------*/
// Valeur que peuvent prendre les parametres :
    // divChamp : id du champ (affecte au champ sélectionné la couleur du parametre couleur) / null (n'affecte pas la couleur du champ sélectionné)
    // divIcone : id de la box ou se situe l'icone. Ne peut pas etre null
    // condition : condition à vérifier (ex: x.value == y.value) / false (est tout le temps faux) / true (est tout le temps vrai)
    // estRepete : false (l'animation de l'icone ne sera pas répétée si l'ancienne icone est la meme que la nouvelle) / true (l'animation l'icone sera toujours répetée)
    // durée :  durée de l'animation (ex : "1.5s")
    // taille :  taille des icones (ex : 1.5)
    // couleurVrai :  couleur de l'icone et du champ (si divChamp != null) si la condition est vrai
    // couleurFaux :  couleur de l'icone et du champ (si divChamp != null) si la condition est fausse
function iconeDeControle(divChamp, divIcone, condition, estRepete, duree, taille, couleurVrai, couleurFaux) {
    if (duree == null) {
        duree = "1s"
    }
    if (taille == null){
        taille = 1.5
    }
    if (couleurVrai == null){
        couleurVrai = '#32CD32'
    }
    if (couleurFaux == null){
        couleurFaux = '#FF4500'
    }
    if (divChamp !== null) {
        divChamp.style.color = '#f8f9fa';
        divChamp.style.transition = duree;
        if (estRepete == true) {
            if (condition === true) {
                if (divIcone.innerHTML == "" || divIcone.innerHTML == '<i class="fa fa-times-circle m-auto" aria-hidden="true"></i>') {
                    divIcone.innerHTML = '<i class="fa fa-check-circle m-auto" aria-hidden="true"></i>';
                    divChamp.style.backgroundColor = couleurVrai;
                    transition.begin(divIcone, [
                        ["transform", "scale(0)", "scale("+ taille +")", duree, "ease-in-out"],
                        ["color", "white", couleurVrai, duree, "linear"],
                    ])
                } else {
                    divIcone.innerHTML = '<i class="fa fa-check-circle m-auto" aria-hidden="true"></i>';
                    divChamp.style.backgroundColor = couleurVrai;
                }
            } else {
                if (divIcone.innerHTML == "" || divIcone.innerHTML === '<i class="fa fa-check-circle m-auto" aria-hidden="true"></i>') {
                    divIcone.innerHTML = '<i class="fa fa-times-circle m-auto" aria-hidden="true"></i>';
                    divChamp.style.backgroundColor = couleurFaux;
                    transition.begin(divIcone, [
                        ["transform", "scale(0)", "scale("+ taille +")", duree, "ease-in-out"],
                        ["color", "white", couleurFaux, duree, "linear"],
                    ])
                } else {
                    divIcone.innerHTML = '<i class="fa fa-times-circle m-auto" aria-hidden="true"></i>';
                    divChamp.style.backgroundColor = couleurFaux;
                    transition.begin(divIcone, [
                        ["transform", "scale(0)", "scale("+ taille +")", duree, "ease-in-out"],
                        ["color", "white", couleurFaux, duree, "linear"],
                    ])
                }
            }
        } else {
            if (condition == true) {
                if (divIcone.innerHTML == "" || divIcone.innerHTML == '<i class="fa fa-times-circle m-auto" aria-hidden="true"></i>') {
                    divIcone.innerHTML = '<i class="fa fa-check-circle m-auto" aria-hidden="true"></i>';
                    divChamp.style.backgroundColor = couleurVrai;
                    transition.begin(divIcone, [
                        ["transform", "scale(0)", "scale("+ taille +")", duree, "ease-in-out"],
                        ["color", "white", couleurVrai, duree, "linear"],
                    ])
                } else {
                    divIcone.innerHTML = '<i class="fa fa-check-circle m-auto" aria-hidden="true"></i>';
                    divChamp.style.backgroundColor = couleurVrai;
                }
            } else {
                if (divIcone.innerHTML == "" || divIcone.innerHTML == '<i class="fa fa-check-circle m-auto" aria-hidden="true"></i>') {
                    divIcone.innerHTML = '<i class="fa fa-times-circle m-auto" aria-hidden="true"></i>';
                    divChamp.style.backgroundColor = couleurFaux;
                    transition.begin(divIcone, [
                        ["transform", "scale(0)", "scale("+ taille +")", duree, "ease-in-out"],
                        ["color", "white", couleurFaux, duree, "linear"],
                    ])
                } else {
                    divIcone.innerHTML = '<i class="fa fa-times-circle m-auto" aria-hidden="true"></i>';
                    divChamp.style.backgroundColor = couleurFaux;
                }
            }
        }
    } else {
        if (estRepete == true) {
            if (condition === true) {
                if (divIcone.innerHTML == "" || divIcone.innerHTML == '<i class="fa fa-times-circle m-auto" aria-hidden="true"></i>') {
                    divIcone.innerHTML = '<i class="fa fa-check-circle m-auto" aria-hidden="true"></i>';
                    transition.begin(divIcone, [
                        ["transform", "scale(0)", "scale("+ taille +")", "1s", "ease-in-out"],
                        ["color", "white", couleurVrai, duree, "linear"],
                    ])
                } else {
                    divIcone.innerHTML = '<i class="fa fa-check-circle m-auto" aria-hidden="true"></i>';
                }
            } else {
                if (divIcone.innerHTML == "" || divIcone.innerHTML === '<i class="fa fa-check-circle m-auto" aria-hidden="true"></i>') {
                    divIcone.innerHTML = '<i class="fa fa-times-circle m-auto" aria-hidden="true"></i>';
                    transition.begin(divIcone, [
                        ["transform", "scale(0)", "scale("+ taille +")", duree, "ease-in-out"],
                        ["color", "white", couleurFaux, duree, "linear"],
                    ])
                } else {
                    divIcone.innerHTML = '<i class="fa fa-times-circle m-auto" aria-hidden="true"></i>';
                    transition.begin(divIcone, [
                        ["transform", "scale(0)", "scale("+ taille +")", duree, "ease-in-out"],
                        ["color", "white", couleurFaux, duree, "linear"],
                    ])
                }
            }
        } else {
            if (condition == true) {
                if (divIcone.innerHTML == "" || divIcone.innerHTML == '<i class="fa fa-times-circle m-auto" aria-hidden="true"></i>') {
                    divIcone.innerHTML = '<i class="fa fa-check-circle m-auto" aria-hidden="true"></i>';
                    transition.begin(divIcone, [
                        ["transform", "scale(0)", "scale("+ taille +")", duree, "ease-in-out"],
                        ["color", "white", couleurVrai, duree, "linear"],
                    ])
                } else {
                    divIcone.innerHTML = '<i class="fa fa-check-circle m-auto" aria-hidden="true"></i>';
                }
            } else {
                if (divIcone.innerHTML == "" || divIcone.innerHTML == '<i class="fa fa-check-circle m-auto" aria-hidden="true"></i>') {
                    divIcone.innerHTML = '<i class="fa fa-times-circle m-auto" aria-hidden="true"></i>';
                    transition.begin(divIcone, [
                        ["transform", "scale(0)", "scale("+ taille +")", duree, "ease-in-out"],
                        ["color", "white", couleurFaux, duree, "linear"],
                    ])
                } else {
                    divIcone.innerHTML = '<i class="fa fa-times-circle m-auto" aria-hidden="true"></i>';
                }
            }
        }
    }
}