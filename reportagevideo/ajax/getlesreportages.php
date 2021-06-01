<?php
require '../../class/class.database.php';
$db = Database::getInstance();
//récupération des données
$sql = <<<EOD
   SELECT reportageVideo.id, concat(distance, ' ', lcase(saison), ' ', year(date), ' ', ifnull(niveau,' ')) as libelle, url
    FROM reportageVideo join course on course.id = reportageVideo.idCourse
    Order By date desc;
EOD;

$curseur = $db->query($sql);
$lesLignes = $curseur->fetchAll(PDO::FETCH_ASSOC);
$curseur->closeCursor();

echo json_encode($lesLignes);
