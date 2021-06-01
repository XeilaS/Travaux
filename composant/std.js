// Classe static comprenant un ensemble de méthode standard au niveau affichage, conversion
// Version : 2020.5
// Date mise à jour : 18/08/2020

class Std {

// -----------------------------------------------------------
// Fonctions d'affichage
// ------------------------------------------------------------

    /**
     * Génération d'un message dans une mise en forme bootstrap (class='alert alert-dismissible')
     * Nécessite le composant bootstrap avec la partie js
     * @param {string} texte à afficher.
     * @param {string} couleur de fond : vert, rouge ou orange
     * @return {string} Chaîne au format HTML
     */

    static genererMessage(texte, couleur = '') {
        // détermination de la classe bootstrap à utiliser en fonction de la couleur choisie
        let code;
        if (couleur === 'vert') code = '#1FA055';
        else if (couleur === 'rouge') code = '#C60800';
        else if (couleur === 'orange') code = '#FF7415';
        let resultat = "<div class='alert alert-dismissible fade show' style='color : white; background-color : " + code + "' role='alert'>";
        resultat += texte;
        resultat += "<button type='button' class='close' data-dismiss='alert' aria-label='Close'>";
        resultat += " <span aria-hidden='true'>&times;</span></button></div>";
        return resultat;
    }

    /**
     * Affiche un message dans une fenêtre modale 'Noty'
     * Nécessite le composant noty
     * @param {object} parametre doit contenir les propriétés suivantes
     * <br> message : message à afficher
     * <br>type : [facultatif] alert, success, error (défaut), warning, info
     * <br>position : [facultatif] top, topLeft, topCenter, topRight, center (center), centerLeft, centerRight, bottom, bottomLeft, bottomCenter, bottomRight
     * <br>fermeture :[facultatif] 0 (défaut) la fenêtre disparait automatiquement, 1 il faut cliquer dans la fenêtre pour la fermer
     * <br>surFermeture : [facultatif] fonction à lancer après l'affichage
     *  <br>delai : [facultatif] delai avant la fermenure automatique de la fenêtre
     */

    static afficherMessage(parametre) {
        let type = (parametre.type) ? parametre.type : 'error';
        let position = (parametre.position) ? parametre.position : 'center'
        let fermeture = (parametre.fermeture) ? parametre.fermeture : 0;
        let delai = (parametre.delai) ? parametre.delai : 500;
        if (fermeture === 1) {
            let n = new Noty({
                text: parametre.message,
                type: type,
                modal: true,
                killer: true,
                layout: position,
                theme: 'sunset',
                buttons: [
                    Noty.button('Ok', 'btn btn-sm btn-info float-right mt-0 mb-1', function () {
                        n.close();
                        if (parametre.surFermeture) parametre.surFermeture();
                    })],
                animation: {
                    open: 'animated lightSpeedI',
                    close: 'animated lightSpeedOut'
                },
            }).show();
        } else {
            let n = new Noty({
                text: parametre.message,
                type: type,
                modal: true,
                layout: position,
                theme: 'sunset',
                animation: {
                    open: 'animated lightSpeedI',
                    close: 'animated lightSpeedOut'
                },
                callbacks: {
                    onClose: parametre.surFermeture
                }
            }).show().setTimeout(delai);
        }
    }

// ------------------------------------------------------------
// fonctions diverses de conversion et mise en forme
// ------------------------------------------------------------

    /**
     * Conversion d'une chaine de format jj/mm/aaaa au format aaaa-mm-jj
     * @param {string} date au format jj/mm/aaaa
     * @return {string} Chaîne au aaaa-mm-jj
     */

    static encoderDate(date) {
        return date.substr(6) + '-' + date.substr(3, 2) + '-' + date.substr(0, 2);
    }

    /**
     * Conversion d'une chaine de format aaaa-mm-jj  au format jj/mm/aaaa
     * @param {string} date au format aaaa-mm-jj
     * @return {string} Chaîne au jj/mm/aaaa
     */

    static decoderDate(date) {
        return date.substr(8) + '/' + date.substr(5, 2) + '/' + date.substr(0, 4);
    }



    /**
     * Retourne la chaine passée en paramètre avec la première lettre de chaque mot en majuscule
     * @param {string} nom
     * @return {string} avec la première lettre de chaque mot en majuscule
     */
    static ucWord(nom) {
        let resultat = "";
        if (nom.trim().length > 0) {
            let lesMots = nom.trim().split(" ");
            for (let mot of lesMots)
                if (mot.length >= 2)
                    resultat += mot[0].toUpperCase() + mot.substr(1).toLowerCase() + " ";
                else if (mot.length === 1)
                    resultat += mot[0].toUpperCase()  + " ";
            resultat = resultat.substr(0, resultat.length - 1);
        }
        return resultat;
    }

//
    /**
     * Retourne la valeur passée en paramètre dans le format monétaire
     * @param {number} valeur
     * @return {string}
     */
    static formatMonetaire(valeur) {
        return new Intl.NumberFormat("fr-FR", {style: "currency", currency: "EUR"}).format(valeur);
    }

