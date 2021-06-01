<?php
/**
 * Classe permettant de gérer des dates
 *
 * @Author : Guy Verghote
 * @Version : 2020.3
 * @Date : 26/08/2020
 */

class DateFr
{
    private $nbJour; // Nombre de jours écoulés depuis le lundi 01/01/1900

    // -----------------------------------
    // méthode statiques(à portée classe)
    // -----------------------------------

    /**
     * indique si l'année est bissextile
     * @param int $annee
     * @return bool
     */
    static public function estBissextile(int $annee) : bool
    {
        return ($annee % 4 == 0 && $annee % 100 != 0) || $annee % 400 == 0;
    }

    /**
     * retourne le nombre de jours d'un mois dans une année
     * @param int $mois
     * @param int $annee
     * @return int
     */
    public static function joursDansMois(int $mois, int $annee) : int
    {
        if ($mois == 2) return DateFr::estBissextile($annee) ? 29 : 28;
        if ($mois == 4 || $mois == 6 || $mois == 9 || $mois == 11) return 30;
        return 31;
    }

    /**
     * retourne le nombre de jours dans l'année
     * @param int $annee
     * @return int
     */
    static public function joursDansAnnee(int $annee) : int
    {
        return DateFr::estBissextile($annee) ? 366 : 365;
    }

    /**
     * retourne le nombre de jours écoulés depuis le premier janvier de l'année
     * @param int $jour
     * @param int $mois
     * @param int $annee
     * @return int
     */
    static public function quantieme(int $jour, int $mois, int $annee) : int
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
     * retourne la différence en jours entre 2 années
     * @param int $a1
     * @param int $a2
     * @return int
     */
    static public function joursEntre2Annees(int $a1, int $a2) : int
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
     * retourne le nombre de jours entre les deuxs dates
     * @param DateFr $dateDebut
     * @param DateFr $dateFin
     * @return int
     */
    static public function joursEntre2Dates(DateFr $dateDebut, DateFr $dateFin) : int
    {
        return $dateFin->nbJour - $dateDebut->nbJour;
    }

    /**
     * contrôle la validité de la Date saisie
     * @param int $jour
     * @param int $mois
     * @param int $annee
     * @return bool
     */
    static public function estValide(int $jour, int $mois, int $annee) : bool
    {
        return $mois >= 1 && $mois <= 12 && $jour >= 1 && $jour <= DateFr::joursDansMois($mois, $annee) && $annee >= 1900;
    }

    /**
     * retourne le mois en lettre et sa particule dans un array associatif
     * avec deux clés particule et libelle
     * @param int $mois
     * @return array
     */

    static public function getLeMois(int $mois) : array
    {
        $lesMois = ['janvier', 'février', 'mars', 'avril', 'mai', 'juin', 'juillet', 'août', 'septembre', 'octobre', 'novembre', 'décembre'];
        $result['particule'] = "de ";
        if ($mois === 4 || $mois === 8 || $mois === 10) $result['particule'] = "d'";
        $result['libelle'] = $lesMois[$mois - 1];
        return $result;
    }

    /**
     * Retourne la date correspondant au premier jour d'une semaine dans le calendrier français
     * @param int $annee
     * @param int $numSemaine
     * @return DateFr
     */
    static public function getDebutSemaine(int $annee, int $numSemaine) : dateFr
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

    // méthodes statiques retournant un objet DateFr

    /**
     * génération d'un objet DateFr représentant la date du jour
     */
    static public function getDateDuJour() : DateFr
    {
        $annee = Date("Y");
        $mois = Date("m");
        $jour = Date("d");
        return new DateFr($jour, $mois, $annee);
    }

    /**
     * génération d'un objet DateFr à partir d'une Date au format Mysql aaaa-mm-jj
     * @param string $uneDateMysql
     * @return DateFr|null
     */
    static public function getFromDateMysql(string $uneDateMysql)
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
     * quel que soit le séparateur : / - . et le format j ou jj m ou mm
     * @param string $uneDateFr
     * @return DateFr|null
     */
    static public function getFromDateFr(string $uneDateFr)
    {
        $tab = preg_split("`[/.-]`", $uneDateFr);
        if (DateFr::estValide($tab[0], $tab[1], $tab[2])) {
            return new DateFr($tab[0], $tab[1], $tab[2]);
        } else {
            return null;
        }
    }

    /**
     * Génération d'un objet DateFr à partir d'un autre objet DateFr
     * correspond à la notion de constructeur par copie
     * @param DateFr $uneDate
     * @return DateFr
     */
    static public function getFromObject(DateFr $uneDate) : DateFr
    {
        return new DateFr($uneDate->getJour(), $uneDate->getMois(), $uneDate->getAnnee());
    }

