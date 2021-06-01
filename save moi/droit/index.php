<?php
// il faut être admin
session_start();
if (!isset($_SESSION['membre']) ||  $_SESSION['membre']['admin'] === 0) {
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
    <script src="../composant/ckeditor/ckeditor.js"></script>
    <script src="index.js"></script>
</head>
<body>
<div class="container" style="padding-left:20px; min-width:480px">
    <?php require '../include/menu.php'; ?>
    <div class="container" style="padding-left:20px">
        <div class="card mx-auto mt-3">
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <label class="input-group-text" for="lesAdmins">Sélection de l'administrateur : </label>
                </div>
                <select class="form-control mt-4" id="lesAdmins" ></select>
            </div>
            <div id='zoneTableau' class="table-responsive">
                <table id='leTableau' class='table table-sm table-borderless tablesorter-bootstrap'>
                    <thead>
                    <tr>
                        <th style='width:10%'>
                            <button id='btnSupprimer' class="btn btn-sm  btn-danger ">Retirer tout</button>
                        </th>
                        <th style='width:90%'>Descrition</th>
                    </tr>
                    </thead>
                    <tbody id="lesLignes"></tbody>
                </table>
            </div>
        </div>
    </div>
    <?php require '../include/pied.php'; ?>
</body>
</html>
