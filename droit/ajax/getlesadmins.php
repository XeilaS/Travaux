<?php
// il faut être admin
session_start();
if (!isset($_SESSION['membre']) ||  $_SESSION['membre']['admin'] === 0) {
    echo "Accès interdit";
    exit;
}

require '../../class/class.database.php';
$db = Database::getInstance();

// récupération des nom des admin
$sql = <<<EOD
        Select nom, prenom, administrateur.id
        from membre, administrateur
        where membre.id = administrateur.id
        order by nom;
EOD;
$curseur = $db->query($sql);
$lesLignes = $curseur->fetchAll(PDO::FETCH_ASSOC);
$curseur->closeCursor();
$lesDonnees['lesAdmins'] = $lesLignes;

// récupération des compétences d'administration
$sql = <<<EOD
        Select id, nom, description
        from fonction
        order by id;
EOD;
$curseur = $db->query($sql);
$lesLignes = $curseur->fetchAll(PDO::FETCH_ASSOC);
$curseur->closeCursor();
$lesDonnees['lesFonctions'] = $lesLignes;
echo json_encode($lesDonnees);
