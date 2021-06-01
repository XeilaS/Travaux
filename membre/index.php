<?php
require '../include/fonction.php';
require '../class/class.database.php';
$db = Database::getInstance();
if (!estAutorise(24, $db)) {
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
    <link rel="stylesheet" href="../composant/datatables/datatables.min.css" />
    <link rel="stylesheet" href="style.css">

    <script src="../composant/datatables/datatables.min.js"></script>
    <script src="../composant/fonction.js"></script>
    <script src="index.js"></script>
</head>
<body>
<div class="container" style="padding-left:20px">
    <?php require '../include/menu.php'; ?>
    <div id='corps' class="p-3">
        <!--<img src="../img/construction.jpg" alt="En cours de construction" class="p-3">-->
        <div class="border-bottom border-primary pb-2">
            <div class="d-flex">
                <h4 class="mt-2 w-50">
                    Gestion des membres
                </h4>
                <div class="w-75 d-flex justify-content-end">
                    <a href="ajax/exporterxls.php" target="_blank" type="button" class="btn btn-outline-success mr-3 my-auto">Exporter vers Excel</a>
                    <button id="btnImpression" type="button" class="btn btn-outline-dark my-auto">Imprimer</button>
                </div>
            </div>
        </div>
        <div>
            <div class='table-responsive pt-3'>
                <table id="leTableau" class='table table-sm table-bordered'>
                    <thead>
                    <tr>
                        <th style='width:180px'>Nom</th>
                        <th style='width:180px'>Prénom</th>
                        <th style="width: 300px" class="text-center">Email</th>
                        <th style='width:130px' class="text-center">Mobile</th>
                        <th style='width:130px' class="text-center">Fixe</th>
                        <th style='width:80px' class="text-center">Montant</th>
                        <th style='width:20px' class="text-center">Photo</th>
                    </tr>
                    </thead>
                    <tbody id="lesLignes"></tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</body>
</html>
