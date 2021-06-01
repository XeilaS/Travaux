<?php
require '../../include/fonction.php';
require '../../class/class.database.php';
$db = Database::getInstance();
if (!estAutorise(16, $db)) {
    echo "Accès interdit";
    exit;
}



if (!isset($_FILES['fichier']) || !isset($_POST['dateEpreuve']) ||
    !isset($_POST['nomEpreuve']) || !isset($_POST['distance']) ||
    !isset($_POST['nbParticipant'])){
    echo "Il manque ou vous avez oublié de renseigner une zone de saisie";
    exit;
}
// récupération des valeurs transmises

$date = $_POST["dateEpreuve"];
$nom = $_POST["nomEpreuve"];
$distance = $_POST["distance"];
$nbParticipant = $_POST["nbParticipant"];



$tmp = $_FILES['fichier']['tmp_name'];
$nomFichier = $_FILES['fichier']['name'];
$taille = $_FILES['fichier']['size'];


// Définitions des contraintes à respecter

$tailleMax = 2 * 1024 * 1024;
$lesExtensions = ["pdf"];
$lesTypes = ["application/force-download", "application/pdf"];

// Vérification de la taille du fichier

if ($taille > $tailleMax) {
    echo "La taille du fichier dépasse la taille autorisée";
    exit;
}
// vérification de l'extension
$extension = pathinfo($nomFichier, PATHINFO_EXTENSION);
if (!in_array($extension, $lesExtensions)) {
    echo "Extension du fichier non acceptée";
    exit;
}
// contrôle du type mime du fichier
$type = mime_content_type($tmp);
if (!in_array($type, $lesTypes)) {
    echo "Type de fichier non accepté";
    exit;
}

//vérifier l'existence du classement
$sql = <<<EOD
Select * From classement Where date = :date and nom = :nom and distance = :distance and nbParticipant = :nbParticipant;
EOD;
$curseur = $db->prepare($sql);
$curseur->bindParam('date', $date);
$curseur->bindParam('nom', $nom);
$curseur->bindParam('distance', $distance);
$curseur->bindParam('nbParticipant', $nbParticipant);
$curseur->execute();
$ligne = $curseur->fetch();
$curseur->closeCursor();
if ($ligne) {
    echo "Un coureur de même nom et même prénom existe déjà";
    exit();
}



// ajout dans la table classement
$sql = <<<EOD
insert into classement(date , nom , distance , nbParticipant)
values(:date ,:nom , :distance , :nbParticipant);
EOD;
$curseur = $db->prepare($sql);
$curseur->bindParam('date', $date);
$curseur->bindParam('nom', $nom);
$curseur->bindParam('distance', $distance);
$curseur->bindParam('nbParticipant', $nbParticipant);
try {
    $curseur->execute();
    $id = $db->lastInsertId();
    $date = date("Y");
    $nomFichier = $date . ' - ' . $nom . ' - ' . $distance . '.pdf';
    $repertoire = "../../archive";
    copy($tmp, "$repertoire/$nomFichier");
    echo 1;
} catch (Exception $e) { echo $e->getMessage(); }

