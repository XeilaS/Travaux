<?php
session_start();

/** On regarde si le membre est bien connecté pour avoir accés au menu ajout*/


/** On regarde si le membre dispose des droit pour avoir accés au menu ajout*/
require '../include/fonction.php';
require '../class/class.database.php';
$db = Database::getInstance();
if (!estAutorise(19, $db)) {
    echo "Accès interdit";
    exit;
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <?php
    require '../include/head.php';
    ?>
    <script src="index.js"></script>
</head>
<body>
<div class="container" style="padding-left:20px; padding-right:20px; min-width:600px">
    <?php require '../include/menu.php'; ?>
    <div id='corps'>
        <div class="form-inline ">
            <label for="lesAnnees" class="">
                Afficher les reportages de l'année
            </label>
            <select class="form-control col-0.5 ml-2" id="lesAnnees"></select>
        </div>
        <div id="lesCartes">
        </div>
    </div>
</div>
</body>
</html>
