<?php
require '../../class/class.database.php';
$db = Database::getInstance();

$sql = <<<EOD
    SELECT id, concat(date_format(date, '%d/%m/%Y'), ' - ', distance) as Libelle
   from course;
EOD;
$curseur = $db->query($sql);
$lesLignes = $curseur->fetchAll(PDO::FETCH_ASSOC);
$curseur->closeCursor();
echo json_encode($lesLignes);