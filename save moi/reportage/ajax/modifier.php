<?php
require '../../include/fonction.php';
require '../../class/class.database.php';
$db = Database::getInstance();
if (!estAutorise(19, $db)) {
    echo "Accès interdit";
    exit;
}

require '../../class/class.controle.php';


if (!isset($_POST['colonne']) || !isset($_POST['valeur']) || !isset($_POST['id'])) {
    echo "Paramètre manquant";
    exit;
}
/** Base de donnée **/

// récupération des données
$colonne = $_POST["colonne"];
$valeur = $_POST["valeur"];
$id = $_POST["id"];
$unicite = isset($_POST['unicite']) ? $_POST['unicite'] : 0;

/** requetes de mise a jour **/
$sql = <<<EOD
update reportage
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
