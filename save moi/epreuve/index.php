<?php
require '../include/fonction.php';
require '../class/class.database.php';
$db = Database::getInstance();
if (!estAutorise(22, $db)) {
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
    <script src="../composant/date.js"></script>
    <script src="../composant/ckeditor/ckeditor.js"></script>
    <script src="index.js"></script>
</head>
<body>
<div class="container" style="padding-left:20px; padding-right:20px; min-width:600px">
    <?php require '../include/menu.php'; ?>
    <div id='corps'>

        <div class="form-inline ">
            <label for="idEpreuve" class="">Sélectionner l'épreuve à modifier ou à supprimer :</label>
            <select class="form-control col-3 ml-3" id="idEpreuve"></select>
        </div>


        <div class="cadre mx-auto mt-3">
            <div class="form-row">
                <div class="form-group col-md-5">
                    <label for="date" class="obligatoire col-form-label">Date</label>
                    <input id='date'
                           type="date"
                           class="form-control col-6 ctrl">
                    <span class='messageErreur'></span>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-5 ">
                    <label for="nom" class="obligatoire col-form-label">Nom</label>
                    <input id="nom"
                           type="text"
                           class="form-control ctrl"
                           maxlength=''
                           pattern=""
                           autocomplete="off">
                    <span class='messageErreur'></span>
                </div>
            </div>
        </div>

        <div class="form-row mt-3">
            <div class="col-12">
                <label for="description" class="obligatoire col-form-label">Description</label>

                <textarea id="description"
                          class="form-control"
                          rows="3"
                          style="resize:vertical;
                          min-height:150px"></textarea>
                <div id='messageDescription' class='messageErreur'></div>
                <br/>
            </div>

        </div>


        <div class="text-center">
            <button id='btnModifier' class="btn btn btn-danger">Modifier</button>
            <button id='btnSupprimer' class="btn btn btn-danger">Supprimer</button>
        </div>


    </div>
</div>
</body>
</html>
