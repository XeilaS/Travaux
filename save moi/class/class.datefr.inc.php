<?php
/**
 * Classe permettant de gérer des dates
 *
 * @Author : Guy Verghote
 * @Version : 2019.1
 * @DateFr : 21/01/2019
 */

class DateFr
{
    private $nbJour; // Nombre de jours écoulés depuis le lundi 01/01/1900

    // -----------------------------------
    // méthode statiques(à portée classe)
    // -----------------------------------

    /**
     * retourne vrai si année bissextile
     *
     * @param int $annee
     * @return bool
     */

    static public function estBissextile($annee)
    {
        return ($annee % 4 == 0 && $annee % 100 != 0) || $annee % 400 == 0;
    }

    /**
     * retourne le nombre de jour d'un mois
     *
     * @param int $annee
     * @param int $mois
     * @return bool
     */

    static public function joursDansMois($mois, $annee)
    {
        if ($mois == 2) return DateFr::estBissextile($annee) ? 29 : 28;
        if ($mois == 4 || $mois == 6 || $mois == 9 || $mois == 11) return 30;
        return 31;
    }


    /**
     * retourne le nombre de jour d'une année
     *
     * @param int $annee
     * @return int nombre de jours dans l'année
     */

    static public function joursDansAnnee($annee)
    {
        return DateFr::estBissextile($annee) ? 366 : 365;
    }

    /**
     * retourne le nombre de jours écoulés depuis le le premier janvier de l'année
     *
     * @param int $annee
     * @param int $mois
     * @param int $jour
     * @return int nombre de jours
     */

    static public function quantieme($jour, $mois, $annee)
    {
        $total = $jour;
        $i = 1;
        while ($i != $mois) {
            $total += DateFr::joursDansMois($i, $annee);
            $i++;
        }
        return $total;
    }

    /**
     * retourne la différence de jours entre 2 années
     *
     * @param int $a1 année de départ
     * @param int $a2 année d'arrivée
     * @return int
     */
    static public function joursEntre2Annees($a1, $a2)
    {
        $annee = $a1;
        $nbjour = 0;
        while ($annee != $a2) {
            $nbjour += DateFr::joursDansAnnee($annee);
            $annee++;
        }
        return $nbjour;
    }

    /**
     * Retourne le nombre de jours entre deux dates
     * @param DateFr $dateDebut
     * @param DateFr $dateFin
     * @return int Nombre de jours entre les deuxs dates
     */

    static public function joursEntre2Dates($dateDebut, $dateFin)
    {
        return $dateFin->nbJour - $dateDebut->nbJour;
    }

    /**
     * contrôle la validité de la Date saisie
     *
     * @param int $jour
     * @param int $mois
     * @param int $annee
     * @return int
     */

    static public function estValide($jour, $mois, $annee)
    {
        return $mois >= 1 && $mois <= 12 && $jour >= 1 && $jour <= DateFr::joursDansMois($mois, $annee) && $annee >= 1900;
    }

    /**
     * retourner le mois en lettre et sa particule de ou d'
     * @param int $mois moins en chiffre
     * @return  array contenant la particule et le mois
     */

    static public function getLeMois($mois)
    {
        $result = [];
        $result['particule'] = "de ";
        switch ($mois) {
            case 1 :
                $result['libelle'] = "janvier";
                break;
            case 2 :
                $result['libelle'] = "février";
                break;
            case 3 :
                $result['libelle'] = "mars";
                break;
            case 4 :
                $result['libelle'] = "avril";
                $result['particule'] = "d'";
                break;
            case 5 :
                $result['libelle'] = "mai";
                break;
            case 6 :
                $result['libelle'] = "juin";
                break;
            case 7 :
                $result['libelle'] = "juillet";
                break;
            case 8 :
                $result['libelle'] = "août";
                $result['particule'] = "d'";
                break;
            case 9 :
                $result['libelle'] = "septembre";
                break;
            case 10 :
                $result['libelle'] = "octobre";
                $result['particule'] = "d'";
                break;
            case 11 :
                $result['libelle'] = "novembre";
                break;
            case 12 :
                $result['libelle'] = "décembre";
                break;
            default :
                $result['libelle'] = "erreur";
                break;
        }
        return $result;
    }

