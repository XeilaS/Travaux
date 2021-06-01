<?php
require '../../include/fonction.php';
require '../../class/class.database.php';
$db = Database::getInstance();
if (!estAutorise(22, $db)) {
    echo "Accès interdit";
    exit;
}

require '../../class/class.controle.php';
if (!Controle::existe('nom', 'description', 'id', 'date')) {
    echo "Paramètres manquants";
    exit;
}
$id = $_POST['id'];
$nom = $_POST['nom'];
$description = $_POST['description'];
$date = $_POST['date'];

$annee = date("Y");
$max = $annee - 14 . "-12-31";
$min = $annee - 80 . "-01-01";


$sql = <<<EOD
update epreuve
set nom = :nom, description = :description, date = :date
where id = :id;
EOD;
$curseur = $db->prepare($sql);
try {
    $curseur->execute($_POST);
    if ($curseur->rowCount() === 0)
        echo "Aucune modification constatée";
    else
        echo 1;
} catch(Exception $e) { echo $e->getMessage(); }
