<?php
// vérification de l'accès
require '../../class/class.database.php';
$db = Database::getInstance();

if (!isset($_POST['id'])) {
    echo "Paramètre manquant";
    exit;
}

$id = $_POST['id'];
$sql = <<<EOD
    DELETE FROM partenaire
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