    /**
     * Retourne la date correspondant au premier jour d'une semaine dans le calendrier français
     * @param annee
     * @param numSemaine
     * @return dateFr
     */

    static public function getDebutSemaine($annee, $numSemaine)
    {
        // on se place sur le 4 janvier qui est forcément dans la semaine 1
        $uneDate = new DateFr(4, 1, $annee);
        // on détermine le lundi de la première semaine
        // si le 4/01 est un lundi(1) 0, mardi(2) - 1, ... Dimanche(7) -6 soit 1 - n° du jour
        $uneDate->ajouterJour(1 - $uneDate->getJourSemaine());

        // on calcule le décalage en ajoutant 7 * numsemaine
        $uneDate->ajouterJour(($numSemaine - 1) * 7);
        return $uneDate;
    }

    // méthodes statiques retournant un objet dDateFr

    /**
     * génération d'un objet DateFr représentant la date du jour
     * @return DateFr
     */
    static public function getDateDuJour()
    {
        $annee = Date("Y");
        $mois = Date("m");
        $jour = Date("d");
        return new DateFr($jour, $mois, $annee);
    }

    /**
     * génération d'un objet DateFr à partir d'une Date au format Mysql aaaa-mm-jj
     * @param int $uneDateMysql
     * @return DateFr ou null si erreur
     */

    static public function getFromDateMysql($uneDateMysql)
    {
        $tab = preg_split("`[/.-]`", $uneDateMysql);
        if (DateFr::estValide($tab[2], $tab[1], $tab[0])) {
            return new DateFr($tab[2], $tab[1], $tab[0]);
        } else {
            return null;
        }
    }

    /**
     * génération d'un objet DateFr à partir à partir d'une Date au format jj/mm/aaaa
     * quelque soit le séparateur :: / - . et le format j ou jj m ou mm
     * @param string $uneDateFr
     * @return object DateFr ou null si erreur
     */
    static public function getFromDateFr($uneDateFr)
    {
        $tab = preg_split("`[/.-]`", $uneDateFr);
        if (DateFr::estValide($tab[0], $tab[1], $tab[2])) {
            return new DateFr($tab[0], $tab[1], $tab[2]);
        } else {
            return null;
        }
    }

    /**
     * Retourne le dimanche de Pâques
     *
     * @param int $annee
     * @return DateFr
     */
    static public function getPaques($annee)
    {
        $var1 = $annee % 19 + 1;
        $var2 = floor(($annee / 100)) + 1; // problème car le nombre n'est pas arrondi
        $var3 = floor(((3 * $var2) / 4) - 12);
        $var4 = floor((((8 * $var2) + 5) / 25) - 5);
        $var5 = floor(((5 * $annee) / 4) - $var3 - 10);
        $var6 = floor((11 * $var1 + 20 + $var4 - $var3) % 30);
        if (($var6 == 25 && $var1 > 11) || ($var6 == 24)) {
            $var6 = $var6 + 1;
        }
        $var7 = 44 - $var6;
        if ($var7 < 21) {
            $var7 = $var7 + 30;
        }
        $var7 = $var7 + 7;
        $var7 = $var7 - ($var5 + $var7) % 7;
        if ($var7 <= 31) {
            $paques = new DateFr($var7, 3, $annee);
        } else {
            $paques = new DateFr($var7 - 31, 4, $annee);
        }
        return $paques;
    }

    /**
     * Retourne les jours fériés de l'année
     *
     * @param int $annee
     * @return array associatif
     */

