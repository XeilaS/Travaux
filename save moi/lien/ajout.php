<?php
require '../include/fonction.php';
require '../class/class.database.php';
$db = Database::getInstance();
if (!estAutorise(29, $db)) {
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
    <script src="../composant/ckeditor/ckeditor.js"></script>
    <script src="ajout.js"></script>
</head>
<body>
<div class="container" style="padding-left:20px; padding-right:20px; min-width:600px">
    <?php require '../include/menu.php'; ?>
    <div id='corps' class="d-flex">
        <div class="card mx-auto" style="width: 40rem;">
            <div class="card-header bg-info">
                <div class="form-group col-md-5 ">
                    <label for="nom" class="obligatoire col-form-label">Nom </label>
                    <input id="nom"
                           type="text"
                           class="form-control ctrl"
                           maxlength='30'
                           pattern="^[0-9A-Za-zÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ' ()._-]+$"
                           autocomplete="off">
                </div>
            </div>

            <div class="card-footer d-flex flex-column">
                <label for="description" class="obligatoire col-form-label">description</label>
                <textarea id="description"  class=""></textarea>
            </div>
            <div class="card-footer d-flex flex-column">
                <label for="url" class="obligatoire col-form-label">url</label>
                <textarea id="url"  class=""></textarea>
            </div>
            <div class="card-footer d-flex flex-column">
                <label for="rang" class="obligatoire col-form-label">rang </label>
                <input id="rang"
                       type="number"
                       class="form-control ctrl w-25"
                       min="0"
                       maxlength='30'
                       autocomplete="off">
            </div>
            <div id='messageErreur'></div>


            <input type="file" id="fichier" accept="image/*" style='display : none'>
            <div id="cible" class="cadreDoc">
                Déposez le logo ici <br> ou <br> sélectionnez-le en cliquant dans le cadre
                <br>
                <img src="../img/aide.png"
                     style="width: 20px; height: 20px"
                     alt="Fichiers acceptés"
                     data-title="<b>Fichiers acceptés<b>"
                     data-toggle="popover"
                     data-trigger="hover"
                     data-html="true"
                     data-placement='left'
                     data-content="<div style='font-size:11px'>
						<p> Extensions  : png, jpg ou gif </p>
						<p> Taille maximale : 30 Ko </p>
						<p> Dimension maximale : 150 * 150 </p>
						</div>"
                >
            </div>
            <div id='messageLogo' class="messageErreur"></div>
            <div class="text-center">
                <button id='btnAjouter' class="btn btn btn-info">Ajouter</button>
            </div>
        </div>
    </div>
    <?php require '../include/pied.php'; ?>
</div>
</body>
</html>

