// Classe comprenant un ensemble de méthodes statique concernant le contrôle des données saisies
// Version : 2020.6
// Date mise à jour : 23/12/2020


class Ctrl {

    /**
     * Contrôle la valeur d'un champ
     * à utiliser dans le cadre d'un ajout ou d'une modification en mode formulaire
     * condition : balise div après le champ possédant la classe 'erreur' définie
     * @param {object} champ doit pointer la balise input
     * @returns {boolean}
     */
    static controler(champ) {
        if (champ.checkValidity()) {
            champ.classList.remove('erreur');
            champ.classList.add('correct');
            champ.nextElementSibling.innerText = '';
            return true;
        } else {
            champ.classList.remove('correct');
            champ.classList.add('erreur');
            champ.nextElementSibling.innerText = champ.validationMessage;
            return false;
        }
    }

    /**
     * à utiliser dans le cadre d'une modification en mode tableau
     * vérifie que le champ est correctement rempli
     * si la valeur n'a pas changé on réinitialise la mise en forme
     * En cas d'erreur application de la classe correct
     * En absence d'erreur application de la classe erreur.
     * @param {object} champ
     * @returns {boolean}
     */
    static verifier(champ) {
        if (champ.value === champ.dataset.old) {
            champ.classList.remove('erreur');
            champ.classList.remove('correct');
            return false;
        } else if (champ.checkValidity()) {
            champ.classList.remove('erreur');
            champ.classList.add('correct');
            return true;
        } else {
            champ.classList.remove('correct');
            champ.classList.add('erreur');
            return false;
        }
    }


    /**
     * Vérifie si l'objet file possède une extension et un type mime autorisés
     * @param {object} parametre
     * parametre doit contenir les propriétés suivantes :
     * <br> file : objet file à contrôler
     * <br> lesExtensions : [Facultatif] tableau contenant les extensions autorisées
     * <br> lesTypes : [Facultatif] tableau contenant les types mimes autorisés
     * <br> taille : [Facultatif] Taille maximale en Mo du fichier
     * <br> success : [Facultatif] fonction à lancer si le champ est valide
     * <br> error : [Facultatif] fonction à lancer si le champ n'est pas valide : parametre implicite reponse contenant le message d'erreur
     * @returns {boolean}
     */
    static fichierValide(parametre) {
        let reponse = '';
        if (parametre.file === undefined) {
            reponse = 'Aucun fichier transmis'
        } else {
            let file = parametre.file;
            let taille = file.size;
            if (parametre.taille && taille > parametre.taille) {
                reponse = "La taille du fichier dépasse la taille autorisée";
            } else if (parametre.lesExtensions) {
                let eltFichier = file.name.split('.');
                let extension = eltFichier[eltFichier.length - 1].toLowerCase();
                if (parametre.lesExtensions.indexOf(extension) === -1) {
                    reponse = "Extension non acceptée"
                } else if (parametre.type && parametre.lesTypes.indexOf(file.type) === -1) {
                    reponse = "Type non accepté";
                }
            } else if (parametre.type && parametre.lesTypes.indexOf(file.type) === -1) {
                reponse = "Type non accepté";
            }
        }
        if (reponse === '') {
            if (parametre.success) parametre.success();
            return true;

        } else {
            if (parametre.error) parametre.error(reponse);
            return false;
        }
    }
}