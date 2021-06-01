<?php
session_start();
// contrôle du droit d'accès
if (!isset($_SESSION['membre'])) {
    echo "Accès non autorisé";
    exit;
}

$id = $_SESSION['membre']['id'];
$passwordActuel = $_POST["passwordActuel"];
$password = $_POST["password"];

require '../../class/class.database.php';
$db = Database::getInstance();

// vérification du mot de passe actuel
$sql = <<<EOD
   Select 1 from membre 
   where password = :password
   and id = :id;
EOD;
$curseur = $db->prepare($sql);
$curseur->bindParam('id', $id);
$curseur->bindParam('password', $passwordActuel);
$curseur->execute();
$ligne = $curseur->fetch(PDO::FETCH_ASSOC);
$curseur->closeCursor();
if (!$ligne) {
    echo "Mot de passe actuel erroné";
    exit;
}

// Mise à jour du mot de passe
$sql = <<<EOD
   update membre
    	set password = :password
   where id = :id;
EOD;
$curseur = $db->prepare($sql);
$curseur->bindParam('id', $id);
$curseur->bindParam('password', $password);
$curseur->execute();
$curseur->closeCursor();

echo 1;
