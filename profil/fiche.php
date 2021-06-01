<?php
// il faut être connecté
session_start();
if (!isset($_SESSION['membre'])) {
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
    <link rel="stylesheet" href="style.css">

    <script src="../composant/transition/transition.min.js"></script>
    <script src="../composant/fonction.js"></script>
    <script src="../composant/ctrl.js"></script>
    <script src="fiche.js"></script>
</head>
<body>
<div class="container" style="padding-left:20px; padding-right:20px">
    <?php require '../include/menu.php'; ?>
    <div id='corps' class="p-3">
        <!--Nom et Prénom-->
        <div class="border-bottom border-primary pb-2">
            <div class="d-flex">
                <h4 class="mt-2 w-25">Ma fiche membre</h4>
                <div class="w-75">
                    <button id="btnAttestation" type="button" class="btn btn-outline-dark float-right">Générer mon attestation</button>
                </div>
            </div>
        </div>
        <div id="nom" class="d-flex p-3">Nom :</div>
        <div id="prenom" class="d-flex p-3">Prénom :</div>
        <!--Mes Informations-->
        <h4 class="border-bottom border-primary pb-3">
            Modifier mes informations
        </h4>
        <div class="container mt-5">
            <div class="row">
                <div class="col-12 col-lg-5 mb-4 text-center">
                    <div class="card d-inline-block" style="width: 200px">
                        <div class="card-header text-center">
                            <img src="../img/aide.png"
                                 id="img"
                                 alt="Fichiers acceptés"
                                 class="my-auto"
                                 style="width: 20px; height: 20px"
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
                            <p class="my-auto">Image de profil</p>
                            <div id='bin' class="my-auto"></div>
                        </div>
                        <div class="card-body">
                            <input type="file" id="photo" accept=".jpg, .png, .gif" style='display:none'>
                            <div class="">
                                <div id="cible" class="cadreUpload small">
                                    Déposez une nouvelle photo ici <br> ou <br> sélectionnez une photo en cliquant dans
                                    le
                                    cadre
                                </div>
                            </div>
                            <span id="messagePhoto" class="messageErreur"></span>
                        </div>

                        <a href="https://resizeyourimage.com/FR/" target="_blank" class="text-center"
                           style="font-size: 0.8em">Cliquer
                            ici pour redmensionner votre image</a>
                    </div>
                </div>
                <div class="col-12 col-lg-7 col-sm-8 mt-4">
                    <div class="font-weight-bold">Informations qui seront affichées dans la liste adhérents si vous les renseignez</div>
                    <div class="form-group grid">
                        <div data-toggle="popover"
                             data-trigger="hover"
                             data-html="true"
                             data-placement='left'
                             data-content="<div style='font-size:11px; height:55px'>
                                            <p> Afficher votre <br> adresse mail dans <br> la liste des membres</p>
                                            </div>"
                        >
                            <input id="autMail" class="mr-2 my-auto" type="checkbox">
                        </div>
                        <div>
                            <label for="email" class="my-auto">Adresse mail :</label>
                        </div>
                        <div>
                            <input id="email" class="form-control text-center m-auto"
                                   type="email" style="width: 230px"
                                   pattern="^[0-9a-zA-Z]([-_\.]?[0-9a-zA-Z])*@[0-9a-zA-Z]([-_\.]?[0-9a-zA-Z])*[\.][a-zA-Z]{2,4}$"
                                   required>
                        </div>
                        <div id="emailCheck" class="checked"></div>
                        <div></div>
                        <div>
                            <label for="fixe" class="my-auto">Tel fixe :</label>
                        </div>
                        <div>
                            <input id="fixe" class="form-control text-center m-auto" type="text" style="width: 230px" placeholder="Non renseigné" pattern="^0[1-5]\d{8}$">
                        </div>
                        <div id="fixeCheck" class="checked"></div>
                        <div></div>
                        <div>
                            <label for="mobile" class="my-auto">Tel mobile :</label>
                        </div>
                        <div>
                            <input id="mobile" class="form-control text-center m-auto" type="text" style="width: 230px" placeholder="Non renseigné" pattern="^0[6-8]\d{8}$">
                        </div>
                        <div id="mobileCheck" class="checked"></div>
                        <div data-toggle="popover"
                             data-trigger="hover"
                             data-html="true"
                             data-placement='left'
                             data-content="<div style='font-size:11px; height:50px'>
                                            <p> S'abonner aux <br> informations <br> du Val de Somme</p>
                                            </div>"
                        >
                            <input id="abtInformation" class="mr-2 my-auto" type="checkbox">
                        </div>
                        <div class="abtCell">
                            <div class="my-auto">Abonnement aux informations</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php require '../include/pied.php'; ?>
</div>
</body>
</html>
