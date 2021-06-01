<?php
// Récupération de l'ensemble des données sur les pages statiques

// vérification de l'accès
require '../../include/fonction.php';
require '../../class/class.database.php';
$db = Database::getInstance();
if (!estAutorise(1, $db)) {
    echo "Accès interdit";
    exit;
}
$sql =<<<EOD
          Select id, nom, contenu 
          from page
          order by nom;
EOD;
$curseur = $db->query($sql);
$lesLignes = $curseur->fetchAll(PDO::FETCH_ASSOC);
$curseur->closeCursor();

echo json_encode($lesLignes);
