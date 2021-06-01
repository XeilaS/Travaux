<?php
// chargement de la bibliothèque
require '../../composant/phpExcel.php';
require '../../composant/PHPExcel/Writer/Excel2007.php';


require '../../class/class.database.php';
$db = Database::getInstance();
$sql = <<<EOD
   Select nom, prenom, email, fixe, mobile, montantLicence
   from membre
   order by nom, prenom;
EOD;
$curseur = $db->query($sql);
$lesMembres = $curseur->fetchAll(PDO::FETCH_ASSOC);
$curseur->closeCursor();

$unClasseurExcel = new phpExcel();
$unClasseurExcel->setActiveSheetIndex(0);
$uneFeuilleExcel= $unClasseurExcel->getActiveSheet();
$uneFeuilleExcel->setTitle('Membres');

$uneFeuilleExcel->getStyle('D')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$uneFeuilleExcel->getStyle('E')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$uneFeuilleExcel->getStyle('F')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

// génération de la première ligne
$uneFeuilleExcel->getRowDimension('1')->setRowHeight(20);

$uneFeuilleExcel->SetCellValue('A1', "Nom");
$uneFeuilleExcel->getColumnDimension('A')->setWidth(15);
$uneFeuilleExcel->SetCellValue('B1', "Prenom");
$uneFeuilleExcel->getColumnDimension('B')->setWidth(15);
$uneFeuilleExcel->SetCellValue('C1', "Email");
$uneFeuilleExcel->getColumnDimension('C')->setWidth(40);
$uneFeuilleExcel->SetCellValue('D1', "Fixe");
$uneFeuilleExcel->getColumnDimension('D')->setWidth(20);
$uneFeuilleExcel->SetCellValue('E1', "Mobile");
$uneFeuilleExcel->getColumnDimension('E')->setWidth(20);
$uneFeuilleExcel->SetCellValue('F1', "Montant");
$uneFeuilleExcel->getColumnDimension('F')->setWidth(10);

$numLigne = 2;
foreach ($lesMembres as $membre) {
    $uneFeuilleExcel->SetCellValue('A' . $numLigne, $membre['nom']);
    $uneFeuilleExcel->SetCellValue('B' . $numLigne, $membre['prenom']);
    $uneFeuilleExcel->SetCellValue('C' . $numLigne, $membre['email']);
    $uneFeuilleExcel->SetCellValue('D' . $numLigne, $membre['fixe']);
    $uneFeuilleExcel->SetCellValue('E' . $numLigne, $membre['mobile']);
    $uneFeuilleExcel->SetCellValue('F' . $numLigne, $membre['montantLicence']);
    $numLigne++;
}

$nomFichier = "membres.xlsx";
$unObjetWriter = new PHPExcel_Writer_Excel2007($unClasseurExcel);
$unObjetWriter->save($nomFichier);

// pour demander le téléchargement
header('Content-disposition:attachement; FileName=membres.xlsx');
header('Content-type: application/msexcel'); // nécessaire sous edge sinon s'ouvre dans le navigateur
readfile($nomFichier);
