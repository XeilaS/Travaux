<?php
//ajouter est uniquement utilisée pour l'ajout d'information et donc sera appelé dans ajout.js
// vérification de l'accès
require '../../include/fonction.php';
require '../../class/class.database.php';
$db = Database::getInstance();
if (!estAutorise(29, $db)) {
    echo "Accès interdit";
    exit;
}


if (!isset($_POST['rang']) ||!isset($_POST['nom']) ||!isset($_POST['description']) ||!isset($_POST['url'])){
    echo "Paramètres manquants";
    exit;
}

require '../../class/class.controle.php';
if (!Controle::existe('nom', 'description', 'url', 'rang')) {
    echo "Paramètres manquants";
    exit;
}

// Données
$rang = $_POST['rang'];
$nom = $_POST['nom'];
$description = $_POST['description'];
$url = $_POST['url'];


// controle de l'unicité

$sql = <<<EOD
Select 1 From lien Where nom = :nom
EOD;
$curseur = $db->prepare($sql);
$curseur->bindParam('nom', $nom);
$curseur->execute();
$ligne = $curseur->fetch();
$curseur->closeCursor();
if ($ligne) {
    echo "Un lien de même nom existe déjà";
    exit();
}

// si le logo a été transmis
if (isset($_FILES['fichier'])) {
    // récupération des données transmises
    $tmp = $_FILES['fichier']['tmp_name'];
    $nomFichier = $_FILES['fichier']['name'];
    $repertoire = "../logo";

    // Définition des contraintes à respecter
    $lesExtensions = ["jpg", "png", "gif"];
    $lesTypes = ["image/pjpeg", "image/jpeg", "x-png", "image/gif", "image/png"];
    $largeurMax = 200;
    $hauteurMax = 200;

    // vérification de l'extension
    $extension = pathinfo($nomFichier, PATHINFO_EXTENSION);
    if (!in_array($extension, $lesExtensions)) {
        echo "Extension du fichier non acceptée";
        exit;
    }

    // vérification du type MIME
    $type = mime_content_type($tmp);
    if (!in_array($type, $lesTypes)) {
        echo "Type de fichier non accepté";
        exit;
    }

    // vérification des dimensions de l'image
    $lesDimensions = getimagesize($tmp);
    if ($lesDimensions[0] > $largeurMax || $lesDimensions[1] > $hauteurMax) {
        echo "Les dimensions de l'image dépassent les dimensions autorisées";
        exit;
    }

    // Ajout éventuel d'un suffixe sur le nom de la nouvelle photo en cas de doublon
    $nom = pathinfo($nomFichier, PATHINFO_FILENAME);
    $i = 1;

    while (file_exists("$repertoire/$nomFichier")) $nomFichier = "$nom(" . $i++ . ").$extension";

    // la copie sur le serveur sera réalisée si la requête d'ajout réussit

}

// requête d'ajout

if ($nomFichier !== '') {
    if (empty($description)) {
        $sql = <<<EOD
           INSERT INTO lien (nom, url, rang, logo)
            values (:nom, :url, :rang, :logo);
EOD;
    } else {
        $sql = <<<EOD
           INSERT INTO lien (nom, description, url, rang, logo)
            values (:nom, :description, :url, :rang, :logo);
EOD;
    }
} else {
    if (empty($description)) {
        $sql = <<<EOD
           INSERT INTO lien (nom, url, rang)
            values (:nom, :url, :rang);
EOD;
    } else {
        $sql = <<<EOD
           INSERT INTO lien (nom, description, url, rang)
            values (:nom, :description, :url, :rang);
EOD;
    }
}
$curseur = $db->prepare($sql);
$curseur->bindParam('nom', $nom);
$curseur->bindParam('url', $url);
$curseur->bindParam('rang', $rang);

if ($nomFichier !== '') $curseur->bindParam('logo', $nomFichier);
if (!empty($description)) $curseur->bindParam('description', $description);

try {
    $curseur->execute();
    if (isset($_FILES['fichier'])) {
        copy($tmp, "$repertoire/$nomFichier");
    }
    echo 1;
} catch (Exception $e) { echo $e->getMessage(); }
