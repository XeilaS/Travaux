<?php
session_start();

/** On regarde si le membre est bien connecté pour avoir accés au menu ajout*/
require '../include/fonction.php';
require '../class/class.database.php';
$db = Database::getInstance();
if (!estAutorise(18, $db)) {
    echo "Accès interdit";
    exit;
}
/** Dans Head on charge les script necessaire aux controles et la date pour un format au français(j/m/a) */
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <?php
    require '../include/head.php';
    ?>
    <script src="../composant/ctrl.js"></script>
    <script src="../composant/date.js"></script>
    <script src="ajout.js"></script>
</head>
<body>

<div class="container" style="padding-left:20px; padding-right:20px; min-width:600px">
    <?php require '../include/menu.php'; ?>
    <div id='corps'>
        <h1> Nouveau reportage photo </h1>
        <div class="form-row">
            <div class="form-group col-md-5">
                <label for="date" class="obligatoire col-form-label">Date</label>
                <input id='date'
                       type="date"
                       class="form-control col-6 ctrl">
                <span class='messageErreur'></span>
            </div>
        </div>
        <!--Controle sur le titre, c'est ici que l'on vient chercher les controles pour ajout.js -->
        <div class="form-row">
            <div class="form-group col-md-5 ">
                <label for="titre" class="obligatoire col-form-label">Titre</label>
                <input id="titre"
                       type="text"
                       class="form-control ctrl"
                       minlength=''
                       maxlength=''
                       pattern="[0-9A-Za-zÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ'()._ -]"
                       autocomplete="off">
                <span class='messageErreur'></span>
            </div>
        </div>
        <!--Controle sur l'url, c'est ici que l'on vient chercher les controles pour ajout.js -->
        <div class="form-row">
            <div class="form-group col-md-5 ">
                <label for="url" class="obligatoire col-form-label">Url de reportage </label>
                <input id="url"
                       type="text"
                       class="form-control ctrl"
                       maxlength='150'
                       pattern="^((http:\/\/|https:\/\/)?(www.)?(([a-zA-Z0-9-]){2,}\.){1,4}([a-zA-Z]){2,6}(\/([a-zA-Z-_\/\.0-9#:?=&;,]*)?)?)"
                       autocomplete="off">
                <span class='messageErreur'></span>
            </div>
        </div>
        <div class="text-center">
            <button id='btnAjouter' class="btn btn btn-danger">Ajouter</button>
        </div>
    </div>
</div>
</body>
</html>
