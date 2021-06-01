<?php
//modifier est utilisée dans la gestion des liens par un utilisateur autorisées ou l'admin donc il est appelée dans index.js

// vérification de l'accès
require '../../include/fonction.php';
require '../../class/class.database.php';
$db = Database::getInstance();
if (!estAutorise(30, $db)) {
    echo "Accès interdit";
    exit;
}

if (!isset($_POST['colonne']) || !isset($_POST['valeur']) || !isset($_POST['id'])) {
    echo "Paramètre manquant";
    exit;
}
// récupération des données
$colonne = $_POST["colonne"];
$valeur = $_POST["valeur"];
$id = $_POST["id"];
$unicite = isset($_POST['unicite']) ? $_POST['unicite'] : 0;
// vérifier l'unicité de la valeur
if ($unicite) {
    $sql = <<<EOD
Select 1
From lien
Where $colonne = :valeur and id != :id
EOD;
    $curseur = $db->prepare($sql);
    $curseur->bindParam('valeur', $valeur);
    $curseur->bindParam('id', $id);
    $curseur->execute();
    $ligne = $curseur->fetch();
    $curseur->closeCursor();
    if ($ligne) {
        echo "Cette valeur est déjà attribuée à une autre carte";
        exit();
    }
}
// requête de mise à jour
$sql = <<<EOD
update lien
set $colonne = :valeur
where id = :id;
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