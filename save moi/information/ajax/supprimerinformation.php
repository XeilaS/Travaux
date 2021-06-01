<?php

/*

//Le script est lancé par la fonction supprimerinformation dans le fichier ../index.js
// et permet la suppression d'une information


Objectif :
    Suppression d'une information

Fonctions appelante:
    ../index.js => supprimerinformation

table utilisé et / ou répertoire depuis la racine du site :
    répertoire : document/
    Table: information(id)

Resultat envoyé :
    Si tout ce passe bien : 1,
    Si l'id n'est pas passé en paramètre : Paramètres manquants
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

// vérification de la présence du paramètre
if (!isset($_POST['id'])) {
    echo "Paramètres manquants";
    exit;
}
//Récupération des information, préparation de la requéte et execution de la requête
$id = $_POST['id'];
$sql = <<<EOD
delete 
from information 
where id = :id;
EOD;
$curseur = $db->prepare($sql);
$curseur->bindParam('id', $id);
$curseur->execute();

//Si un fichier relié à l'information était existant sur le serveur, alors il seras supprimer
if (isset($_POST['fichier'])) {
    $fichier = "../../document/" . $_POST['fichier'];
    if (file_exists($fichier))
        unlink($fichier);
}
echo 1;


