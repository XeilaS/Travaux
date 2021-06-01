<?php
require '../../class/class.database.php';
$db = Database::getInstance();

$idCourse =$_POST["idCourse"] ;

$sql = <<<EOD
    SELECT place, temps, club, prenom, nom, categorie, placeCategorie
   from resultat, coureur
   where resultat.idCoureur = coureur.id
   and resultat.idCourse = :idCourse;
 
EOD;
$curseur = $db->prepare($sql);
$curseur->bindParam('idCourse', $idCourse);
$curseur->execute();
$lesLignes = $curseur->fetchAll(PDO::FETCH_ASSOC);
$curseur->closeCursor();
echo json_encode($lesLignes);