<?php
require '../include/fonction.php';
require '../class/class.database.php';
$db = Database::getInstance();
if (!estAutorise(35, $db)) {
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
    <script src="repondre.js"></script>
</head>
<body>
<div class="container" style="padding-left:20px; padding-right:20px; min-width:600px">
    <?php require '../include/menu.php'; ?>
    <div id='corps'>

        <div class="card">
            <div class="form-row">
                <div class="form-group  col-md-3 ">
                    <label id="mail" for="idMessage" class="input-group-text ">Emails</label>
                    <select class="form-control input-sm" id='idMessage'></select>
                </div>

            </div>
        </div>


        <div class="form-row mt-3">
            <div class="col-12">
                <div class ="table-responsive mt-3"></div>
                <table class='table table-sm table-borderless'>
                    <thead>
                    <tr>
                        <th style='width:100px'>Messages</th>
                        <th style='width:100px' type="text">Réponse</th>
                    </tr>
                    </thead>
                    <tbody id="lesDonnees"></tbody>
                </table>
            </div>
        </div>
        <button id="btnAjouter" class="btn btn-danger float-right">Envoyer</button>
    </div>


</div>
</body>
</html>