    static public function getLesJoursFeries($annee)
    {
        $lesJoursFeries = [];
        $paques = DateFr::getPaques($annee);
        $lesJoursFeries["Jour de l'an"] = new DateFr(1, 1, $annee);
        $lesJoursFeries["Fête du travail"] = new DateFr(1, 5, $annee);
        $lesJoursFeries["8 mai 1945"] = new DateFr(8, 5, $annee);
        $lesJoursFeries["Fête Nationale"] = new DateFr(14, 7, $annee);
        $lesJoursFeries["Assomption"] = new DateFr(15, 8, $annee);
        $lesJoursFeries["Toussaint"] = new DateFr(1, 11, $annee);
        $lesJoursFeries["Armistice 1918"] = new DateFr(11, 11, $annee);
        $lesJoursFeries["Noël"] = new DateFr(11, 11, $annee);
        $lesJoursFeries["Pâques"] = $paques;
        $lundiPaques = new DateFr();
        $lundiPaques->nbJour = $paques->nbJour + 1;
        $lesJoursFeries["Lundi de Pâques"] = $lundiPaques;

        $jeudiAscension = new DateFr();
        $jeudiAscension->nbJour = $paques->nbJour + 39;
        $lesJoursFeries["Jeudi de l'Ascension"] = $jeudiAscension;

        $lundiPentecote = new DateFr();
        $lundiPentecote->nbJour = $paques->nbJour + 50;
        $lesJoursFeries["Lundi de Pentecôte"] = $lundiPentecote;
        return $lesJoursFeries;
    }


    /**
     * constructeur d'un objet DateFr à partir de trois paramètres
     * @param int $jour
     * @param int $mois
     * @param int $annee
     */

    public function __construct($jour = 1, $mois = 1, $annee = 1900)
    {
        if (DateFr::estValide($jour, $mois, $annee)) {
            $this->nbJour = DateFr::joursEntre2Annees(1900, $annee) + DateFr::quantieme($jour, $mois, $annee);
        } else {
            $this->nbJour = 1;
        }
    }

    /**
     * transformation de nbJour en un tableau contenant l'année le mois et le jour correspondant
     *
     * @return $t tableau contenant l'année; le mois et le jour en chiffre
     */
    public function getLesElements()
    {
        $lesElements['annee'] = 1900;
        $lesElements['mois'] = 1;
        $nbjr = $this->nbJour;
        while ($nbjr > DateFr::joursDansAnnee($lesElements['annee'])) {
            $nbjr -= DateFr::joursDansAnnee($lesElements['annee']);
            $lesElements['annee']++;
        }
        while ($nbjr > DateFr::joursDansMois($lesElements['mois'], $lesElements['annee'])) {
            $nbjr -= DateFr::joursDansMois($lesElements['mois'], $lesElements['annee']);
            $lesElements['mois']++;
        }
        $lesElements['jour'] = $nbjr;
        return $lesElements;
    }

    // -----------------------------------
    // méthode sur les objets
    // -----------------------------------

    /**
     * retourne le nombre de jours écoulés depuis le 01/01/1900
     *
     * @return int
     */
    public function getNbJour()
    {
        return $this->nbJour;
    }

    /**
     * retourne le jour en chiffre
     *
     * @return int
     */
    public function getJour()
    {
        return $this->getLesElements()['jour'];
    }

    /**
     * retourne le jour en lettre
     *
     * @return string
     */
    public function getJourEnLettre()
    {
        $numJour = $this->getJourSemaine();
        $nomJour = "";
        switch ($numJour) {
            case 1 :
                $nomJour = "lundi";
                break;
            case 2 :
                $nomJour = "mardi";
                break;
            case 3 :
                $nomJour = "mercredi";
                break;
            case 4 :
                $nomJour = "jeudi";
                break;
            case 5 :
                $nomJour = "vendredi";
                break;
            case 6 :
                $nomJour = "samedi";
                break;
            case 7 :
                $nomJour = "dimanche";
                break;
            default :
                $nomJour = "erreur";
                break;
        }
        return $nomJour;
    }

    /**
     * retourne le mois en chiffre
     *
     * @return int
     */
    public function getMois()
    {
        $lesElements = $this->getLesElements();
        return $lesElements['mois'];
    }

