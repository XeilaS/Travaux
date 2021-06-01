<?php
// mise à jour du contenu de la page dont l'id est transmis

// vérification de l'accès
require '../../include/fonction.php';
require '../../class/class.database.php';
$db = Database::getInstance();
if (!estAutorise(1, $db)) {
    echo "Accès interdit";
    exit;
}

// vérification des paramètres
if (!isset($_POST['id']) || !isset($_POST['valeur'])) {
    echo "Paramètres manquants";
    exit;
}


$id = $_POST['id'];
$valeur = $_POST['valeur'];

$sql = <<<EOD
          UPDATE page
          SET contenu = :valeur 
          WHERE id = :id;
EOD;
$curseur = $db->prepare($sql);
$curseur->bindParam('valeur', $valeur);
$curseur->bindParam('id', $id);
try {
    $curseur->execute();
    echo 1;
} catch (Exception $e) {
    echo $e->getMessage();
}


