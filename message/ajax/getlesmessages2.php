<?php
require '../../include/fonction.php';
require '../../class/class.database.php';
$db = Database::getInstance();
if (!estAutorise(35, $db)) {
    echo "Accès interdit";
    exit;
}

$sql = <<<EOD
    Select email
    from message
    order by email;
EOD;

$curseur = $db->query($sql);
$lesLignes = $curseur->fetchAll(PDO::FETCH_ASSOC);
$curseur->closeCursor();
$lesDonnees['lesMessages'] =$lesLignes;




$sql = <<<EOD
    Select email
    from message
    where reponse is null
    order by email;
EOD;

$curseur = $db->query($sql);
$lesLignes = $curseur->fetchAll(PDO::FETCH_ASSOC);
$curseur->closeCursor();
$lesDonnees['lesEmails'] = $lesLignes;





/*
$curseur = $db->prepare($sql);
$curseur->execute();
$lesDonnees = $curseur->fetchAll(PDO::FETCH_ASSOC);
$lesMessages['lesMessages'] = $lesDonnees;
$curseur->closeCursor();
echo json_encode($lesMessages);
*/





























/*
session_start();

// le membre est il bien connecté
if (!isset($_SESSION['membre'])) {
    echo "Accès non autorisé";
    exit;
}
// le membre a t'il un droit d'accès sur cette fonction
$path = '../';
$idFonction = 35;
require '../../include/fonction.php';


require '../../class/class.database.php';
$db = Database::getInstance();


$sql = <<<EOD
    Select message
    from message
    where reponse is null;
EOD;

$curseur = $db->query($sql);
$lesMessages = $curseur->fetchAll(PDO::FETCH_ASSOC);
$curseur->closeCursor();
echo json_encode($lesMessages);
*/