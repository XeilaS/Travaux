<?php
require '../../class/class.database.php';
$db = Database::getInstance();
$sql = <<<EOD
    SELECT id ,nom, date_format(date, '%d/%m/%Y') as dateCourse,distance ,nbParticipant, 
    concat(year(date), ' - ', nom, ' - ', distance, '.pdf') as fichier, 1 as present 
    FROM classement;
    
EOD;
$curseur = $db->query($sql);
$lesLignes = $curseur->fetchAll(PDO::FETCH_ASSOC);
$curseur->closeCursor();

// vérification de l'existence du fichier correspondant
$nb = count($lesLignes);
for ($i = 0; $i < $nb; $i++) {
    if (!file_exists('../../archive/' . $lesLignes[$i]['fichier'])) {
       $lesLignes[$i]['present'] = 0;
    }
}
echo json_encode($lesLignes);