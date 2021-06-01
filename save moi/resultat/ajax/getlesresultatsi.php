<?php


if (!isset($_POST['valeur'])) {
    echo "Paramètre manquant";
    exit;
}
// récupération du paramétre transmis
$valeur = $_POST['valeur'];
// ajout du symbole % devant et derriere
$valeur = "%$valeur%";

require '../../class/class.database.php';
$db = Database::getInstance();
$sql = <<<EOD
SELECT date, distance, temps, place, club, categorie, placeCategorie
   from resultat, course, coureur
   where resultat.idCourse = course.id
   and resultat.idCoureur = coureur.id
   and(nom like :valeur)
   order by coureur.nom, prenom;
EOD;
$curseur = $db->prepare($sql);
$curseur->bindParam('valeur', $valeur);
$curseur->execute();
$lesLignes = $curseur->fetchAll(PDO::FETCH_ASSOC);
$curseur->closeCursor();
if (count($lesLignes) > 0)
    echo json_encode($lesLignes);
else
    echo "Aucun licencié correspondant";



















