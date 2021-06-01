<?php
session_start();

// le membre est il bien connecté
require '../include/necessiteconnexion.php';

// le membre a t'il un droit d'accès sur cette fonction
$idFonction = 31;
require '../include/necessiteautorisation.php';

$chemin = '../';
require '../include/generermenu.php';

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Amicale du Val de Somme</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link rel="icon" type="image/png" href="../icone.png">

    <link rel="stylesheet" href="../composant/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="../composant/noty/noty.css">
    <link rel="stylesheet" href="../composant/noty/animate.css">
    <link rel="stylesheet" href="../composant/noty/sunset.css">
    <link rel="stylesheet" href="../css/style.css">

    <script src="../composant/jquery.js"></script>
    <script src="../composant/bootstrap/bootstrap.bundle.min.js"></script>
    <script src="../composant/noty/noty.min.js"></script>
    <script src="../composant/std.js"></script>
    <script src="../composant/ctrl.js"></script>
    <script src="../composant/ckeditor/ckeditor.js"></script>
    <script src="ajout.js"></script>
</head>
<body>
<div class="container" style="padding-left:20px; padding-right:20px; min-width:600px">
    <?php require '../include/menu.php'; ?>

    <div id='corps'>

        <div class="col-md-5 ">
            <div class="form-group">
                <label for="titre" class="mr-2 obligatoire">Nom du partenaire :</label>
                <input type="text" class="form-control" id="titre">
                <div id="msgTitre" class="messageErreur"></div>
                <label for="domaine" class="mr-2 obligatoire"> Ce partenaire concerne</label>
                <select class="form-control" id="domaine"></select>
            </div>
        </div>

        <div class="col-md-5">
            <div style="margin: 20px"
            <div class="card">
                <div class="card-header">
                    Nouveau Fichier
                    <img src="../img/aide.png"
                         alt="Fichiers acceptés"
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
                    <input type="file" id="fichier" accept=".png" style='display: none '>
                    <div class="text-center">
                        <div id="cible" class="cadreUpload small" style="height: 130px">
                            Déposez un nouveau fichier <br> ou <br> sélectionnez un fichier en cliquant dans le
                            cadre
                        </div>
                    </div>
                    <div class="text-center" style="padding-top: 10px">
                        <button id="btnSupprimerFichier" class="btn btn-danger">Supprimer le fichier</button>
                    </div>
                    <span id='messageDocument' class="messageErreur"></span>
                </div>
            </div>
        </div>

        <div class="text-left">
            <button id='btnAjouter' class="btn btn btn-danger">Ajouter</button>
        </div>

    </div>


    <?php require '../include/pied.php'; ?>
</div>
</body>
</html>

