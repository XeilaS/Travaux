<?php
/**
 * Classe Pdf : hérite de Fpdf
 * Définition des méthodes header footer titre impressionEnteteTableau ...
 * @Author : Guy Verghote
 * @Date : 26/07/2020
 */

require('fpdf.php');

/**
 * Définition de la classe PDF
 */
class PDF extends FPDF
{
    var $txtEntete;  // Titre placé dans l'entête
    var $image;         //  image placée à droite dans l'entête
    var $txtPied;    // titre placé à gauche dans le pied
    var $pagination;    // active ou désactive la pagination au centre du pied de page
    private $taillePolice = 10; // taille initiale de la police
    private $police = 'helvetica'; // police initiale

    // accesseur sur l'attribut privé PageBreakTrigger pour gérer le saut de page
    public function getPageBreakTrigger()
    {
        return $this->PageBreakTrigger;
    }

    // accesseur sur l'attribut privé lMargin
    function getLeftMargin()
    {
        return $this->lMargin;
    }

    // accesseur sur l'attribut privé rMargin
    function getRightMargin()
    {
        return $this->rMargin;
    }

    // accesseur sur l'attribut privé rMargin
    function getTopMargin()
    {
        return $this->tMargin;
    }

    function getTaillePolice()
    {
        return $this->taillePolice;
    }

    function getPolice()
    {
        return $this->police;
    }


    /**
     * Définition de l'entête des pages pdf
     *
     * @param $unTexte string contenant le texte de l'entête
     * @param $uneImage string contenant le lien vers l'image de droite
     */

    public function setHeader($unTexte = '', $uneImage = '')
    {
        $this->txtEntete = $unTexte;
        $this->image = $uneImage;
    }

    /**
     * Définition de pied de page pdf
     *
     * @param $unTexte string contenant le texte du pied
     * @param $pagination string pour afficher ou non le numéro de page
     *
     */
    public function setFooter($unTexte, $pagination = 1)
    {
        $this->txtPied = $unTexte;
        $this->pagination = $pagination;
    }

    /**
     * Génération de l'entête
     */

    public function Header()
    {
        if ($this->image != "") {
            $wImage = 30;
            $x = $this->GetPageWidth() - $this->getRightMargin() - $wImage;
            $y = $this->getTopMargin();
            $this->image($this->image, $x, $y, $wImage);
        }
        // impression du titre
        if ($this->txtEntete != "") {
            $this->SetFont('Helvetica', 'B', 15);
            $this->SetX($this->getLeftMargin());
            // texte sur toute la longueur, hauteur de 15, bordure en bas, curseur au début de la ligne suivante, centrer
            $this->Cell(0, 10, $this->txtEntete, "B", 1, 'L');
        }
        // positionnement sur y
        $this->SetY($this->getTopMargin() + 12);
    }

    /**
     * Génération du pied des pages
     */
    public function Footer()
    {
        $this->SetFontSize(9);
        // Texte du pied de page
        if ($this->txtPied != "") {
            $this->SetY(-15); //Positionnement à 1, 5 cm du bas
            // texte sur toute la longueur, hauteur de 10, bordure en haut, curseur à droite, alignement à gauche
            $this->Cell(0, 10, $this->txtPied, 'T', 0, 'L');
        }
        //Numéro de page
        if ($this->pagination == 1) {
            $texte = 'Page ' . $this->PageNo() . '/{nb}';
            $x = $this->GetPageWidth() - $this->getRightMargin() - $this->GetStringWidth($texte) + 4;
            $this->Text($x, $this->GetY() + 5, $texte);
        }
        $this->SetFontSize($this->taillePolice);
    }

    /**
     * Mise en forme d'un titre
     * @param string $titre
     */
    public function impressionTitre($titre)
    {
        $this->SetFont('', 'B', 14);
        // texte sur toute la longueur, hauteur de 3, sans bordure, curseur sur ligne suivante, alignement à gauche
        $this->Cell(0, 6, $titre, 0, 1, 'L', 0);
        $this->Ln();
        $this->SetFont('', '', '10');
    }

