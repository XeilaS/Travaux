<?php


// contrôle de l'existence des paramètres attendus
if (!isset($_FILES['fichier']) || !isset($_POST['titre'])  || !isset($_POST['idType'])) {
    echo "Paramètre manquant";
    exit;
}
// récupération des données transmises
$idType = $_POST["idType"];
$titre = $_POST["titre"];

$tmp = $_FILES['fichier']['tmp_name'];
$nomFichier = $_FILES['fichier']['name'];
$taille = $_FILES['fichier']['size'];

// Définitions des contraintes à respecter
$tailleMax = 2 * 1024 * 1024;
$lesExtensions = ["pdf"];
$lesTypes = ["application/force-download", "application/pdf"];

// vérification de la taille
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
require '../../class/class.database.php';
$db = Database::getInstance();
// vérifier l'unicité du titre
$sql = <<<EOD
    Select 1
    From document
    Where titre = :titre
EOD;
$curseur = $db->prepare($sql);
$curseur->bindParam('titre', $titre);
$curseur->execute();
$ligne = $curseur->fetch();
$curseur->closeCursor();
if ($ligne) {
    echo "Un document ayant ce titre existe déjà";
    exit();
}

// ajout dans la table document
$sql = <<<EOD
insert into document(titre, idType, dateCreation)
values(:titre, :idType, current_date());
EOD;
$curseur = $db->prepare($sql);
$curseur->bindParam('titre', $titre);
$curseur->bindParam('idType', $idType);

try {
    $curseur->execute();
    $id = $db->lastInsertId();
    $nomFichier = "doc$id.pdf";
    $repertoire = "../../document";
    copy($tmp, "$repertoire/$nomFichier");
    echo 1;
} catch (Exception $e) { echo $e->getMessage(); }
