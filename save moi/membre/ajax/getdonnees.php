<?php

require '../../class/class.database.php';
$db = Database::getInstance();

$sql = <<<EOD
   Select id, nom, prenom, email, montantLicence, fixe, mobile, photo
   from membre
   order by nom, prenom;
EOD;
$curseur = $db->query($sql);
$lesMembres = $curseur->fetchAll(PDO::FETCH_ASSOC);
$curseur->closeCursor();
echo json_encode($lesMembres);