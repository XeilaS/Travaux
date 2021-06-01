<?php
require '../../class/class.database.php';
$db = Database::getInstance();

date_default_timezone_set('Europe/Paris');
// Données à imprimer sous forme de tableau
$sql = <<<EOD
   Select nom, prenom, email, montantLicence, fixe, mobile
   from membre
   order by nom, prenom;
EOD;

$curseur = $db->query($sql);
$lesLignes = $curseur->fetchAll(PDO::FETCH_ASSOC);
$curseur->closeCursor();

//paramètres de l'impression
$marge = 10;
$interligne = 6;
$taillePolice = 10;
$lesValeurs = ['Nom', utf8_decode('Prénom'), 'Email', 'Mobile', 'Fixe', 'Mt'];
$lesTailles = [30, 30, 60, 30, 30, 10];
$lesAlignements = ['L', 'L', 'L', 'C', 'C', 'C'];
$lesEncadrementsE = ['1', '1', '1', '1', '1', '1'];
$lesEncadrementsL = ['1', '1', '1', '1', '1', '1'];

// création du pdf et initialisation de la première page
//require "../../class/class.datefr.php";
require "../../class/fpdf/class.pdf.php";
$pdf = new PDF('P', 'mm', 'A4');
$pdf->SetFont($pdf->getPolice(), '', '10');
$pdf->SetFillColor(255, 255, 255); // 237 gris
$pdf->SetTextColor(0);
$pdf->SetDrawColor(0, 0, 0);
$pdf->SetLineWidth(0.1);
$pdf->SetMargins(10, 10 , 10);  // G, H, D
$pdf->setHeader("Gestion des Membres du " . date("d/m/Y"));
//$uneDate = date("d/m/Y");
$txtPied = utf8_decode("Date d'édition : " . date("d/m/Y"));
$pdf->setFooter($txtPied);
$pdf->AliasNbPages();
$pdf->AddPage();

// Génération du corps du document
$pdf->impressionEnteteTableau($lesValeurs, $lesTailles, $lesEncadrementsE, $lesAlignements, $marge, $taillePolice);
foreach ($lesLignes as $ligne) {
    $row[0] = utf8_decode($ligne["nom"]);
    $row[1] = utf8_decode($ligne["prenom"]);
    $row[2] = utf8_decode($ligne["email"]);
    $row[3] = ($ligne["mobile"] != null) ? $ligne["mobile"] : "-";
    $row[4] = ($ligne["fixe"] != null) ? $ligne["fixe"] : "-";
    $row[5] = $ligne["montantLicence"];
    // Génération d'un saut de page avec fermeture du tableau et réimpression titre et entête du tableau sur la nouvelle page
    if ($pdf->GetY() + 8 > $pdf->GetPageBreakTrigger()) {
        $pdf->AddPage();
        $pdf->impressionEnteteTableau($lesValeurs,  $lesTailles,  $lesEncadrementsE,  $lesAlignements,  $marge,  $taillePolice);
    }
    $nb = count($row);
    for ($i = 0; $i < $nb; $i++)
        $pdf->Cell($lesTailles[$i], $interligne, $row[$i], $lesEncadrementsL[$i], 0, $lesAlignements[$i], 0);
    $pdf->Ln();
    $pdf->setx($marge);
}
$pdf->Output("F", "../listePdf/listeMembres.pdf");
echo 1;