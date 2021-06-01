<?php
// il faut être admin
session_start();
if (!isset($_SESSION['membre']) ||  $_SESSION['membre']['admin'] === 0) {
    echo "Accès interdit";
    exit;
}
if (!isset($_POST['id'])) {
    echo "Demande incomplète";
    exit;
}
require '../../class/class.database.php';
$db = Database::getInstance();
$id = $_POST['id'];
$sql = <<<EOD
    delete from administrateur where id = :id;
EOD;
$curseur = $db->prepare($sql);
$curseur->bindParam(':id', $id);
$curseur->execute();
echo 1;
