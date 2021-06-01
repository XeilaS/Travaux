<?php
session_start();

// le membre est il bien connecté
if (!isset($_SESSION['membre'])){
    echo "Accès non autorisé";
    exit;
}
// le membre a t'il un droit d'accès sur cette fonction
$path = '../';
$idFonction = 35;
require '../../include/fonction.php';

require '../../class/class.database.php';
$db = Database::getInstance();

//récupération de l'email

$sql = <<<EOD
        Select email
        from message;
EOD;
$curseur = $db->query($sql);
$lesDonnees = $curseur->fetchAll(PDO::FETCH_ASSOC);
$curseur->closeCursor();
echo json_encode($lesDonnees);
