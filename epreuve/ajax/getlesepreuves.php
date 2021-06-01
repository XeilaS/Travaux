<?php
require '../../class/class.database.php';
$db = Database::getInstance();
$sql = <<<EOD
    SELECT id, nom, description, date_format(date, '%d/%m/%Y') as date, date as dateMySQL
    FROM epreuve
    WHERE date > current_date
    ORDER BY dateMySQL;
EOD;
$curseur = $db->query($sql);
$lesEpreuves = $curseur->fetchAll(PDO::FETCH_ASSOC);
$curseur->closeCursor();
$lesLignes = [];
foreach ($lesEpreuves as $epreuve) {

// ajout du club dans le résultat à retourner
    $lesLignes[] = $epreuve;
}

echo json_encode($lesLignes);