    /**
     * Retourne le dimanche de Pâques
     * @param int $annee
     * @return DateFr
     */
    static public function getPaques(int $annee) : DateFr
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
     * Retourne les jours fériés de l'année dans un tableau
     * deux clés : date et libelle
     * @param int $annee
     * @return array
     */

    static public function getLesJoursFeries(int $annee) : array
    {
        // paques [22 mars - 25 avril]
        // ascension [30 avril - 2 juin]
        // Pentecôte [11 mai - 13 juin]
        $lesJoursFeries = [];

        $paques = DateFr::getPaques($annee);
        $huitMai = new DateFr(8, 5, $annee);
        $lundiPaques = new DateFr();
        $lundiPaques->nbJour = $paques->nbJour + 1;
        $ascension = new DateFr();
        $ascension->nbJour = $paques->nbJour + 39;
        $pentecote = DateFr::getFromObject($paques);
        $pentecote->ajouterJour(50);
        $premierMai = new DateFr(1, 5, $annee);

        $jour['libelle'] = "Jour de l'an";
        $jour['date'] = new DateFr(1, 1, $annee);
        $lesJoursFeries[] = $jour;

        $jour['libelle'] = "Pâques";
        $jour['date'] = $paques;
        $lesJoursFeries[] = $jour;

        $jour['libelle'] = "Lundi de Pâques";
        $jour['date'] = $lundiPaques;
        $lesJoursFeries[] = $jour;

        if ($ascension->nbJour < $premierMai->nbJour) {
            $jour['libelle'] = "Jeudi de l'Ascension";
            $jour['date'] = $ascension;
            $lesJoursFeries[] = $jour;
            $jour['libelle'] = "Fête du travail";
            $jour['date'] = $premierMai;
            $lesJoursFeries[] = $jour;
            $jour['libelle'] = "Armistice 1945";
            $jour['date'] = new DateFr(8, 5, $annee);
            $lesJoursFeries[] = $jour;
        } elseif ($ascension->nbJour < $huitMai->nbJour) {
            $jour['libelle'] = "Fête du travail";
            $jour['date'] = $premierMai;
            $lesJoursFeries[] = $jour;
            $jour['libelle'] = "Jeudi de l'Ascension";
            $jour['date'] = $ascension;
            $lesJoursFeries[] = $jour;
            $jour['libelle'] = "Armistice 1945";
            $jour['date'] = new DateFr(8, 5, $annee);
            $lesJoursFeries[] = $jour;
        } else {
            $jour['libelle'] = "Fête du travail";
            $jour['date'] = $premierMai;
            $lesJoursFeries[] = $jour;
            $jour['libelle'] = "Armistice 1945";
            $jour['date'] = new DateFr(8, 5, $annee);
            $lesJoursFeries[] = $jour;
            $jour['libelle'] = "Jeudi de l'Ascension";
            $jour['date'] = $ascension;
            $lesJoursFeries[] = $jour;
        }

        $jour['libelle'] = "Lundi de Pentecôte";
        $jour['date'] = $pentecote;
        $lesJoursFeries[] = $jour;

        $jour['libelle'] = "Fête Nationale";
        $jour['date'] = new DateFr(14, 7, $annee);
        $lesJoursFeries[] = $jour;

        $jour['libelle'] = "Assomption";
        $jour['date'] = new DateFr(15, 8, $annee);
        $lesJoursFeries[] = $jour;

        $jour['libelle'] = "Toussaint";
        $jour['date'] = new DateFr(1, 11, $annee);
        $lesJoursFeries[] = $jour;

        $jour['libelle'] = "Armistice 1918";
        $jour['date'] = new DateFr(11, 11, $annee);
        $lesJoursFeries[] = $jour;

        $jour['libelle'] = "Noël";
        $jour['date'] = new DateFr(25, 12, $annee);
        $lesJoursFeries[] = $jour;

        return $lesJoursFeries;
    }

    /**
     * Constructeur d'un objet DateFr à partir de trois paramètres
     * En l'absence de paramètre le constructeur retourne la date du jour.
     * @param int $jour
     * @param int $mois
     * @param int $annee
     */

    public function __construct(int $jour = 0, int $mois = 0, int $annee = 0)
    {
        if ($jour === 0 && $mois === 0 && $annee === 0) {
            $annee = Date("Y");
            $mois = Date("m");
            $jour = Date("d");
        }
        if (DateFr::estValide($jour, $mois, $annee)) {
            $this->nbJour = DateFr::joursEntre2Annees(1900, $annee) + DateFr::quantieme($jour, $mois, $annee);
        } else {
            $this->nbJour = 1;
        }
    }

