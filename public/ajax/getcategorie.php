<?php
// vérification des paramètres
if (!isset($_POST['dateNaissance']) || !isset($_POST['dateCourse'])) {
    echo "Paramètre manquant";
    exit;
}

// récupération des données transmises
$dateNaissance = $_POST['dateNaissance'];
$dateCourse = $_POST['dateCourse'];
$anneeN = substr($dateNaissance,0, 4);
$anneeC = substr($dateCourse,0, 4);
$mois = substr($dateCourse,5, 2);
$age = $anneeC - $anneeN;
require '../../class/class.database.php';

$db = Database::getInstance();
$sql = <<<EOD
        Select moisFfa 
        From parametre;
EOD;
$curseur = $db->query($sql);
$ligne = $curseur->fetch(PDO::FETCH_ASSOC);
$curseur->closeCursor();
$moisFfa = $ligne['moisFfa'];
if ($mois >= $moisFfa) $age = $age + 1;
$sql = <<<EOD
        Select id, nom, agemin, agemax,
               (select 
    date_format(:dateCourse, '%Y') - date_format(:dateNaissance, '%Y') - 
    (date_format(:dateCourse, '00-%m-%d') < date_format(:dateNaissance, '00-%m-%d'))) as age  
        From categorie
        where :age between agemin and agemax;
EOD;
$curseur = $db->prepare($sql);
$curseur->bindParam("age", $age);
$curseur->bindParam("dateCourse", $dateCourse);
$curseur->bindParam("dateNaissance", $dateNaissance);
$curseur->execute();
$ligne = $curseur->fetch(PDO::FETCH_ASSOC);
$curseur->closeCursor();
if($ligne) {
    echo json_encode($ligne);
} else {
    echo "Aucune catégorie correspondante, vous êtes trop jeune ou trop vieux";
}

