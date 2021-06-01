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
            <label for="lesAnnees" class="">
                <h3>Afficher les reportages de l'année <h3>
            </label>
            <select class="form-control col-0.5 ml-2" id="lesAnnees"></select>
        </div>
        <div id="lesCartes">
        </div>
    </div>
    <?php require '../include/pied.php'; ?>
</div>
</body>
</html>