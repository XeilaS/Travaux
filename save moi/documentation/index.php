<?php
require '../include/fonction.php';
require '../class/class.database.php';
$db = Database::getInstance();
if (!estAutorise(7, $db)) {
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
<div class="container" style="padding-left:20px; padding-right:20px; min-width:600px">
    <?php require '../include/menu.php'; ?>
    <div class="card">

        <div class="form-inline">
            <label for="idCategorie" class="">Type de document</label>
            <select class="form-control col-3 ml-3" id="idType"></select>

        </div>
        <div id="msg" class="mt-2"></div>
        <div class='table-responsive mt-3'>
            <table class='table table-sm table-borderless'>
                <thead>
                <tr>
                    <th style='width:50px'></th>
                    <th style='width:450px'>Titre</th>
                    <th style='width:250px'>Date émission</th>

                </tr>
                </thead>
                <tbody id="lesLignes"></tbody>
            </table>
        </div>
    </div>
    <?php require '../include/pied.php'; ?>
</div>
</body>
</html>


