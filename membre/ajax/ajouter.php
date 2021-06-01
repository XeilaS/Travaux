<?php


require '../../class/class.database.php';
$db = Database::getInstance();

$nom = $_POST["nom"];
$prenom = $_POST["prenom"];
$email = $_POST["email"];
$montantLicence = $_POST["montant"];
$password = $_POST["password"];

if (!isset($nom, $email, $montantLicence, $password)) {
    echo "Parametres manquants";
    exit;
}

$sql = <<<EOD
   Insert into membre (nom, prenom, email, montantLicence, password, saison, login)
   values (:nom, :prenom, :email, :montantLicence, :password, '2021', :nom);
EOD;
$curseur = $db->prepare($sql);
$curseur->bindParam('nom', $nom);
$curseur->bindParam('prenom', $prenom);
$curseur->bindParam('email', $email);
$curseur->bindParam('montantLicence', $montantLicence);
$curseur->bindParam('password', $password);
$curseur->execute();
$curseur->closeCursor();

echo 1;