    /**
     * retourne le mois en lettre
     *
     * @return string
     */
    public function getMoisEnLettre()
    {
        $numMois = $this->getMois();
        switch ($numMois) {
            case 1 :
                $nomMois = "janvier";
                break;
            case 2 :
                $nomMois = "février";
                break;
            case 3 :
                $nomMois = "mars";
                break;
            case 4 :
                $nomMois = "avril";
                break;
            case 5 :
                $nomMois = "mai";
                break;
            case 6 :
                $nomMois = "juin";
                break;
            case 7 :
                $nomMois = "juillet";
                break;
            case 8 :
                $nomMois = "août";
                break;
            case 9 :
                $nomMois = "septembre";
                break;
            case 10 :
                $nomMois = "octobre";
                break;
            case 11 :
                $nomMois = "novembre";
                break;
            case 12 :
                $nomMois = "décembre";
                break;
            default :
                $nom = "erreur";
                break;
        }
        return $nomMois;
    }

    /**
     * retourne l'année
     *
     * @return string
     */
    public function getAnnee()
    {
        return $this->getLesElements()['annee'];
    }

    /**
     * retourne le numéro du jour dans la semaine
     *(lundi = 1, mardi = 2....)
     *
     * @return int
     */
    public function getJourSemaine()
    {
        return ($this->nbJour - 1) % 7 + 1;
    }

    /**
     * retourne le nombre de jours écoulés depuis le premier janvier de l'année
     *
     * @return string
     */
    public function getQuantieme()
    {
        return DateFr::quantieme($this->getJour(), $this->getMois(), $this->getAnnee());
    }


    /**
     * Retourne le nombre de jours dans le mois
     *
     * @return int
     */
    public function getNbJoursMois()
    {
        return DateFr::joursDansMois($this->getMois(), $this->getAnnee());
    }

    /**
     * retourne le numéro de la semaine
     *
     * @return string
     */
    public function getNumeroSemaine()
    {
        $jeudi = new DateFr($this->getJour(), $this->getMois(), $this->getAnnee());
        $jeudi->ajouterJour(4 - $this->getJourSemaine());
        $le4janvier = new DateFr(4, 1, $jeudi->getAnnee());
        $lundi = new DateFr($le4janvier->getJour(), $le4janvier->getMois(), $le4janvier->getAnnee());
        $lundi->ajouterJour(1 - $le4janvier->getJourSemaine());
        $nbsemaine = 0;
        $numjour = $lundi->nbJour;
        while ($numjour <= $jeudi->nbJour) {
            $numjour += 7;
            $nbsemaine++;
        }
        return ($nbsemaine);
    }

    /**
     * méthode ajoutant un nombre nb de jour à un objet DateFr
     *
     * @param int $nb nombre de jours à ajouter
     */
    public function ajouterJour($nb)
    {
        $this->nbJour += $nb;
    }

    /**
     * méthode retirant un nombre nb de jour à un objet DateFr
     *
     * @param int $nb nombre de jours à retirer
     */
    public function retirerJour($nb)
    {
        $this->nbJour -= $nb;
    }

    /**
     * méthode ajoutant un nombre d'année à un objet DateFr
     *
     * @param int $nb nombre d'année à ajouter
     */
    public function ajouterAnnee($nb)
    {
        $lesElements = $this->getLesElements();
        $annee = $lesElements['annee'];
        for ($i = 1; $i <= $nb; $i++) {
            $this->nbJour += DateFr::joursDansAnnee($annee);
            $annee++;
        }
    }

    /**
     * méthode retirant un nombre d'année à un objet DateFr
     *
     * @param int $nb nombre d'année à retirer
     */
    public function retirerAnnee($nb)
    {
        $lesElements = $this->getLesElements();
        $annee = $lesElements['annee'];
        for ($i = 1; $i <= $nb; $i++) {
            if ($annee === 1900) exit;
            $this->nbJour += DateFr::joursDansAnnee($annee);
            $annee++;
        }
    }

    /**
     * méthode de comparaison
     *
     * @param DateFr $uneDate objet date utilisé pour la comparaison
     * @return true si les dates sont identiques
     */
    public function estEgale($uneDate)
    {
        return $this->nbJour == $uneDate->nbJour;
    }