    /**
     *
     * @return array tableau contenant l'année, le mois et le jour de l'objet DateFr
     */
    private function getLesElements() : array
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
     *
     * nombre de jours écoulés depuis le 01/01/1900
     */
    public function getNbJour() : int
    {
        return $this->nbJour;
    }

    /**
     * jour en chiffre
     */
    public function getJour() : int
    {
        return $this->getLesElements()['jour'];
    }

    /**
     *
     * jour en lettre
     */
    public function getJourEnLettre() : string
    {
        $lesJours = ['lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi', 'dimanche'];
        return $lesJours[$this->getJourSemaine() - 1];
    }

    /**
     * retourne le mois en chiffre
     */
    public function getMois() : int
    {
        $lesElements = $this->getLesElements();
        return $lesElements['mois'];
    }

    /**
     *
     * retourne le mois en lettre
     */
    public function getMoisEnLettre() : string
    {
        $lesMois = ['janvier', 'février', 'mars', 'avril', 'mai', 'juin', 'juillet', 'août', 'septembre', 'octobre', 'novembre', 'décembre'];
        return $lesMois[$this->getMois() - 1];
    }

    /**
     * retourne l'année
     */
    public function getAnnee() : int
    {
        return $this->getLesElements()['annee'];
    }

    /**
     * retourne le numéro du jour dans la semaine (lundi = 1, mardi = 2....)
     */
    public function getJourSemaine() : int
    {
        return ($this->nbJour - 1) % 7 + 1;
    }

    /**
     * retourne le nombre de jours écoulés depuis le premier janvier de l'année
     */
    public function getQuantieme() :int
    {
        return DateFr::quantieme($this->getJour(), $this->getMois(), $this->getAnnee());
    }

    /**
     * retourne le nombre de jours dans le mois
     */
    public function getNbJoursMois() : int
    {
        return DateFr::joursDansMois($this->getMois(), $this->getAnnee());
    }

    /**
     * retourne le numéro de la semaine numérotation française
     */
    public function getNumeroSemaine() : int
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
     * Ajoute un nombre de jours à l'objet DateFr
     * @param int $nb
     */
    public function ajouterJour(int $nb)
    {
        $this->nbJour += $nb;
    }

    /**
     * méthode retirant un nombre nb de jour à un objet DateFr
     * @param int $nb
     */
    public function retirerJour(int $nb)
    {
        $this->nbJour -= $nb;
    }

    /**
     * méthode ajoutant un nombre nb de mois à un objet DateFr
     * Si on part du dernier jour du mois on doit retomber sur le dernier jour
     *
     * @param int $nb nombre de mois à ajouter
     */
    public function ajouterMois(int $nb)
    {
        $lesElements = $this->getLesElements();
        $jour = $lesElements["jour"];
        $mois = $lesElements["mois"];
        $annee = $lesElements["annee"];

        for ($i = 1; $i <= $nb; $i++) {
            $mois++;
            if ($mois > 12) {
                $mois = 1;
                $annee++;
            }
        }
        if ($jour > DateFr::joursDansMois($mois, $annee)) {
            $jour -= DateFr::joursDansMois($mois, $annee);
            $mois++;
        }
        $this->nbJour = DateFr::joursEntre2Annees(1900, $annee) + DateFr::quantieme($jour, $mois, $annee);
    }

    /**
     * Retire un nombre de mois à un objet DateFr
     * @param int $nb
     */
    public function retirerMois(int $nb)
    {
        $lesElements = $this->getLesElements();
        $jour = $lesElements["jour"];
        $mois = $lesElements["mois"];
        $annee = $lesElements["annee"];
        for ($i = 1; $i <= $nb; $i++) {
            $mois--;
            if ($mois < 1) {
                $mois = 12;
                $annee--;
                if ($annee < 1900) {
                    $this->nbJour = 0;
                    return;
                }
            }
        }
        if ($jour > DateFr::joursDansMois($mois, $annee) ) {
            $jour -= DateFr::joursDansMois($mois, $annee);
            $mois++;
        }
        $this->nbJour = DateFr::joursEntre2Annees(1900, $annee) + DateFr::quantieme($jour, $mois, $annee);

    }

    /**
     * Ajoute un nombre d'années à l'objet DateFr
     *
     * @param int $nb nombre d'années à ajouter
     */
    public function ajouterAnnee(int $nb)
    {
        $lesElements = $this->getLesElements();
        $jour = $lesElements["jour"];
        $mois = $lesElements["mois"];
        $annee = $lesElements["annee"] + $nb;
        $this->nbJour = DateFr::joursEntre2Annees(1900, $annee) + DateFr::quantieme($jour, $mois, $annee);
        $lesElements = $this->getLesElements();
        if ($jour !== $lesElements["jour"]) $this->nbJour -= $lesElements["jour"];
    }

