<?php
require '../../class/class.database.php';
$db = Database::getInstance();

$sql = <<<EOD
    SELECT id, concat(nom, ' ', prenom) as NomPrenom
   from coureur;
EOD;
$curseur = $db->query($sql);
$lesLignes = $curseur->fetchAll(PDO::FETCH_ASSOC);
$curseur->closeCursor();
echo json_encode($lesLignes);