    /**
     * méthode de comparaison
     *
     * @param DateFr $uneDate objet date utilisé pour la comparaison
     * @return true si la date est plus grande que uneDate
     */
    public function estPlusGrande($uneDate)
    {
        return $this->nbJour > $uneDate->nbJour;
    }

    /**
     * méthode de comparaison
     *
     * @param DateFr uneDate objet date utilisé pour la comparaison
     * @return true si la date est plus petite que uneDate
     */
    public function estPlusPetite($uneDate)
    {
        return $this->nbJour < $uneDate->nbJour;
    }


    /**
     * retourne l'écart en jours avec la date passée en paramètre
     *
     * @param DateFr $uneDate
     * @return int Nombre de jours
     */

    public function ecartEnJours($uneDate) {
        return $this->nbJour - $uneDate->nbJour;
    }

    /**
     * retourne vrai si le jour est férié
     *
     * @return bool
     */
    public function estFerie()
    {
        $lesElements = $this->getLesElements();
        $annee = $lesElements['annee'];
        $mois = $lesElements['mois'];
        $jour = $lesElements['jour'];
        $reponse = false;
        if (($mois == 1 && $jour == 1) || ($mois == 5 && $jour == 1) ||
            ($mois == 5 && $jour == 8) || ($mois == 7 && $jour == 14) ||
            ($mois == 8 && $jour == 15) || ($mois == 11 && $jour == 11) ||
            ($mois == 11 && $jour == 1) || ($mois == 12 && $jour == 25)) {
            $reponse = true;
        } else {
            $var1 = $annee % 19 + 1;
            $var2 = floor(($annee / 100)) + 1; // problème car le nombre n'est pas arrondi
            $var3 = ((3 * $var2) / 4) - 12;
            $var4 = (((8 * $var2) + 5) / 25) - 5;
            $var5 = ((5 * $annee) / 4) - $var3 - 10;
            $var6 = (11 * $var1 + 20 + $var4 - $var3) % 30;
            if (($var6 == 25 && $var1 > 11) || ($var6 == 24)) {
                $var6 = $var6 + 1;
            }
            $var7 = 44 - $var6;
            if ($var7 < 21) {
                $var7 = $var7 + 30;
            }
            $var7 = $var7 + 7;
            $var7 = $var7 - ($var5 + $var7) % 7;
            if ($var7 <= 31) {
                $paques = new DateFr($var7, 3, $annee);
            } else {
                $paques = new DateFr($var7 - 31, 4, $annee);
            }
            $lundiPaques = new DateFr($paques->getJour(), $paques->getMois(), $paques->getAnnee());
            $lundiPaques->ajouterJour(1);

            $ascension = new DateFr($paques->getJour(), $paques->getMois(), $paques->getAnnee());
            $ascension->ajouterJour(39);
            $pentecote = new DateFr($paques->getJour(), $paques->getMois(), $paques->getAnnee());
            $pentecote->ajouterjour(50);
            if ($this->nbJour == $paques->nbJour || $this->nbJour == $lundiPaques->nbJour || $this->nbJour == $ascension->nbJour || $this->nbJour == $pentecote->nbJour) {
                $reponse = true;
            }
        }
        return $reponse;
    }

    /**
     * retourne vrai si le jour est férié
     *
     * @return bool
     */
    public function getNomJourFerie()
    {
        $nom = "Ce n'est pas un jour férié";
        $lesElements = $this->getLesElements();
        $annee = $lesElements['annee'];
        $mois = $lesElements['mois'];
        $jour = $lesElements['jour'];
        $paques = DateFr::getPaques($annee);
        if ($mois == 1 && $jour == 1) {
            $nom = "jour de l'An";
        } else if ($mois == 5 && $jour == 1) {
            $nom = "Fête de Travail";
        } else if ($mois == 5 && $jour == 8) {
            $nom = "victoire 1945";
        } else if ($mois == 7 && $jour == 14) {
            $nom = "Fête Nationale";
        } else if ($mois == 8 && $jour == 15) {
            $nom = "Assomption";
        } else if ($mois == 11 && $jour == 1) {
            $nom = "Toussaint";
        } else if ($mois == 11 && $jour == 11) {
            $nom = "Armistice 1918";
        } else if ($mois == 12 && $jour == 25) {
            $nom = "Noël";
        }
        if ($this->nbJour == $paques->nbJour) {
            $nom = "Pâques";
        } else if ($this->nbJour == $paques->nbJour + 1) {
            $nom = "Lundi de Pâques";
        } else if ($this->nbJour == $paques->nbJour + 39) {
            $nom = "Ascencion";
        } else if ($this->nbJour == $paques->nbJour + 50) {
            $nom = "Lundi de Pentecôte";
        }
        return $nom;
    }

