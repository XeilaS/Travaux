<?php
require '../../include/fonction.php';
require '../../class/class.database.php';
$db = Database::getInstance();
if (!estAutorise(37, $db)) {
    echo "Accès interdit";
    exit;
}


// Vérification des paramètres attendus
require '../../class/class.controle.php';
if (!Controle::existe('idCourse', 'niveau', 'url')) {
    echo "Paramètre manquant";
    exit;
}


$url = $_POST['url'];
$niveau = $_POST['niveau'];
$idCourse = $_POST['idCourse'];

if($niveau == '') {
    $sql = <<<EOD
        Insert into reportagevideo(idCourse, url)
        values (:idCourse, :url);
EOD;
} else {
    $sql = <<<EOD
        Insert into reportagevideo (idCourse, niveau, url)
        values (:idCourse, :niveau, :url);
EOD;
}
$curseur = $db->prepare($sql);
$curseur->bindParam('idCourse', $idCourse);
$curseur->bindParam('url', $url);
if ($niveau !== '') $curseur->bindParam('niveau', $niveau);
try{
    $curseur->execute();
    echo 1;
} catch (Exception $e){
    echo substr($e->getMessage(),strrpos($e->getMessage(), '#') + 1);
}
