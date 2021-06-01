<?php
session_start();
// contrôle du droit d'accès
if (!isset($_SESSION['membre'])) {
    echo "Accès non autorisé";
    exit;
}

require '../../class/class.database.php';
$db = Database::getInstance();

$id = $_SESSION['membre']['id'];

// contrôle de l'existence des données transmises
if (!isset($_POST['password'])) {
    echo "Paramètre manquant.";
    exit();
}

// récupérer les données transmises
$password = $_POST['password'];

// contrôle des données transmises

if(!preg_match('`.{4,}$`', $password)) {
    echo "Ce mot de passe est trop court";
    exit();
}

$password = $_POST["password"];

// vérification du mot de passe actuel
$sql = <<<EOD
   Select 1 from membre 
   where password = :password
   and id = :id;
EOD;
$curseur = $db->prepare($sql);
$curseur->bindParam('id', $id);
$curseur->bindParam('password', $password);
$curseur->execute();
$ligne = $curseur->fetch(PDO::FETCH_ASSOC);
$curseur->closeCursor();
if (!$ligne)
    echo "Mot de passe actuel erroné";
else
    echo 1;