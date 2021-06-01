<?php
session_start();

// contrôle du droit d'accès
if (!isset($_SESSION['membre'])) {
    echo "Accès non autorisé";
    exit;
}

require '../../class/class.database.php';
$db = Database::getInstance();

$id = $_SESSION['membre']['id'];

$sql = <<<EOD
   Select nom, prenom, email, fixe, mobile, photo, abtInformation, autMail
   from membre
   where id = :id;
EOD;
$curseur = $db->prepare($sql);
$curseur->bindParam("id", $id);
$curseur->execute();
$leMembre = $curseur->fetchAll(PDO::FETCH_ASSOC);
$curseur->closeCursor();

// vérification de la photo
$repertoire = "../photo";


if ($leMembre[0]['photo']) {

    $repertoire = "../photo";

    if (!file_exists($repertoire . "/" . $leMembre[0]['photo']))
        $leMembre['photo'] = 'absent.png';
}

echo json_encode($leMembre[0]);