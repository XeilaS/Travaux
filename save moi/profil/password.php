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
    <script src="../composant/ctrl.js"></script>
    <script src="../composant/ckeditor/ckeditor.js"></script>
    <script src="password.js"></script>
</head>
<body>
<div class="container" style="">
    <?php require "../include/menu.php"; ?>
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-center mt-5">
                <div class="card" style="width: 26rem;">
                    <div class="card-header bg-light">
                        <h5 class="text-center">Modifier mon mot de passe</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="passwordActuel" class="obligatoire col-form-label">Mot de passe actuel</label>
                            <input type="password"
                                   id="passwordActuel"
                                   class="form-control ">
                            <span id='messagePasswordActuel' class='messageErreur'></span>
                        </div>
                        <div class="form-group">
                            <label for="password" class="obligatoire col-form-label">Nouveau mot de passe</label>
                            <input type="password"
                                   id="password"
                                   class="form-control "
                                   pattern=".{4,}$">
                            <span id='messagePassword' class='messageErreur'></span>
                        </div>
                        <div class="form-group text-left">
                            <label for="confirmation" class="obligatoire col-form-label">Confirmation du mot de
                                passe</label>
                            <input type="password"
                                   id="confirmation"
                                   class="form-control "
                                   pattern=".{4,}$">
                            <span id='messageConfirmation' class='messageErreur'></span>
                        </div>
                        <div class="row justify-content-center  mt-3 pl-3 pr-3">
                            <button id='btnValider' class="btn btn btn-danger text-white ">Modifier</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
