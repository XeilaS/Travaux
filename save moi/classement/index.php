<?php
require '../include/fonction.php';
require '../class/class.database.php';
$db = Database::getInstance();
if (!estAutorise(17, $db)) {
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
    <script src=""></script>
</head>
<body>
<div class="container" style="padding-left:20px; padding-right:20px; min-width:600px">
    <?php require '../include/menu.php'; ?>

    <div class="card">
        <div class=' bg-white table-responsive'>
            <table id="leTableau" class=' table table-sm table-borderless'>
                <thead>
                <tr>
                    <th style="width:100px">Action</th>
                    <th>Fichier</th>
                    <th style="width:150px">nbParticipant</th>
                </tr>
                </thead>
                <tbody id="lesLignes"></tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>


