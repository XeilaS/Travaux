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
    <script src="liste.js"></script>
</head>
<body>
<div class="container" style="padding-left:20px; padding-right:20px; min-width:600px">
    <?php require '../include/menu.php'; ?>
    <div id='corps'>
        <img src="../img/construction.jpg" alt="En cours de construction" class="p-3">
    </div>
    <?php require '../include/pied.php'; ?>
</div>
</body>
</html>