<!DOCTYPE html>
<html lang="fr">
<head>
    <?php
    require '../include/head.php';
    ?>
    <script src="consultation.js"></script>
</head>
<body>
<div class="container" style="padding-left:20px; padding-right:20px; min-width:600px">
    <?php require '../include/menu.php'; ?>
    <div id='corps'>
        <div class="form-inline ">
            <label for="lesReportages">
                Sélectionner le reportage
            </label>
            <select id="lesReportages" class="form-control"></select>
        </div>
        <iframe id="leReportage" width="95%" height="460px" frameborder="0" allowfullscreen></iframe>
    </div>
    <?php require '../include/pied.php'; ?>
</div>
</body>
</html>