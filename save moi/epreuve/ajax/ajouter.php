<?php
require '../../include/fonction.php';
require '../../class/class.database.php';
$db = Database::getInstance();
if (!estAutorise(21, $db)) {
    echo "Accès interdit";
    exit;
}

require '../../class/class.controle.php';

$nom = $_POST['nom'];
$description = $_POST['description'];
$date = $_POST['date'];

// unicité de la date

$sql = <<<EOD
Select 1 From epreuve Where date = :date
EOD;
$curseur = $db->prepare($sql);
$curseur->bindParam('date', $date);
$curseur->execute();
$ligne = $curseur->fetch();
$curseur->closeCursor();
if ($ligne) {
    echo "Il existe déjà une course à cette date.";
    exit();
}


// unicite du nom

$sql = <<<EOD
Select 1 From epreuve Where nom = :nom
EOD;
$curseur = $db->prepare($sql);
$curseur->bindParam('nom', $nom);
$curseur->execute();
$ligne = $curseur->fetch();
$curseur->closeCursor();
if ($ligne) {
    echo "Il existe déjà une course avec ce nom.";
    exit();
}


$sql = <<<EOD
insert into epreuve(nom, description, date)
values (:nom, :description, :date);
EOD;
$curseur = $db->prepare($sql);
$curseur->bindParam('nom', $nom);
$curseur->bindParam('description', $description);
$curseur->bindParam('date', $date);
try {
    $curseur->execute($_POST);
    echo 1;
} catch(Exception $e) {
    echo $e->getMessage();
}
