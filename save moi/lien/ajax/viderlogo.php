<?php

// vérification de l'accès
require '../../include/fonction.php';
require '../../class/class.database.php';
$db = Database::getInstance();
if (!estAutorise(30, $db)) {
    echo "Accès interdit";
    exit;
}


if (!isset($_POST['id']) ) {
    echo "Paramètre manquant";
    exit;
}

// récupération des données
$id = $_POST["id"];

// récupérer le nom du fichier pour le supprimer physiquement
$sql = <<<EOD
   Select logo
   FROM lien
   WHERE id = :id;
EOD;
$curseur = $db->prepare($sql);
$curseur->execute($_POST);
$ligne = $curseur->fetch(PDO::FETCH_ASSOC);
$curseur->closeCursor();

// requête standard de mise à jour d'une colonne d'une table pour un enregistrement
$sql = <<<EOD
    update lien
        set logo = null
    where id = :id;
EOD;
$curseur = $db->prepare($sql);
$curseur->bindParam('id', $id);
try {
    $curseur->execute();
    // suppression de la photo
    @unlink("../logo/" . $ligne['logo']);
    echo 1;
} catch(Exception $e) {
    echo $e->getMessage();
}