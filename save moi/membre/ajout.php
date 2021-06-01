<?php
require '../include/fonction.php';
require '../class/class.database.php';
$db = Database::getInstance();
if (!estAutorise(23, $db)) {
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
    <link rel="stylesheet" href="../composant/datatables/datatables.min.css" />

    <!--<script src="../composant/ctrl.js"></script>-->
    <script src="../composant/datatables/datatables.min.js"></script>
    <script src="../composant/transition/transition.min.js"></script>
    <script src="../composant/fonction.js"></script>
    <script src="ajout.js"></script>
</head>
<body>
<div class="container" style="padding-left:20px; padding-right:20px">
    <?php require "../include/menu.php"; ?>
    <div id="corps" class="p-3">
        <div class="border-bottom border-primary pb-2">
            <div class="d-flex">
                <h4 class="mt-2 w-25">Ajout d'un membre</h4>
            </div>
        </div>
        <div class="tab mx-auto form-group mt-5">
            <div class="lblcell">
                <label for="nom">Nom :</label>
            </div>
            <div class="d-flex flex-column">
                <input id="nom" type="text" class="form-control my-auto" required>
            </div>
            <div id="nomCheck"></div>
            <div class="lblcell">
                <label for="prenom">Prénom :</label>
            </div>
            <div class="inputCell">
                <input id="prenom" type="text" class="form-control my-auto" required>
            </div>
            <div class="lblcell">
                <label for="montant">Montant versé :</label>
            </div>
            <div class="inputCell">
                <input id="montant" type="number" class="form-control my-auto" style="width: 100px" value="0" required>
            </div>
            <div class="lblcell">
                <label for="email">Adresse e-mail :</label>
            </div>
            <div>
                <input id="email" type="text" class="form-control my-auto" pattern="^[0-9a-zA-Z]([-_\.]?[0-9a-zA-Z])*@[0-9a-zA-Z]([-_\.]?[0-9a-zA-Z])*[\.][a-zA-Z]{2,4}$" required>
            </div>
            <div id="emailCheck"></div>
            <div class="lblcell">
                <label for="password">Mot de passe :</label>
            </div>
            <div>
                <input id="password" type="password" class="form-control my-auto" pattern="^.{8,15}$" required>
            </div>
            <div id="passwordCheck"></div>
            <div class="lblcell">
                <label for="passwordConfirm">Confirmation du mot de passe :</label>
            </div>
            <div>
                <input id="passwordConfirm" type="text" class="form-control my-auto" pattern="^.{8,15}$" required>
            </div>
            <div id="passwordConfirmCheck"></div>

            <div class="btncell mt-5 d-flex flex-column">
                <button id="btnAjouter" type="submit" class="btn btn-danger m-auto" style="width: 120px">Ajouter</button>
                <div id="message" class="mx-auto text-center mt-3" style="height: 200px; width: 200px"></div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
