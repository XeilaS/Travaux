<?php
// vérification de l'accès
require '../include/fonction.php';
require '../class/class.database.php';
$db = Database::getInstance();
if (!estAutorise(1, $db)) {
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
    <script src="../composant/ckeditor/ckeditor.js"></script>
    <script src="index.js"></script>
</head>
<body>
<div class="container" style="">
    <?php require "../include/menu.php"; ?>
    <div id="corps">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for='lesPages'>
                        Sélectionner la page à modifier et cliquer sur le bouton modifier pour enregistrer les
                        modifications
                    </label>
                    <select class="form-control" id="liste"></select>
                </div>
            </div>
            <div class="col-md-6">
                <button id='btnModifier' class="btn btn-danger mb-3">Modifier</button>
                <div id="msg"></div>
            </div>
        </div>

        <div id="groupeContenu" class="form-group">
            <label class="sr-only" for="contenu">Contenu </label>
            <textarea id='contenu' style="display:none"></textarea>
        </div>

    </div>
</div>
</div>
</body>
</html>