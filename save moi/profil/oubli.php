<!DOCTYPE html>
<html lang="fr">
<head>
    <?php
    include '../include/head.php';
    ?>
    <script src="../composant/ctrl.js"></script>
    <script src="oubli.js"></script>
</head>
<body>
<div class="container" style="">
    <?php
    require '../include/menu.php';
    ?>
    <div id='corps'>
        <div class="d-flex justify-content-center">
            <div id='saisie' class="card" style="width: 26rem;">
                <div class="card-header bg-light">
                    Obtenir son code d'accès à l'espace membres
                </div>
                <div class="card-body">

                    <div class="form-group ">
                        <label for="email" class="obligatoire">Votre adresse mail</label>
                        <input type="text"
                               placeholder="Adresse e-mail"
                               id="email"
                               class="form-control "
                               pattern="^[0-9a-zA-Z]([-_\.]?[0-9a-zA-Z])*@[0-9a-zA-Z]([-_\.]?[0-9a-zA-Z])*[\.][a-zA-Z]{2,4}$"
                               autocomplete="off">
                        <div class='messageErreur'></div>
                    </div>
                    <div class="text-center">
                        <button id='btnEnvoyer' class='btn btn-danger '>Envoyer</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php require '../include/pied.php'; ?>
</div>

</body>
</html>
			