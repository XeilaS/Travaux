<?php
// vérification de l'accès
require '../include/fonction.php';
require '../class/class.database.php';
$db = Database::getInstance();
if (!estAutorise(6, $db)) {
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
    <div class="card">
        <div class="card-body">
            <div class="form-group">
                <label class='obligatoire' for="titre">Donnez un titre au document </label>
                <input id='titre' type="text" class="form-control">
                <span id='messageTitre' class="messageErreur"></span>
            </div>
            <div class="form-group">
                <label class='obligatoire' for="concerne">Le document concerne </label>
                <select id="idType"
                        class="form-control col-3 ml-3">
                </select>
                <span id='messageConcerne' class="messageErreur"></span>
            </div>

            <input type="file" id="fichier" accept=".pdf" style='display: none '>
            <div id="cible" style="border: 1px dashed; text-align: center; margin-bottom: 10px; padding: 5px">
                Déposez le document ici <br> ou <br> sélectionnez un document en cliquant dans le cadre
            </div>
            <span id='messageDocument' class="messageErreur"></span>


            <div class="text-center">
                <button id="btnAjouter" class="btn btn-danger">Ajouter</button>
            </div>

            <?php require '../include/pied.php'; ?>
        </div>
</body>
</html>


