<?php
$aide = <<<EOD
    Votre login correspond à votre nom suivi éventuellement d'un chiffre si ce nom n'est pas unique chez nos adhérent
    <br>Ce login vous a été envoyé lors de l'activation de votre compte
    <br>Si vous avez égaré votre login ou votre mot de passe, cliquez sur le bouton 'Mot de passe oublié'
    <br>Si vous cochez la case 'Se souvenir de moi', vos coordonnées de connexion seront conservés pendant 7 jours
    vous évitant ainsi de repasser par la grille de connexion lors de votre prochaine visite.
    <br> Il est conseillé de ne cocher la case que si vous être sur votre poste personnel.
EOD;
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <?php
    require '../include/head.php';
    ?>
    <script src="../composant/ctrl.js"></script>
    <script src="connexion.js"></script>
</head>
<body>
<div class="container" style=" padding-right: 20px">
    <?php require '../include/menu.php'; ?>
    <div id='corps'>
        <div class="d-flex justify-content-center mt-5 mb-5">
            <div class="card" style="">
                <div class="card-header bg-light">
                    <h5 class="text-center">Accéder à mon espace membre
                        <img src="../img/aide.png"
                             style="position : relative; top:-2px"
                             data-title="<b>Comment se connecter ?<b>"
                             data-toggle="popover"
                             data-trigger="hover"
                             data-html="true"
                             data-placement='bottom'
                             data-content="<?= $aide ?>"
                        >

                    </h5>
                </div>
                <div class="card-body">
                    <div id="erreur"></div>
                    <div class="form-group">
                        <label for="login" class="obligatoire">Login  </label>
                        <input id="login" class="form-control " type="text" autocomplete="off"/>
                        <div class='messageErreur'></div>
                    </div>
                    <div class="form-group">
                        <label for="code" class=" obligatoire">Code d'accès (au moins 4 caractères) </label>
                        <input id="code" class="form-control " type="password"/>
                        <div class='messageErreur'></div>
                    </div>
                    <div class="form-group text-left font-italic ">
                        <input type='checkbox' id='chkMemoriser' class=""/>
                        <label for='chkMemoriser'>Se souvenir de moi</label>
                    </div>
                    <div class="text-center pl-3 pr-3">
                        <button id='btnValider' class="btn btn-danger">Connexion</button>
                    </div>
                </div>
                <div class="card-footer text-center">
                        Si vous n'avez pas encore activé votre espace membre, <br>
                        <a class="text-white btn btn-primary" href="activation.php">Activez votre espace membre</a>
                        <br>Si vous avez oublié votre mot de passe, <br>
                        <a class="text-white btn btn-info" href="oubli.php">Mot de passe oublié</a>
                </div>
            </div>
        </div>
        </div>
    <?php require '../include/pied.php'; ?>
</div>
</body>
</html>
			