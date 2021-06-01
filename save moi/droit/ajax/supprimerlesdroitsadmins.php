<?php
session_start();

// il faut être admin
session_start();
if (!isset($_SESSION['membre']) ||  $_SESSION['membre']['admin'] === 0) {
    echo "Accès interdit";
    exit;
}

// contrôle des paramètres
if (!isset($_POST['idAdministrateur'])) {
    echo "Paramètre manquant";
    exit;
}

require '../../class/class.database.php';
$db = Database::getInstance();

// récupération des paramètres transmis
$idAdministrateur = $_POST['idAdministrateur'];


$sql = <<<EOD
	delete from droit
	where idAdministrateur = :idAdministrateur
EOD;
$curseur = $db->prepare($sql);
$curseur->bindParam('idAdministrateur', $idAdministrateur);
$curseur->execute();
echo 1;
