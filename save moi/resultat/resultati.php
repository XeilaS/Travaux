<!DOCTYPE html>
<html lang="fr">
<head>
    <?php
    require '../include/head.php';
    ?>
    <script src="resultati.js"></script>
</head>
<body>
<div class="container" style="padding-left:20px; padding-right:20px; min-width:600px">
    <?php require '../include/menu.php'; ?>
    <div id='corps'>
        <div class="card">
            <div class="form-inline ">
                <label for="nomR">Recherche</label>
                <input type="text" id="nomR"
                       class="form-control col-3 ml-3"
                       autocomplete="off">
            </div>
            <div id="msg" class="mt-2"></div>
            <div id="tableau" class='table-responsive mt-3' style="display: none">
                <table class='table table-sm table-borderless'>
                    <thead>
                    <tr>
                        <th style='width:100px'>Date</th>
                        <th style='width:180px'>Distance</th>
                        <th style='width:180px'>Temps</th>
                        <th style='width:50px' class="text-center">Place</th>
                        <th style='width:100px' class="text-center">Club</th>
                        <th style='width:80px' class="text-center">Catégorie</th>
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

