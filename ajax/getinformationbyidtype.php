<?php
session_start();

/*

//Le script est lancé au chargement du fichier ../consultation.js
// et permet le chargement des d'informations stokée dans la base de données

Objectif :
    Chargement des d'informations stokée dans la base de données

Fonctions appelante:
    ../consultation.js ( Au chargement )

table utilisé et / ou répertoire depuis la racine du site :
    Répertoire: document/
    Table: information(titre, contenu, auteur, idType, dateCreation)

Resultat envoyé :
    Si tout ce passe bien : $lesLignes,
    Si auncune information n'est retounré depuis la base de donnée : Cette page n'existe pas ou aucune information n'as été publié ses 2 derniers mois.,

Remarque :
    le fichier n'existe pas obligatoirement

*/

//Récupération du paramètre passé dans L'URL
$idType = $_GET["idType"];

//Préparation, execution de la requêtes permettant la récupération des information  de ses derniers mois
//en fonction de l'idType
require '../../class/class.database.php';
$db = Database::getInstance();
$sql = <<<EOD
        Select id, titre, contenu, date_format(dateCreation, '%d/%m/%Y') as date, auteur, idType
        From information
        where dateCreation between curdate() - interval 2 month and curdate()
        and idType = :idType;
EOD;
$curseur = $db->prepare($sql);
$curseur->bindParam('idType', $idType);
$curseur->execute();
$lesLignes = $curseur->fetchAll(PDO::FETCH_ASSOC);
$curseur->closeCursor();
//Si il y as des données, récupération, si il y en as un du fichier et renvoie des données
if ($lesLignes) {
    // ajout d'une clé 'fichier' pour savoir si une pièce est jointe à l'information doc/info$id.pdf
    $rep = '../../document';
    for ($i = 0; $i < count($lesLignes); $i++) {
        // vérification de l'existence du document associé
        $fichier = $rep . '/info' . $lesLignes[$i]['id'] . '.pdf';
        $lesLignes[$i]['fichier'] = file_exists($fichier) ? 1 : 0;
    }
    echo json_encode($lesLignes);
    //Sinon affichage d'un message
} else {
    echo "Cette page n'existe pas ou aucune information n'as été publié ses 2 derniers mois.";
}



