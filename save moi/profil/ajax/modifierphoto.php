<?php
/** @noinspection DuplicatedCode */
// contrôle de l'existence des paramètres attendus
if (!isset($_FILES['fichier'])) {
    echo "Demande incomplète";
    exit;
}

session_start();

// récupération des données transmises
$tmp = $_FILES['fichier']['tmp_name'];
$nomFichier = $_FILES['fichier']['name'];
$type = $_FILES['fichier']['type'];

// Définition des contraintes à respecter
$lesExtensions = ["jpg", "png", "gif"];
$lesTypes = ["image/pjpeg", "image/jpeg", "x-png", "image/gif", "image/png"];
$type = mime_content_type($tmp);
$largeurMax = 150;
$hauteurMax = 150;

// vérification de l'extension
$extension = pathinfo($nomFichier, PATHINFO_EXTENSION);
if (!in_array($extension, $lesExtensions)) {
    echo "Extension du fichier non acceptée";
    exit;
}

// vérification du type MIME
if (!in_array($type, $lesTypes)) {
    echo "Type de fichier non accepté";
    exit;
}

// vérification des dimensions de l'image
$lesDimensions = getimagesize($tmp);
if ($lesDimensions[0] > $largeurMax || $lesDimensions[1] >$hauteurMax) {
    echo "Les dimensions de l'image dépassent les dimensions autorisées";
    exit;
}

// il faut récupérer le nom de l'ancienne photo pour la supprimer si elle existe vraiment (possibilité d'incohérence entre la table et le répertoire)

require '../../class/class.database.php';
$db = Database::getInstance();

$sql = <<<EOD
        SELECT photo
        FROM membre
        where id = :id;
EOD;
$curseur = $db->prepare($sql);
$curseur->bindParam('id', $_SESSION['membre']['id']);
$curseur->execute();
$ligne = $curseur->fetch(PDO::FETCH_ASSOC);
$curseur->closeCursor();


$repertoire = "../photo";

if ($ligne['photo']){
    $suppression  = file_exists($repertoire . "/" . $ligne['photo']);
} else{
    $suppression  = false;
}


// Ajout éventuel d'un suffixe sur le nom de la nouvelle photo en cas de doublon
$nom = pathinfo($nomFichier, PATHINFO_FILENAME);
$i = 1;
while (file_exists("$repertoire/$nomFichier")) $nomFichier = "$nom(" . $i++ . ").$extension";


$sql = <<<EOD
    update membre
        set photo = :photo
    where id = :id;
EOD;
$curseur = $db->prepare($sql);
$curseur->bindParam('id', $_SESSION['membre']['id']);
$curseur->bindParam('photo', $nomFichier);
try {
    $curseur->execute();
    copy($tmp, "$repertoire/$nomFichier");
    // suppression de l'ancienne photo
    if($suppression) {
        @unlink($repertoire . "/" . $ligne['photo']);
    }
    echo 1;
} catch (Exception $e) {
    echo $e->getMessage();
}