    /**
     * Retire un nombre d'années à l'objet DateFr
     *
     * @param int nb nombre d'années à retirer
     */
    public function retirerAnnee(int $nb)
    {
        $lesElements = $this->getLesElements();
        $jour = $lesElements["jour"];
        $mois = $lesElements["mois"];
        $annee = $lesElements["annee"] - $nb;
        $this->nbJour = DateFr::joursEntre2Annees(1900, $annee) + DateFr::quantieme($jour, $mois, $annee);
        $lesElements = $this->getLesElements();
        if ($jour !== $lesElements["jour"]) $this->nbJour -= $lesElements["jour"];
    }

    /**
     *
     * @param DateFr $uneDate
     * @return bool {boolean} true si les dates sont identiques
     */
    public function estEgale(DateFr $uneDate) : bool
    {
        return $this->nbJour == $uneDate->nbJour;
    }

    /**
     * @param DateFr $uneDate
     * @return bool
     */
    public function estPlusGrande(DateFr $uneDate) : bool
    {
        return $this->nbJour > $uneDate->nbJour;
    }

    /**
     * @param DateFr $uneDate
     * @return bool
     */
    public function estPlusPetite(DateFr $uneDate) : bool
    {
        return $this->nbJour < $uneDate->nbJour;
    }

    /**
     *
     * @param DateFr $uneDate
     * @return int {integer} écart en jours avec la date passée en paramètre
     */

    public function ecartEnJours(DateFr $uneDate) : int
    {
        return $this->nbJour - $uneDate->nbJour;
    }

    /**
     *
     * @return bool true si la date correspond à un jour férié français
     */
    public function estFerie() : bool
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
     * @return string nom du jour férié. "Ce n'est pas un jour férié" si la date ne correspond pas à un jour férié
     */
    public function getNomJourFerie() : string
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
     *
     * @return bool true si le jour est un jour ouvrable : du lundi au vendredi sauf jour férié
     */
    public function estJourOuvrable() : bool
    {
        return !$this->estFerie() && $this->getJourSemaine() < 6;
    }

    /**
     *
     * @return DateFr jour ouvrable suivant : du lundi au vendredi sauf jour férié
     */

    public function getJourOuvrableSuivant() : DateFr
    {
        $jourOuvrableSuivant = new DateFr();
        $jourOuvrableSuivant->nbJour = $this->nbJour + 1;
        while (!$jourOuvrableSuivant->estJourOuvrable()) {
            $jourOuvrableSuivant->nbJour += 1;
        }
        return $jourOuvrableSuivant;
    }

    /**
     *
     * @return DateFr jour ouvrable précédent : du lundi au vendredi sauf jour férié
     */

    public function getJourOuvrablePrecedent() : DateFr
    {
        $jourOuvrablePrecedent = new DateFr();
        $jourOuvrablePrecedent->nbJour = $this->nbJour - 1;
        while (!$jourOuvrablePrecedent->estJourOuvrable()) {
            $jourOuvrablePrecedent->nbJour -= 1;
        }
        return $jourOuvrablePrecedent;
    }

    /**
     *
     * @param string $separateur
     * @return string  date au format jj/mm/aaaa
     */
    public function toFormatCourt(string $separateur = "/") : string
    {
        $lesElements = $this->getLesElements();
        $a = $lesElements['annee'];
        $m = $lesElements['mois'];
        $j = $lesElements['jour'];
        return ((strlen($j) < 2) ? "0" : "") . $j . $separateur . (strlen($m) < 2 ? "0" : "") . $m . $separateur . $a;
    }

    /**
     *
     * @return string date au format au format jjjj jj mmmm aaaa en remplaçant jj par 1er lorsque j = 1j
     */
    public function toFormatLong() : string
    {
        $lesElements = $this->getLesElements();
        $a = $lesElements['annee'];
        $j = $lesElements['jour'];
        $resultat = $this->getJourEnLettre() . " ";
        if ($j == 1) {
            $resultat .= "1er";
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
    public function toMySQL() : string
    {
        $lesElements = $this->getLesElements();
        return $lesElements['annee'] . "-" . ((strlen($lesElements['mois']) < 2) ? "0" : "") . $lesElements['mois'] . "-" . ((strlen($lesElements['jour']) < 2) ? "0" : "") . $lesElements['jour'];
    }

    /**
     * retourne la DateFr au format Mysql aaaa-mm-jj
     *
     * @return string date au format mySQL
     */
    public function toFormatMySQL() : string
    {
        $lesElements = $this->getLesElements();
        return $lesElements['annee'] . "-" . ((strlen($lesElements['mois']) < 2) ? "0" : "") . $lesElements['mois'] . "-" . ((strlen($lesElements['jour']) < 2) ? "0" : "") . $lesElements['jour'];
    }
}