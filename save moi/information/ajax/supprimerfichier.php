<?php

/*

//Le script est lancé par la fonction supprimerFichier dans le fichier ../index.js
// et permet la suppression d'un fichier

Objectif :
    Suppresion d'un fichier

Fonctions appelante:
    ../index.js => supprimerFichier

table utilisé et / ou répertoire depuis la racine du site :
    répertoire : document/

Resultat envoyé :
    Si tout ce passe bien : 1,
    Sinon 2,
    Si le fichier n'est pas passé en paramètre : Paramètres manquants
    Si la personne n'as pas les droit requis : Accès interdit

Remarque :
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

// vérification des paramètres
if (!isset($_POST['fichier'])) {
    echo "Demande incomplète";
    exit;
}
$fichier = "../../document/" . $_POST['fichier'];
if (file_exists($fichier)) {
    unlink($fichier);
    echo 1;
} else {
    echo 2; 
}

