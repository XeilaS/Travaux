<?php

/*

//Le script est lancé au chargement du fichier ../index.js
// et permet le chargement des information et des types d'information dans un tableau

Objectif :
    Chargement des information et des types d'information dans un tableau

Fonctions appelante:
    ../index.js ( Au chargement )

table utilisé et / ou répertoire depuis la racine du site :
    Table: information(titre, contenu, auteur, idType, dateCreation)
           type(id, nom)

Resultat envoyé :
    Si tout ce passe bien : $tableau contenant $information et $type,
    Si la personne n'as pas les droit requis : Accès interdit

Remarque :
    le fichier n'existe pas obligatoirement
    le test des droit ce fait avec ../../include/fonction.php

*/

//vérification du droit d'accées
require '../../include/fonction.php';
require '../../class/class.database.php';
$db = Database::getInstance();
if (!estAutorise(3, $db)) {
    echo "Accès interdit";
    exit;
}

//Chargement des données dans le base de donées
$sql = <<<EOD
select information.id, titre, contenu, idType
from information, type
where information.idType = type.id
  and dateCreation between current_date() - interval 2 month and dateCreation
order by dateCreation desc;
EOD;
$curseur = $db->query($sql);
$information = $curseur->fetchAll(PDO::FETCH_ASSOC);
$curseur->closeCursor();
$sql = <<<EOD
select id, nom
from type;
EOD;
$curseur = $db->query($sql);
$type = $curseur->fetchAll(PDO::FETCH_ASSOC);
$curseur->closeCursor();

//Récupération du fichier, si il existe, il seras stocké dans information avec la valeur 1, sinon 0
$rep = '../../document';
for ($i = 0; $i < count($information); $i++) {
    // vérification de l'existence du document associé
    $fichier = $rep . '/info' . $information[$i]['id'] . '.pdf';
    $information[$i]['fichier'] = file_exists($fichier) ? 1 : 0;
}

//Création du tableau
$tableau = array(
    "information" => $information,
    "type" => $type,
);
//Revoie des données chargées
echo json_encode($tableau);
