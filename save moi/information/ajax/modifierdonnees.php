<?php

/*

//Le script est lancé par la fonction modifier dans le fichier ../index.js
// et permet la modification d'une information

Objectif :
    Modification d'une information

Fonctions appelante:
    ../index.js => modifier

table utilisé et / ou répertoire depuis la racine du site :
    répertoire : document/
    Table: information(titre, contenu, idType)

Resultat envoyé :
    Si tout ce passe bien : 1,
    Si l'id, le titre, l'infoConcerne, le contenu ne sont pas passé en paramètre : Paramètres manquants
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

// vérification des paramètres
if (!isset($_POST['id']) || !isset($_POST['titre']) || !isset($_POST['infoConcerne']) || !isset($_POST['contenu']) ) {
    echo "Paramètres manquants";
    exit;
}
//Récupération des données
$id = $_POST['id'];
$titre = $_POST['titre'];
$contenu = $_POST['contenu'];
$infoConcerne = $_POST['infoConcerne'];

//Préparation et execution de la requête
//il faut s'inspirer de la Requête d'ajout
// INSERT INTO information(titre, contenu, auteur, idType, dateCreation)
// VALUES (:titre, :contenu, :auteur, :infoConcerne, current_date());
$sql = <<<EOD
update information
set titre = :titre,contenu = :contenu,idType = :infoConcerne
where id= :id;
EOD;
$curseur = $db->prepare($sql);
$curseur->bindParam('titre', $titre);
$curseur->bindParam('contenu', $contenu);
$curseur->bindParam('infoConcerne', $infoConcerne);
$curseur->bindParam('id',  $id);
$curseur->execute();

//Gestion de l'ajout/la modification du fichier si il est passer en paramétre
if (isset($_FILES['fichier'])) {
    // récupération des données du fichier
    $tmp = $_FILES['fichier']['tmp_name'];
    $nomFichier = $_FILES['fichier']['name'];
    $taille = $_FILES['fichier']['size'];
    // Définitions des contraintes à  respecter
    $tailleMax = 2 * 1024 * 1024;
    $lesExtensions = ["pdf"];
    $lesTypes = ["application/force-download", "application/pdf"];
    //Contrôles
    // vérification de la taille
    if ($taille > $tailleMax) {
        echo "La taille du fichier dépasse la taille autorisée";
        exit;
    }
    // vérification de l'extension
    $extension = pathinfo($nomFichier, PATHINFO_EXTENSION);
    if (!in_array($extension, $lesExtensions)) {
        echo "Extension du fichier non acceptée";
        exit;
    }
    // contrôle du type mime du fichier
    $type = mime_content_type($tmp);
    if (!in_array($type, $lesTypes)) {
        echo "Type de fichier non accepté";
        exit;
    }
    try {
        $nomFichier = "info$id.pdf";
        $repertoire = "../../document";
        copy($tmp, "$repertoire/$nomFichier");
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}
echo 1;

