<?php
// il faut être admin
session_start();
if (!isset($_SESSION['membre']) ||  $_SESSION['membre']['admin'] === 0) {
    echo "Accès interdit";
    exit;
}
require '../../class/class.database.php';
$db = Database::getInstance();

if ($_POST["ajout"] == 1) {
    $sql = <<<EOD
	    insert into droit (idAdministrateur, idFonction) values 
		    (:idAdministrateur, :idFonction)
EOD;

} else {
    $sql = <<<EOD
        delete from droit 
	    where idAdministrateur = :idAdministrateur
        and idFonction = :idFonction;
EOD;
}
$curseur = $db->prepare($sql);
$curseur->bindParam('idAdministrateur', $_POST["idAdministrateur"]);
$curseur->bindParam('idFonction', $_POST["idFonction"]);
$curseur->execute();
echo 1;

