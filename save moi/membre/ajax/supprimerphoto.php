<?php
session_start();
// contrôle du droit d'accès
if (!isset($_SESSION['membre'])) {
    echo "Accès non autorisé";
    exit;
}
$id = $_POST['id'];
require '../../class/class.database.php';
$db = Database::getInstance();

// récupérer le nom du fichier pour le supprimer physiquement
$sql = <<<EOD
   Select photo
   FROM membre
   WHERE id = :id;
EOD;
$curseur = $db->prepare($sql);
$curseur->bindParam('id', $id);
$curseur->execute();
$ligne = $curseur->fetch(PDO::FETCH_ASSOC);
$curseur->closeCursor();


// requête standard de mise à jour d'une colonne d'une table pour un enregistrement
$sql = <<<EOD
    update membre
        set photo = null
    where id = :id;
EOD;
$curseur = $db->prepare($sql);
$curseur->bindParam('id', $id);
try {
    $curseur->execute();
    // suppression de la photo
    @unlink("../../profil/photo/" . $ligne['photo']);
    echo 1;
} catch(Exception $e) {
    echo $e->getMessage();
}