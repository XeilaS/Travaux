<?php
require '../include/fonction.php';
require '../class/class.database.php';
$db = Database::getInstance();
if (!estAutorise(3, $db)) {
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
    <script src="index.js"></script>
</head>
<body>
<div class="container" style="padding-left:20px; padding-right:20px">
    <?php require "../include/menu.php"; ?>
    <div id='corps'>
        <div class="text-center">
            <div id="pasInformation" class="messageErreur" style="font-size: 20px"></div>
        </div>
        <div class="col-md-12 text-center"  id="selection" style="display: none; background-color: gainsboro;">
            <label for="infoSelectionner" class="mr-2"> Séléctionner l'Information à modifier ou à supprimer </label>
            <select class="form-control" id="infoSelectionner"></select>
        </div>
        <div class="row" id="ContenueInformation" style="display: none">
            <div class="col-md-1"></div>
            <div class="col-md-5">
                <div class="form-group">
                    <label for="titre" class="mr-2 obligatoire">Titre :</label>
                    <input type="text" class="form-control" id="titre">
                    <div id="msgTitre" class="messageErreur"></div>
                    <label for="infoConcerne" class="mr-2 obligatoire"> Information concerne </label>
                    <select class="form-control" id="infoConcerne"></select>
                </div>
            </div>
            <div class="col-md-5">
                <div style="margin: 20px"
                <div class="card">
                    <div class="card-header">
                        Nouveau Fichier
                        <img src="../img/aide.png"
                             alt = "Fichiers acceptés"
                             class="float-right"
                             data-title="<b>Fichiers acceptés<b>"
                             data-toggle="popover"
                             data-trigger="hover"
                             data-html="true"
                             data-placement='bottom'
                             data-content="<div style='font-size:11px'>
                                            <p> Extensions  : pdf</p>
                                            <p> Taille maximale : 2 Mo </p>
                                            </div>"
                        >
                    </div>
                    <div id="msg"></div>
                    <div class="card-body">
                        <input type="file" id="fichier" accept=".pdf" style='display: none '>
                        <div class="text-center">
                            <div id="cible" class="cadreUpload small" style="height: 130px">
                                Déposez un nouveau fichier <br> ou <br> sélectionnez un fichier en cliquant dans le cadre
                            </div>
                        </div>
                        <div class="text-center" style="padding-top: 10px">
                            <button id="btnSupprimerFichier" class="btn btn-danger">Supprimer le fichier</button>
                        </div>
                        <span id='messageDocument' class="messageErreur"></span>
                    </div>
                </div>
            </div>
            <div class="col-md-1"></div>
            <div class="col-md-12">
                <div id="msgContenu" class="messageErreur"></div>
                <div id="groupeContenu" class="form-group">
                    <label class="sr-only" for="contenu">Contenu </label>
                    <textarea id='contenu' style="display:none"></textarea>
                </div>
                <div class="text-center" >
                    <button id='btnModifier' class="btn btn-success mb-3">Modifier</button>
                    <button id='btnSupprimer' class="btn btn-danger mb-3" style="padding-right: 10px">Supprimer</button>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require '../include/pied.php'; ?>
</body>
</html>
