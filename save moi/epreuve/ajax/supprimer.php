<?php
require '../../include/fonction.php';
require '../../class/class.database.php';
$db = Database::getInstance();
if (!estAutorise(22, $db)) {
    echo "Accès interdit";
    exit;
}

if (!isset($_POST['id'])) {
    echo "Paramètre manquant";
    exit;
}

$id = $_POST['id'];
$sql = <<<EOD
DELETE FROM epreuve
WHERE id = :id;
EOD;
$curseur = $db->prepare($sql);
$curseur->bindParam('id', $id);
try {
    $curseur->execute();
    echo 1;
} catch(Exception $e) {
    echo $e->getMessage();
}