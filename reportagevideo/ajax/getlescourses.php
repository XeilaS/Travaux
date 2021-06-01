<?php
require '../../class/class.database.php';
$db = Database::getInstance();
//récupération des données
$sql = <<<EOD
   SELECT id, concat(distance, ' ', lcase(saison), ' ', year(date)) as libelle
    FROM course
    Order By date desc limit 3;
EOD;

$curseur = $db->query($sql);
$lesLignes = $curseur->fetchAll(PDO::FETCH_ASSOC);
$curseur->closeCursor();

echo json_encode($lesLignes);
