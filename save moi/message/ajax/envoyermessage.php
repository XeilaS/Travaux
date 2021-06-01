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


if (!isset($_POST['email']) || !isset($_POST['nom'])
    || !isset($_POST['description']))  {
    echo "Paramètres manquants 1";
    exit;
}

// récupération des valeurs transmises
$nom = $_POST["nom"];
$email = $_POST["email"];
$description = $_POST["description"];

//génération de la requête
require '../../class/class.database.php';
$db = Database::getInstance();
$sql = <<<EOD
insert into message(nomPrenom, email, message, dateCreation) values 
(:nom, :email, :description, now())
EOD;
;
$curseur = $db->prepare($sql);
$curseur ->bindParam('nom', $nom);
$curseur ->bindParam('email', $email);
$curseur ->bindParam('description', $description);
try {
    $curseur->execute();
    echo 1;
} catch(Exception $e) {
    echo $e->getMessage();
}
