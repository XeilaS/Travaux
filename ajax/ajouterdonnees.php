<?php

/*

 //Le script est lancé par la fonction ajouter dans le fichier ../ajout.js
// et permet l'ajout d'une information

Objectif :
    Ajout d'une information dans la base de donnée

Fonctions appelante:
    ../ajout.js => ajouter

table utilisé et / ou répertoire depuis la racine du site :
    Répertoire: document/
    Table: information(titre, contenu, auteur, idType, dateCreation)
Resultat envoyé :
    Si tout ce passe bien : 1,
    Si la taille dépasse 2 * 1024 * 1024 : La taille du fichier dépasse la taille autorisée,
    Si ce n'est pas un PDF : Extension du fichier non acceptée,
    Si le titre, l'infoConcerne, le contenu ne sont pas passé en paramètre : Paramètres manquants
    Si la personne n'as pas les droit requis : Accès interdit

Remarque :
    le fichier n'est pas obligatoire lors de l'appel
    le test des droit ce fait avec ../../include/fonction.php

*/

//vérification du droit d'accées
require '../../include/fonction.php';
require '../../class/class.database.php';
$db = Database::getInstance();
if (!estAutorise(2, $db)) {
    echo "Accès interdit";
    exit;
}
// vérification des paramètres
if (!isset($_POST['titre']) || !isset($_POST['infoConcerne']) || !isset($_POST['contenu']) ) {
    echo "Paramètres manquants";
    exit;
}

//récupération des paramètres
$titre = $_POST['titre'];
$contenu = $_POST['contenu'];
$infoConcerne = $_POST['infoConcerne'];
$auteur = $_SESSION['membre']['prenom'] . ' ' . $_SESSION['membre']['nom'];
//Récupération et execution de la requête
$sql = <<<EOD
    INSERT INTO information(titre, contenu, auteur, idType, dateCreation) 
    VALUES (:titre, :contenu, :auteur, :infoConcerne, current_date());
EOD;
$curseur = $db->prepare($sql);
$curseur->bindParam('titre', $titre);
$curseur->bindParam('contenu', $contenu);
$curseur->bindParam('auteur',  $auteur);
$curseur->bindParam('infoConcerne', $infoConcerne);
$curseur->execute();

//Gestion de l'ajout d'un fichier si il est passé en paramétre
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
    //vérification de l'extension
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
        $id = $db->lastInsertId();
        $nomFichier = "info$id.pdf";
        $repertoire = "../../document";
        copy($tmp, "$repertoire/$nomFichier");
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}
echo 1;

