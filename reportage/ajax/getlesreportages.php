<?php
require '../../class/class.database.php';
$db = Database::getInstance();
//récupération des données
$sql = <<<EOD
SELECT id, date_format(date, '%d/%m/%Y') as date, titre, url, year(date) as annee
FROM reportage
Order By date;
EOD;

$curseur = $db->query($sql);
$lesLignes = $curseur->fetchAll(PDO::FETCH_ASSOC);
$curseur->closeCursor();
$lesDonnees['lesReportages'] = $lesLignes;
//echo json_encode($lesLignes);

$sql = <<<EOD

    SELECT DISTINCT year(date) as annee
    FROM reportage
    ORDER BY date desc;
EOD;
$curseur = $db->query($sql);
$lesLignes = $curseur->fetchAll();
$curseur->closeCursor();
$lesDonnees['lesAnnees'] = $lesLignes;

echo json_encode($lesDonnees);
