<?php
// envoi du contenu de la page dont l'id est transmis

require '../../class/class.database.php';
$id = $_GET["id"];

$db = Database::getInstance();
$sql = <<<EOD
            SELECT contenu 
            FROM page 
            WHERE id = :id; 
EOD;
$curseur = $db->prepare($sql);
$curseur->bindParam('id', $id);
$curseur->execute();
$ligne = $curseur->fetch();
$curseur->closeCursor();
if ($ligne) {
    echo $ligne['contenu'];
} else {
    ?>
    <div class="alert alert-danger alert-dismissible fade show">
        Cette page n'existe pas
    </div>
    <?php
}

