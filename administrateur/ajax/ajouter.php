<?php
// il faut être admin
session_start();
if (!isset($_SESSION['membre']) ||  $_SESSION['membre']['admin'] === 0) {
    echo "Accès interdit";
    exit;
}

if (!isset($_POST['id'])) {
    echo "Paramètres manquants";
    exit;
}

require '../../class/class.database.php';
$db = Database::getInstance();
$sql = <<<EOD
    insert into administrateur(id)
           values (:id);
EOD;
$curseur = $db->prepare($sql);
try {
    $curseur->execute($_POST);
    echo 1;
} catch(Exception $e) {
    echo $e->getMessage();
}