    /**
     * Définition d'un ligne d'entête de tableau
     * @param array $lesValeurs contenu de chaque cellule
     * @param array $lesTailles taille de chaque cellule
     * @param array $lesEncadrements encadrement de chaque cellule
     * @param array $lesAlignements alignement de chaque cellule
     * @param int $marge marge de gauche
     * @param int $taillePolice taille de la police
     */
    public function impressionEnteteTableau($lesValeurs, $lesTailles, $lesEncadrements, $lesAlignements, $marge = null, $taillePolice = null)
    {
        $this->setx($marge);
        if ($taillePolice === null)
            $this->SetFont('', 'B', $this->getTaillePolice());
        else
            $this->SetFont('', 'B', $taillePolice);

        $this->SetTextColor(0);
        $this->SetLineWidth(0.1);
        $nb = count($lesValeurs);
        for ($i = 0; $i < $nb; $i++) {
            $this->Cell($lesTailles[$i], 10, $lesValeurs[$i], $lesEncadrements[$i], 0, $lesAlignements[$i], 1);
        }
        $this->Ln();
        $this->SetX($marge);
        $this->SetFont('', '', $this->taillePolice);
    }

// gestion d'unn tableau avec des lignes de tailles variables
// Source : http://www.fpdf.org/fr/script/script3.php
// auteur : oliver@fpdf.org

    /**
     * Tableau des largeurs de colonnes
     * @param array $w
     */
    public function setWidths($w)
    {
        $this->widths = $w;
    }

    /**
     * Tableau des alignements de colonnes
     * @param array $a
     */

    public function setAligns($a)
    {
        $this->aligns = $a;
    }

    /**
     * Calcule la hauteur de la ligne
     * @param string $data
     */

    public function row($data)
    {
        $nb = 0;
        $nbdata = count($data);
        for ($i = 0; $i < $nbdata; $i++) {
            $nb = max($nb, $this->nbLines($this->widths[$i], $data[$i]));
        }
        $h = 5 * $nb;
        //Effectue un saut de page si nécessaire
        $this->checkPageBreak($h);
        //Dessine les cellules
        for ($i = 0; $i < $nbdata; $i++) {
            $w = $this->widths[$i];
            $a = isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
            //Sauve la position courante
            $x = $this->GetX();
            $y = $this->GetY();
            //Dessine le cadre
            $this->Rect($x, $y, $w, $h);
            //Imprime le texte
            $this->MultiCell($w, 5, $data[$i], 0, $a);
            //Repositionne à droite
            $this->SetXY($x + $w, $y);
        }
        //Va à la ligne
        $this->Ln($h);
    }

    /**
     * Si la hauteur h provoque un débordement,  saut de page manuel
     * @param int $h
     */
    public function checkPageBreak($h)
    {
        if ($this->GetY() + $h > $this->PageBreakTrigger) {
            $this->AddPage($this->CurOrientation);

        }
    }

    /**
     * Calcule le nombre de lignes qu'occupe un MultiCell de largeur w
     * @param int $w
     * @param string $txt
     * @return int $nl nombre de ligne
     */
    public function nbLines($w, $txt)
    {
        $cw = &$this->CurrentFont['cw'];
        if ($w == 0) {
            $w = $this->w - $this->rMargin - $this->x;
        }
        $wmax = ($w - 2 * $this->cMargin) * 1000 / $this->FontSize;
        $s = str_replace("\r", '', $txt);
        $nb = strlen($s);
        if (($nb > 0) && ($s[$nb - 1] == "\n")) {
            $nb--;
        }
        $sep = -1;
        $i = 0;
        $j = 0;
        $l = 0;
        $nl = 1;
        while ($i < $nb) {
            $c = $s[$i];
            if ($c == "\n") {
                $i++;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
                continue;
            }
            if ($c == ' ') {
                $sep = $i;
            }
            $l += $cw[$c];
            if ($l > $wmax) {
                if ($sep == -1) {
                    if ($i == $j) {
                        $i++;
                    }
                } else {
                    $i = $sep + 1;
                }
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
            } else {
                $i++;
            }
        }
        return $nl;
    }
}