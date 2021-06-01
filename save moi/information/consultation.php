<!DOCTYPE html>
<html lang="fr">
<head>
    <?php
    require '../include/head.php';
    ?>
    <script src="consultation.js"></script>
</head>
<body>
<div class="container" style="padding-left:20px; padding-right:20px; min-width:200px">
    <?php require '../include/menu.php'; ?>
    <div id='corps'>
        <div id="informationRecente" style="display:none">
            <h2 class="text-center">Dernières informations</h2>
            <div id='liste'></div>
        </div>
    </div>
</div>
<?php require '../include/pied.php'; ?>
</div>
</body>
</html>