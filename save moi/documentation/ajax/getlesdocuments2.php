<?php
require '../../class/class.database.php';
$db = Database::getInstance();

$id = $_GET['idType'];

$sql = <<<EOD
    SELECT titre, idType, date_format(dateCreation,  '%d/%m/%Y') as date, type.id as idType
    FROM document, type
    where idType = :id;
EOD;

$curseur = $db->prepare($sql);
$curseur ->bindParam('id', $id);
$lesLignes = $curseur->fetch(PDO::FETCH_ASSOC);
$curseur->closeCursor();

$lesDonnees['lesDocuments'] = $lesLignes;