<!DOCTYPE html>
<html lang="fr">
<head>
    <?php
    require '../include/head.php';
    ?>
    <script src="resultatc.js"></script>
</head>
<body>
<div class="container" style="padding-left:20px; padding-right:20px; min-width:600px">
    <?php require '../include/menu.php'; ?>
    <div id='corps'>
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
