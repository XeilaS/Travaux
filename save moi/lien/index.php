<?php
require '../include/fonction.php';
require '../class/class.database.php';
$db = Database::getInstance();
if (!estAutorise(30, $db)) {
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
    <script src="../composant/ctrl.js"></script>
    <script src="index.js"></script>
</head>
<body>
<div class="container" style="padding-left:20px; padding-right:20px; min-width:480px">
    <?php require '../include/menu.php'; ?>

    <input type="file" id="photo" accept="image/*" style='display : none'>
        <div class="card">
            <div id='lesCartes' class=""></div>
        </div>

    </div>


    <?php require '../include/pied.php'; ?>

</div>
</body>
</html>
