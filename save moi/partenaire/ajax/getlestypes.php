<?php
require '../../class/class.database.php';
$db = Database::getInstance();
$sql = <<<EOD
        Select id, nom
        from type
        order by nom;
EOD;
$curseur = $db->query($sql);
$lesLignes = $curseur->fetchAll(PDO::FETCH_ASSOC);
$curseur->closeCursor();
echo json_encode($lesLignes);