<?php
$chemin = "../";
require '../include/generermenu.php';
?>




<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Amicale du Val de Somme</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link rel="icon" type="image/png" href="../icone.png">

    <link rel="stylesheet" href="../composant/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="../composant/noty/noty.css">
    <link rel="stylesheet" href="../composant/noty/sunset.css">
    <link rel="stylesheet" href="../composant/noty/animate.css">
    <link rel="stylesheet" href="../css/style.css">

    <script src="../composant/jquery.js"></script>
    <script src="../composant/bootstrap/bootstrap.bundle.min.js"></script>
    <script src="../composant/noty/noty.min.js"></script>
    <script src="../composant/std.js"></script>
    <script src="resultatc.js"></script>
</head>
<body>
<div class="container" style="padding-left:20px; min-width:600px">
    <?php
    require '../include/menu.php';
    ?>
    <div id='corps'>
        <img src="../img/resultats4s.gif" alt="" class="p-3">

        <div class="card">
            <div id="msg"></div>
            <div class="form-row">


                <div class="form-group  col-md-3 ">
                    <label for="idCourse" class="input-group-text ">Course</label>
                    <select class="form-control input-sm" id='idCourse'>
                    </select>
                </div>

            </div>
        </div>


        <div class="card">
            <div class='table-responsive'>
                <table class='table table-sm table-borderless'>
                    <thead>
                    <tr>
                        <th style='width:100px'>Place</th>
                        <th style='width:100px'>Temps</th>
                        <th style='width:100px'>Club ou ville</th>
                        <th style='width:100px'>Nom et Prénom</th>
                        <th style='width:100px'>Cat/Clt</th>
                    </tr>
                    </thead>
                    <tbody id="lesLignes"></tbody>
                </table>
            </div>
        </div>




    </div>




    <?php require '../include/pied.php'; ?>


</div>

</body>
</html>
