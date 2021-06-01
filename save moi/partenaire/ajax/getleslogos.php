<?php
require '../../class/class.database.php';
$db = Database::getInstance();
$sql = <<<EOD
    SELECT id, nom, domaine, logo
    FROM partenaire
    order by nom;
    EOD;

$curseur = $db->query($sql);
$lespartenaires = $curseur->fetchAll(PDO::FETCH_ASSOC);
$curseur->closeCursor();
$lesLignes = [];
$rep = '../logo/';
foreach ($lespartenaires as $partenaire) {
    // vérification de l'existence du logo
    $nomFichier = $rep . $partenaire['logo'];
    if (file_exists($nomFichier))
        $partenaire['logo'] = $nomFichier;
    else
        $partenaire['logo'] = 'logoabsent.jpg';
    // ajout du club dans le résultat à retourner
    $lesLignes[] = $partenaire;
}
echo json_encode($lesLignes);
