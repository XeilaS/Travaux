<?php
require '../../include/fonction.php';
require '../../class/class.database.php';
$db = Database::getInstance();
if (!estAutorise(18, $db)) {
    echo "Accès interdit";
    exit;
}

/** On charge les fichier que l'on a besoin pour efectuer les controles et avoir la BDD **/
require '../../class/class.controle.php';

/** données **/
$date = $_POST['date'];
$titre = $_POST['titre'];
$url = $_POST['url'];

/** On verifie dans reportage si il n'existe pas déjà un reportage qui possede ce titre **/
$sql = <<<EOD
Select 1 From reportage Where titre = :titre
EOD;
$curseur = $db->prepare($sql);
$curseur->bindParam('titre', $titre);
$curseur->execute();
$ligne = $curseur->fetch();
$curseur->closeCursor();
if ($ligne) {
    echo "Un reportage possède déjà ce titre";
    exit();
}

/** On verifie dans reportage si il n'existe pas déjà un reportage qui possede cette url **/
$sql = <<<EOD
Select 1 From reportage Where url = :url
EOD;
$curseur = $db->prepare($sql);
$curseur->bindParam('url', $url);
$curseur->execute();
$ligne = $curseur->fetch();
$curseur->closeCursor();
if ($ligne) {
    echo "Un reportage possède déjà cette URL";
    exit();
}

/** On ajoute dans reportage le nouveau reportage avec sa date, son titre et son url **/
$sql = <<<EOD
Insert into reportage (date, titre, url)
values (:date, :titre, :url);
EOD;
$curseur = $db->prepare($sql);
$curseur->bindParam('date', $date);
$curseur->bindParam('titre', $titre);
$curseur->bindParam('url', $url);
try{
    $curseur->execute($_POST);
    echo 1;
} catch (Exception $e){
    echo $e->getMessage();
}
