<?php

/**
 * Classe Controle : Classe statique permettant le contrôle des données saisies
 * 
 * @Author : Guy Verghote
 * @Version 1.2
 * @Date : 04/09/2020
 */

class Controle
{

    /**
     * Vérifie l'existence des variables passées par POST ou GET
     * Accepte un nombre variable de paramètres qui représentent les variables dont il faut vérifier l'existence
     * Exemple d'appel : if (!Controle::existe('id', 'nom', 'prenom')) {...}
     * @return boolean vrai si toutes les clés existent dans le tableau
     */

    static public function existe()
    {
        foreach (func_get_args() as $unChamp) {
            if (!isset($_POST[$unChamp])) {   //$_REQUEST
                return false;
            }
        }
        return true;
    }

    /**
     * Suppression des espaces superflus à l'intérieur et aux extrémités d'un chaine.
     * @param string $unChamp chaîne à transformer
     * @return string
     */

    static public function supprimerEspace($unChamp)
    {
        return preg_replace("#[[:space:]]{2,}#", " ", trim($unChamp));
    }

    /**
     * Contrôle si la valeur du champ respecte le motif accepté par ce champ
     * la fonction est bloquante : si le format n'existe pas la fonction retourne 0
     * @param string $unChamp valeur à controler
     * @param string $format format à respecter
     * @return boolean vrai si le champ $valeur respecte le format $format
     */

    static public function formatValide($valeur, $format)
    {
        $correct = false;
        switch ($format) {
            case 'login':
                // lettre chiffre  tiret et _
                $correct = preg_match("/^[a-z0-9_-]*$/i", $valeur);
                break;
            case 'nom':
                // lettre majuscule et espace uniquement
                $correct = preg_match("/^[A-Z]([A-Z ]*[A-Z])*$/", $valeur);
                break;
            case 'nom2':
                // lettre espace tiret apostrophe
                $correct = preg_match("/^[a-z]([a-z '-]*[a-z])*$/i", $valeur);
                break;
            case 'nomAvecAccent':
                // lettre espace tiret apostrophe
                $correct = preg_match("/^[a-z\s'àáâãäåòóôõöøèéêëçìíîïùúûüÿñ-]*$/i", $valeur);
                break;
            case 'description':
                // lettre espace tiret apostrophe et chiffre
                $correct = preg_match("/^[a-zA-Z\s'àáâãäåòóôõöøèéêëçìíîïùúûüÿñ-]*$/i", $valeur);
                break;
            case 'email':
                $correct = preg_match("/^[0-9a-z]([-_.]?[0-9a-z])*@[0-9a-z]([-_.]?[0-9a-z])*\.[a-z]{2,4}$/i", $valeur);
                break;
            case 'entier':
                $correct = preg_match("/^[0-9]*$/", $valeur);
                break;
            case 'reel':
                $correct = preg_match("/^[-+]?[0-9]+(\.[0-9]+)?$/", $valeur);
                break;
            case 'tel':
                $correct = preg_match("/^([0][1-9]([. ]?[0-9]{2}){4})?$/", $valeur);
                break;
            case 'dateFr':
                $correct = preg_match('`^([0-9]{2})[-/.]([0-9]{2})[-/.]([0-9]{4})$`', $valeur, $tdebut);
                if ($correct) {
                    $correct = checkdate($tdebut[2], $tdebut[1], $tdebut[3]) && ($tdebut[3] > 1900);
                }
                break;
            case 'dateMysql':
                $correct = preg_match('`^([0-9]{4})-([0-9]{2})-([0-9]{2})$`', $valeur, $tdebut);
                if ($correct) {
                    $correct = checkdate($tdebut[2], $tdebut[3], $tdebut[1]) && ($tdebut[1] >= 1900);
                }
                break;
            case 'temps' : // [hh]:mm:ss autres séparateurs . ou ,
                $correct = preg_match("/^([0-9]{1,2}[.,:]?)?[0-5][0-9][.,:]?[0-5][0-9]$/", $valeur);
                break;
            case 'nomFichier':
                $correct = preg_match("/^[A-Z0-9 .-]*$/", $valeur);
                break;
            case 'nomImage':
                $correct = preg_match("/^[a-z0-9 -]*$/", $valeur);
                break;
            case 'url': // modification du 10/03/2015 ajout du . dans []
                $correct = preg_match("`((http://|https://)?(www.)?(([a-zA-Z0-9-]){2,}\.){1,4}([a-zA-Z]){2,6}(/([a-zA-Z-_/.0-9#:?=&;,]*)?)?)`", $valeur);
                // $correct = preg_match("`((http:\/\/|https:\/\/)?(www.)?(([a-zA-Z0-9-]){2,}\.){1,4}([a-zA-Z]){2,6}(\/([a-zA-Z-_\/\.0-9#:?=&;,]*)?)?)`", $valeur);
                break;
            default :
                // si on contrôle un motif inexistant on bloque !
                $correct = false;
        }
        return $correct;
    }
}
