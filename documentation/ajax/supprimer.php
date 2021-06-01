<?php

require '../../class/class.database.php';
$db = Database::getInstance();

//veérification des données et suppression
$id = $_POST['id'];
$sql = <<<EOD
    DELETE FROM document
    WHERE id = :id;
EOD;
$curseur = $db->prepare($sql);
$curseur->bindParam('id', $id);
try {
    $curseur->execute();
    @unlink('../../document/doc' + id + '.pdf');
    echo 1;
} catch (Exception $e) {
    echo $e->getMessage();
}