    /**
     * retourne vrai si le jour est un jour ouvrable : du lundi au vendredi sauf jour férié
     *
     * @return bool
     */
    public function estJourOuvrable()
    {
        return !$this->estFerie() && $this->getJourSemaine() < 6;
    }

    /**
 * retourne le jour ouvrable suivant : du lundi au vendredi sauf jour férié
 *
 * @return DateFr
 */

    public function getJourOuvrableSuivant()
    {
        $jourOuvrableSuivant = new DateFr();
        $jourOuvrableSuivant->nbJour = $this->nbJour + 1;
        while (!$jourOuvrableSuivant->estJourOuvrable()) {
            $jourOuvrableSuivant->nbJour += 1;
        }
        return $jourOuvrableSuivant;
    }

    /**
     * retourne le jour ouvrable précédent : du lundi au vendredi sauf jour férié
     *
     * @return DateFr
     */

    public function getJourOuvrablePrecedent()
    {
        $jourOuvrablePrecedent = new DateFr();
        $jourOuvrablePrecedent->nbJour = $this->nbJour - 1;
        while (!$jourOuvrablePrecedent->estJourOuvrable()) {
            $jourOuvrablePrecedent->nbJour -= 1;
        }
        return $jourOuvrablePrecedent;
    }


    /**
     * retourne la date au format au format jj/mm/aaaa. Le séparateur à utiliser est passé en paramètre
     *
     * @param string $separateur séparateur entre les éléments d'une date
     * @return string
     */
    public function toFormatCourt($separateur = "/")
    {
        $lesElements = $this->getLesElements();
        $a = $lesElements['annee'];
        $m = $lesElements['mois'];
        $j = $lesElements['jour'];
        $resultat = ((strlen($j) < 2) ? "0" : "") . $j . $separateur . (strlen($m) < 2 ? "0" : "") . $m . $separateur . $a;
        return $resultat;
    }

    /**
     * retourne la date au format au format jjjj jj mmmm aaaa en remplaçant jj par premier lorsque j = 1j
     *
     * @return string
     */
    public function toFormatLong()
    {
        $lesElements = $this->getLesElements();
        $a = $lesElements['annee'];
        $m = $lesElements['mois'];
        $j = $lesElements['jour'];
        $resultat = $this->getJourEnLettre() . " ";
        if ($j == 1) {
            $resultat .= "premier";
        } else {
            $resultat .= ((strlen($j) < 2) ? "0" : "") . $j;
        }
        $resultat .= " " . $this->getMoisEnLettre() . " " . $a;
        return $resultat;
    }

    /**
     * retourne la DateFr au format Mysql aaaa-mm-jj
     *
     * @return string date au format mySQL
     */
    public function toMySQL()
    {
        $lesElements = $this->getLesElements();
        $date = $lesElements['annee'] . "-" . ((strlen($lesElements['mois']) < 2) ? "0" : "") . $lesElements['mois'] . "-" . ((strlen($lesElements['jour']) < 2) ? "0" : "") . $lesElements['jour'];
        return $date;
    }

    /**
     * retourne la DateFr au format Mysql aaaa-mm-jj
     *
     * @return string date au format mySQL
     */
    public function toFormatMySQL()
    {
        $lesElements = $this->getLesElements();
        $date = $lesElements['annee'] . "-" . ((strlen($lesElements['mois']) < 2) ? "0" : "") . $lesElements['mois'] . "-" . ((strlen($lesElements['jour']) < 2) ? "0" : "") . $lesElements['jour'];
        return $date;
    }


}