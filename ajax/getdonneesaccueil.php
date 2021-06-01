<?php
session_start();

require '../class/class.database.php';
$db = Database::getInstance();


$sql = <<<EOD
        Select id, titre, contenu, date_format(dateCreation, '%d/%m/%Y') as date, auteur, idType
        From information
        where dateCreation between curdate() - interval 2 month and curdate() 
        
EOD;
if (!isset($_SESSION['membre']['id'])) {
    $sql .= " and idType != 3";
}
$sql .= " Order by dateCreation desc;";
$curseur = $db->query($sql);
$lesLignes = $curseur->fetchAll(PDO::FETCH_ASSOC);
$curseur->closeCursor();

// ajout d'une clé 'fichier' pour savoir si une pièce est jointe à l'information doc/info$id.pdf
$rep = '../document';
for($i = 0; $i < count($lesLignes) ; $i++) {
    // vérification de l'existence du document associé
    $fichier = $rep . '/info' . $lesLignes[$i]['id'] . '.pdf';
    $lesLignes[$i]['fichier'] = file_exists($fichier) ? 1 : 0;
}
$lesDonnees['lesInformations'] = $lesLignes;

$sql = <<<EOD
        Select nom, date_format(date, '%d/%m/%Y') as dateFr, date, description
        From epreuve
        where date between curdate() and curdate() + interval 3 month
        order by date 
        limit 1;
EOD;
$curseur = $db->query($sql);
$ligne = $curseur->fetch(PDO::FETCH_ASSOC);
$curseur->closeCursor();
$lesDonnees['prochaineEpreuve'] = $ligne;

echo json_encode($lesDonnees);

