<?php
// il faut être admin
session_start();
if (!isset($_SESSION['membre']) ||  $_SESSION['membre']['admin'] === 0) {
    echo "Accès interdit";
    exit;
}
require '../../class/class.database.php';
$db = Database::getInstance();

$sql = <<<EOD
    Select idFonction
    from droit 
    where idAdministrateur = :idAdministrateur
EOD;
$curseur = $db->prepare($sql);
$curseur->execute($_POST);
$lesLignes = $curseur->fetchAll(PDO::FETCH_ASSOC);
$curseur->closeCursor();
echo json_encode($lesLignes);
