<?php
$chemin = "../";
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
    <link rel="stylesheet" href="../composant/noty/sunset.css">
    <link rel="stylesheet" href="../composant/noty/animate.css">
    <link rel="stylesheet" href="../css/style.css">

    <script src="../composant/jquery.js"></script>
    <script src="../composant/bootstrap/bootstrap.bundle.min.js"></script>
    <script src="../composant/noty/noty.min.js"></script>
    <script src="../composant/std.js"></script>
    <script src="consultation.js"></script>
</head>
<body>
<div class="container" style="padding-left:20px; padding-right:20px; min-width:600px">
    <?php require '../include/menu.php'; ?>
    <div id='corps'>

        <div class="card">
            <div id='lesCartes'</div>
        </div>
    </div>
</div>

<?php require '../include/pied.php'; ?>

</body>
</html>