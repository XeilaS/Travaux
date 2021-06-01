<?php

require '../../include/fonction.php';
require '../../class/class.database.php';
$db = Database::getInstance();
if (!estAutorise(16, $db)) {
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


// requête de mise à jour
    $sql = <<<EOD
update classement
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