    /**
    *  Conversion d'un nombre exprimé en octet en ko, Mo ou Go
    *  @param {number} nb nombre représentant un nombre d'octets
    *  @param {string} unite unité souhaitée : Ko Mo ou Go
    *  @return {string}  nombre exprimé dans l'unité avec une mise en forme par groupe de 3
    */
    static conversionOctet(nb, unite = 'o') {
        let diviseur = 1;
        if (unite === "Ko" ) diviseur = 1024;
        else if (unite === "Mo") diviseur = 1024 * 1024;
        else if (unite === "Go") diviseur  = 1024 * 1024 * 1024;
        let str = Math.round(nb / diviseur).toString();
        let result = str.slice(-3);
        str = str.substring(0, str.length - 3);  // sans les trois derniers
        while (str.length > 3) {
            let elt = str.slice(-3);
            result = elt.concat(" ", result);
            str = str.substring(0, str.length - 3);
        }
        result = str.concat(" ", result, " ", unite);
        return result;
    }

    //
    // https://stackoverflow.com/questions/18251399/why-doesnt-encodeuricomponent-encode-single-quotes-apostrophes

    /**
     *  Encoder les apostrophes dans une chaîne
     *  @param {string} str
     *  @return {string}
     */

    static encoder(str) {
        return encodeURIComponent(str).replace(/[!'()*]/g, function (c) {
            return '%' + c.charCodeAt(0).toString(16);
        });
    }

    /**
     *  récupération des paramètres GET passée dans l'url de la page ?nom=valeur&nom=valeur...
     *  @return {array} Tableau associatif
     */
    static getLesParametresUrl() {
        // Search retourne ?nom=valeur&nom=valeur...
        let lesCouplesNomValeur = location.search.substring(1).split('&');
        let lesParametres = [];
        for (const i in lesCouplesNomValeur) {
            let lesCouples = lesCouplesNomValeur[i].split('=');
            lesParametres[lesCouples[0]] = lesCouples[1];
        }
        return lesParametres;
    }

    /**
     *  emission d'un bip sonore
     */

    static beep() {
        let snd = new Audio("data:audio/wav;base64,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qJrx4KOQjahZxWbcZgztj2c49nKmkId44S71j0c8eV9yDK6uPRzx5X18eDvjvQ6yKo9ZSS6l//8elePK/Lf//IInrOF/FvDoADYAGBMGb7FtErm5MXMlmPAJQVgWta7Zx2go+8xJ0UiCb8LHHdftWyLJE0QIAIsI+UbXu67dZMjmgDGCGl1H+vpF4NSDckSIkk7Vd+sxEhBQMRU8j/12UIRhzSaUdQ+rQU5kGeFxm+hb1oh6pWWmv3uvmReDl0UnvtapVaIzo1jZbf/pD6ElLqSX+rUmOQNpJFa/r+sa4e/pBlAABoAAAAA3CUgShLdGIxsY7AUABPRrgCABdDuQ5GC7DqPQCgbbJUAoRSUj+NIEig0YfyWUho1VBBBA//uQZB4ABZx5zfMakeAAAAmwAAAAF5F3P0w9GtAAACfAAAAAwLhMDmAYWMgVEG1U0FIGCBgXBXAtfMH10000EEEEEECUBYln03TTTdNBDZopopYvrTTdNa325mImNg3TTPV9q3pmY0xoO6bv3r00y+IDGid/9aaaZTGMuj9mpu9Mpio1dXrr5HERTZSmqU36A3CumzN/9Robv/Xx4v9ijkSRSNLQhAWumap82WRSBUqXStV/YcS+XVLnSS+WLDroqArFkMEsAS+eWmrUzrO0oEmE40RlMZ5+ODIkAyKAGUwZ3mVKmcamcJnMW26MRPgUw6j+LkhyHGVGYjSUUKNpuJUQoOIAyDvEyG8S5yfK6dhZc0Tx1KI/gviKL6qvvFs1+bWtaz58uUNnryq6kt5RzOCkPWlVqVX2a/EEBUdU1KrXLf40GoiiFXK///qpoiDXrOgqDR38JB0bw7SoL+ZB9o1RCkQjQ2CBYZKd/+VJxZRRZlqSkKiws0WFxUyCwsKiMy7hUVFhIaCrNQsKkTIsLivwKKigsj8XYlwt/WKi2N4d//uQRCSAAjURNIHpMZBGYiaQPSYyAAABLAAAAAAAACWAAAAApUF/Mg+0aohSIRobBAsMlO//Kk4soosy1JSFRYWaLC4qZBYWFRGZdwqKiwkNBVmoWFSJkWFxX4FFRQWR+LsS4W/rFRb/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////VEFHAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAU291bmRib3kuZGUAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAMjAwNGh0dHA6Ly93d3cuc291bmRib3kuZGUAAAAAAAAAACU=");
        snd.play();
    }
}
