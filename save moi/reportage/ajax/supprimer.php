<?php
require '../../include/fonction.php';
require '../../class/class.database.php';
$db = Database::getInstance();
if (!estAutorise(19, $db)) {
    echo "Accès interdit";
    exit;
}
/** Base de donnée avec la requete sql qui permet la suppression **/

$id = $_POST['id'];
$sql = <<< EOD
DELETE FROM reportage
where id = :id;
EOD;
$curseur = $db->prepare($sql);
$curseur->bindparam('id', $id);
try {
    $curseur->execute();
    echo 1;
} catch(Exception $e) {
    echo $e->getMessage();
}
