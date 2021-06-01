<?php
require '../../include/fonction.php';
require '../../class/class.database.php';
$db = Database::getInstance();
if (!estAutorise(16, $db)) {
    echo "Accès interdit";
    exit;
}

if (!isset($_POST['id'])) {
    echo "Demande incomplète";
    exit;
}

// récupération des valeurs transmises
$id = $_POST['id'];

$sql = <<<EOD
delete from classement where id = :id;
EOD;

$curseur = $db->prepare($sql);
$curseur->bindParam(':id', $id);
try {
    $curseur->execute();
// suppression du fichier dans le répertoire document
    $nomFichier = "doc$id.pdf";
    $repertoire = "../document";
    echo 1;
} catch(Exception $e) {
    echo $e->getMessage();
}


