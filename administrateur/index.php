
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
    <link rel="stylesheet" href="../composant/autocomplete/easy-autocomplete.min.css ">
    <script src="../composant/ctrl.js"></script>
    <script src="../composant/autocomplete/jquery.easy-autocomplete.min.js "></script>
    <script src="index.js"></script>
</head>
<body>
<div class="container" style="padding-left:20px; padding-right:20px; min-width:600px">
    <?php require '../include/menu.php'; ?>
    <div id='corps' class="">
        <div class="d-flex">
            <label for ="nomR" class="my-auto mr-4">Membre à définir en administrateur du site </label>
            <input id="nomR" type="text"
                   style="width:270px"
                   placeholder="Nom du membre"
                   class="form-control-sm my-auto">

            <button id='btnAjouter' class="m-3 btn btn-sm  btn-success my-auto">Ajouter un Administrateur</button>
        </div>
        <div class="" style="margin-top:10px">
            <div class='table-responsive'>
                <table class='table table-sm table-borderless'>
                    <thead>
                    <tr>
                        <th style="width:5%">Action</th>
                        <th style='width:50%'>Nom</th>
                        <th style='width:45%'>Prénom</th>
                    </tr>
                    </thead>
                    <tbody id="lesLignes"></tbody>
                </table>
            </div>
        </div>
    </div>
</body>
<?php require '../include/pied.php'; ?>
</div>
</html>
