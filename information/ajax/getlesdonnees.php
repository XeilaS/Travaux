<?php

/*

//Le script est lancé au chargement du fichier ../ajout.js
// et permet le chargement des types d'informations dans la base de données

Objectif :
    Chargement des  type d'informations stokée dans la base de données

Fonctions appelante:
    ../ajout.js ( Au chargment )

table utilisé et / ou répertoire depuis la racine du site :
    Table: type(id, nom)

Resultat envoyé :
    Si tout ce passe bien : $lesLignes,
    Si la personne n'as pas les droit requis : Accès interdit
Remarque :
    le fichier n'existe pas obligatoirement
    le test des droit ce fait avec ../../include/fonction.php

*/

// le membre a t'il un droit d'accès sur cette fonction
require '../../include/fonction.php';
require '../../class/class.database.php';
$db = Database::getInstance();
if (!estAutorise(2, $db)) {
    echo "Accès interdit";
    exit;
}

$sql =<<<EOD
    Select id, nom
    from type
    order by nom;
EOD;
$curseur = $db->query($sql);
$lesLignes = $curseur->fetchAll(PDO::FETCH_ASSOC);
$curseur->closeCursor();

echo json_encode($lesLignes);
