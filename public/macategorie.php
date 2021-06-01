<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Val de Somme</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link rel="icon" type="image/png" href="../icone.png">

    <link rel="stylesheet" href="../composant/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="../composant/noty/noty.css">
    <link rel="stylesheet" href="../composant/noty/sunset.css">
    <link rel="stylesheet" href="../composant/noty/animate.css">
    <link rel="stylesheet" href="../css/style.css">

    <script src="../composant/jquery.js"></script>
    <script src="../composant/bootstrap/bootstrap.bundle.min.js"></script>
    <script src="../composant/noty/noty.min.js"></script>
    <script src="../composant/date.js"></script>
    <script src="../composant/std.js"></script>
    <script src="../composant/ctrl.js"></script>
    <script src="macategorie.js"></script>
</head>
<body>
<div class="container" style="padding-left:20px">
    <?php
    require '../include/menu.php';
    ?>
    <div id='corps'>
        <div class="d-flex justify-content-center mt-5">
            <div id='saisie' class="card" style="width: 26rem;">
                <div class="card-header bg-light">Obtenir ma catégorie le jour d'une course</div>
                <div class="card-body">
                    <div class="form-group ">
                        <label for="dateNaissance" class="obligatoire">Votre date de naissance</label>
                        <input id='dateNaissance'
                               type="date"
                               class="form-control ">
                        <div class='messageErreur'></div>
                    </div>
                    <div class="form-group ">
                        <label for="dateCourse" class="obligatoire">Date de la course</label>
                        <input id='dateCourse'
                               type="date"
                               class="form-control ">
                        <div class='messageErreur'></div>
                    </div>
                    <div class="text-center">
                        <button id='btnCalculer' class='btn btn-danger '>Calculer</button>
                    </div>
                </div>
                <div class="card-footer" id="reponse">

                </div>
            </div>
        </div>
    </div>
    <?php require '../include/pied.php'; ?>
</div>

</body>
</html>
			