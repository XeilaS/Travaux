<?php
require '../include/fonction.php';
require '../class/class.database.php';
$db = Database::getInstance();
if (!estAutorise(33, $db)) {
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
    <script src="ajout.js"></script>
</head>
<body>
<div class="container" style="padding-left:20px; padding-right:20px; min-width:600px">
    <?php require '../include/menu.php'; ?>
    <div id='corps' class="p-5">

        <div class="row mt-3">
            <label class="col-form-label" for="idCourse">Course</label>
            <select class="form-select" id="idCourse"></select>
        </div>
        <div class="row mt-3">
            <label class="col-form-label" for="niveau">Niveau</label>
            <select class="form-select" id="niveau" style="width: 150px;">
                <option value="">Non précisé</option>
                <option value="As">As</option>
                <option value="Populaire">Populaire</option>
            </select>
        </div>
        <div class="row mt-3">

            <label for="url" class="obligatoire col-form-label">Url</label>
            <input id="url"
                   type="text"
                   class="form-control"
                   required
                   maxlength='150'
                   pattern="^((http:\/\/|https:\/\/)?(www.)?(([a-zA-Z0-9-]){2,}\.){1,4}([a-zA-Z]){2,6}(\/([a-zA-Z-_\/\.0-9#:?=&;,]*)?)?)"
                   autocomplete="off">
            <span class='messageErreur'></span>
        </div>
        <div class="text-center">
            <button id='btnAjouter' class="btn btn btn-danger">Ajouter</button>
        </div>
    </div>
    <?php require '../include/pied.php'; ?>
</div>
</body>
</html>
