<!DOCTYPE html>
<html lang="fr">
<head>
    <?php
    require '../include/head.php';
    ?>
    <script src="../composant/ctrl.js"></script>
    <script src="../composant/date.js"></script>
    <script src="ajout.js"></script>
</head>
<body>
<div class="container" style="padding-left:20px; padding-right:20px; min-width:600px">
    <?php require '../include/menu.php'; ?>
    <div id='corps'>
        <div class="form-row mt-3">


            <div class="col-12 navbar-nav mr-auto">
                <label for="description" class="col-form-label"></label>
                <h3>Rédiger votre/vos question(s)</h3>
                <form role="form" id="contactForm">

                    <label for="nom" class="obligatoire col-form-label">Nom et prenom:</label>
                    <input id="nom"
                           type="text"
                           class="form-control ctrl"
                           pattern="^[A-Za-z]([A-Za-z ]*[A-Za-z])*$"
                           maxlength='70'
                           autocomplete=off>
                    <span class='messageErreur'></span>

                    <label for="email" class="obligatoire col-form-label">Email :</label>
                    <input   id="email"
                             type="text"
                             class="form-control ctrl"
                             maxlength='100'
                             autocomplete="off"
                             pattern="^[a-zA-Z0-9.]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$">
                    <span class='messageErreur'></span>

                    <label for="contenu">Votre Message :</label>
                    <textarea name="contenu" id='description' class="form-control" rows="10" style="resize:vertical;
                    min-height:10px"></textarea>
                    <div id='messageDescription' class='messageErreur'></div>
                </form>
                <div>
                    <button id='btnAjouter' class="btn btn-danger float-right">Ajouter</button>
                </div>
            </div>

        </div>
    </div>
    <?php require '../include/pied.php'; ?>
</div>
</body>
</html>
