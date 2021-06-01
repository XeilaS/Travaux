<?php
// chargement des informations du document
//require "../../class/class.datefr.php";
require '../../class/class.database.php';
session_start();

$db = Database::getInstance();

date_default_timezone_set('Europe/Paris');
$id = $_SESSION['membre']['id'];
$sql = <<<EOD
    SELECT nom, prenom, montantLicence, saison
        FROM membre
    where id = :id;	
EOD;
$curseur = $db->prepare($sql);
$curseur->bindParam('id', $id);
$curseur->execute();
$ligne = $curseur->fetch();
$curseur->closeCursor();

$nom =  strtoupper(utf8_decode(ucfirst($ligne['nom'])));
$prenom =  strtoupper(utf8_decode(ucfirst($ligne['prenom'])));
$montant = $ligne['montantLicence'];
$saison = $ligne['saison'];




// création et initialisation du modéle
require "../../class/fpdf/class.pdf.php";
// génération des éléments communs de chaque lettre
$pdf = new PDF('P', 'mm', 'A4');
$pdf->AddPage();
$pdf->SetFont($pdf->getPolice(), '', 12);
$pdf->SetMargins(25, 15 , 25);  // G, H, D
$pdf->image('../img/logo.jpg', 25, 15, 50);

$pdf->text(25, 70, "Adresse postale :");
$pdf->text(25, 75, "Amicale du Val de Somme");
$pdf->text(25, 80, utf8_decode(ucfirst("Maison des associations d'Amiens Métropole")));
$pdf->text(25, 85, utf8_decode(ucfirst("12, rue Fréderic Petit")));
$pdf->text(25, 90, "80000 Amiens");

$pdf->text(160, 130, "Le" . " " . date("d/m/Y"));

$pdf->text(25, 155, "Destinataire :" . " " . $nom . " " . $prenom);

$pdf->text(80, 175, "COTISATION et LICENCE FFA pour la saison" . " " . $saison);


$pdf->setxy(130, $pdf->GetPageHeight() - 60);
$pdf->cell(0, 7, utf8_decode("Le Président"), 0, 2);
$pdf->cell(0,7, "Dominique Lazure");
$pdf->image('../img/signature.jpg', 110, 260, 50);


$corps = <<<EOD
Je soussigné certifie que $nom $prenom est titulaire d'une licence FFA au club Amicale du Val de Somme.

Le montant de la cotisation annuelle s'élève à $montant euros pour la saison sportive qui couvre la période du premier septembre 2020 au 31 août 2021.

EOD;

$pdf->setxy(35, 185);
$pdf->multicell(0, 7, utf8_decode($corps), 0, 'J' , false);
$pdf->Output("F", "../document/attestation" . $nom . $prenom . ".pdf");
echo 1;