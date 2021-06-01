<?php
//supprimer est utilisée dans la gestion des liens par un utilisateur autorisée ou l'admin il est donc appelée dans index.js

// vérification de l'accès
require '../../include/fonction.php';
require '../../class/class.database.php';
$db = Database::getInstance();
if (!estAutorise(30, $db)) {
    echo "Accès interdit";
    exit;
}
if (!isset($_POST['id'])) {
    echo "Paramètre manquant";
    exit;
}

//veérification des données et suppression
$id = $_POST['id'];
$sql = <<<EOD
    DELETE FROM lien
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