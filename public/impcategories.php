<?php
// statistique
require '../class/class.database.php';
$db = Database::getInstance();
require '../class/fpdf/class.pdf.php';

// nessaisaire pour afficher la date au format long dans le pied du document
require '../class/class.datefr.php';
// récupération des categories
$db = Database::getInstance();
// calcul de l'année de référence : changement de catégorie au 1er novembre
$sql = <<<EOD
        Select moisFfa 
        From parametre;
EOD;
$curseur = $db->query($sql);
$ligne = $curseur->fetch(PDO::FETCH_ASSOC);
$curseur->closeCursor();
$moisFfa = $ligne['moisFfa'];
$mois = date('M');
$annee = date('Y');
if ($mois >= $moisFfa) $annee++;
$anneeP = $annee - 1;

$sql = <<<EOD
        Select id, nom, ageMin, ageMax, distanceMax 
        from categorie
        order by agemin;
EOD;
$curseur = $db->query($sql);
$lesCategories = $curseur->fetchAll(PDO::FETCH_ASSOC);
$curseur->closeCursor();


//paramètre
$titre = utf8_decode("Catégories d'âge sur la saison $anneeP/$annee ");
$marge = 20;
$interligne = 6;
$taillePolice = 8;
$pdf = new PDF('P', 'mm', 'A4');
$pdf->SetCreator("VDS");
$pdf->SetAuthor("VDS");


$pdf->SetFont($pdf->getPolice(), '', $pdf->getTaillePolice());
$pdf->SetFillColor(255, 255, 255); // 237 gris
$pdf->SetTextColor(0);
$pdf->SetDrawColor(0, 0, 0);
$pdf->SetLineWidth(0.1);
$pdf->SetMargins(20, 10, 10);  // G, H, D
$pdf->setHeader($titre, "../img/logo.jpg");
$uneDate = DateFr::getDateDuJour();
$txtPied = utf8_decode("Date d'édition  : " . $uneDate->toFormatLong());
$pdf->setFooter($txtPied);
$pdf->AliasNbPages();
$pdf->AddPage();

$lesColonnes = [utf8_decode('Catégories'), 'Code', utf8_decode('Age entre'), utf8_decode('et'), utf8_decode('Né(e) entre'), utf8_decode('et'), 'Distance maximale'];
$lesTailles = [30, 10, 20, 20, 20, 20, 30];
$lesAlignements = ['L', 'C', 'C', 'C', 'C', 'C', 'L'];
$marge = 20;
$interligne = 5;
$taillePolice = 8;
$lesEncadrementsE = ['TLB', 'TB', 'TB', 'TB', 'TB', 'TB', 'TBR'];
$lesEncadrementsL = ['L', '0', '0', '0', '0', '0', 'R'];
$pdf->Ln(5);
$pdf->ImpressionEnteteTableau($lesColonnes, $lesTailles, $lesEncadrementsE, $lesAlignements, $marge, $taillePolice);
$fill = 0;

foreach ($lesCategories as $categorie) {
    $row[0] = $categorie['nom'];
    $row[1] = $categorie['id'];
    $row[2] = $categorie['ageMin'];
    $row[3] = $categorie['ageMax'];
    $row[4] = $annee - $categorie['ageMax'];
    $row[5] = $annee - $categorie['ageMin'];
    $row[6] = utf8_decode($categorie['distanceMax']);
    for ($i = 0; $i < 7; $i++) {
        $pdf->Cell($lesTailles[$i], $interligne, $row[$i], $lesEncadrementsL[$i], 0, $lesAlignements[$i], $fill);
    }
    $pdf->Ln();
    $pdf->setx($marge);
}
$pdf->Cell(array_sum($lesTailles), 0, '', 'T'); // trace le trait de fermeture du tableau

$nomPdf = "liste des categories.pdf";
$pdf->Output($nomPdf, 'D');
die();

