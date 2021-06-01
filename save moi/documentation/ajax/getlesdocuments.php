<?php
require '../../class/class.database.php';
$db = Database::getInstance();

$idType = "";
if (!empty($_GET) && isset($_GET['idType']) && !empty($_GET['idType'])) {
    $idType = "and document.idType = " . $_GET['idType'];
}

$sql = <<<EOD
        SELECT document.id, titre, idType, date_format(dateCreation,  '%d/%m/%Y') as date, type.id as idType
        FROM document, type
        where document.idType = type.id
        $idType;
EOD;

$curseur = $db->query($sql);
$lesLignes = $curseur->fetchAll(PDO::FETCH_ASSOC);
$curseur->closeCursor();

$lesDonnees['lesDocuments'] = $lesLignes;


$sql = <<<EOD
   SELECT id, nom
    FROM type;
EOD;
$curseur = $db->query($sql);
$lesLignes = $curseur->fetchAll(PDO::FETCH_ASSOC);
$curseur->closeCursor();
$lesDonnees['lesTypes'] = $lesLignes;

echo json_encode($lesDonnees);
