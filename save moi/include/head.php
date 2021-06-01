<?php
set_include_path(get_include_path() . PATH_SEPARATOR . $_SERVER['DOCUMENT_ROOT']);
$chemin = "http://" . $_SERVER['SERVER_NAME'] . '/';
?>

<title>Amicale du Val de Somme</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<link rel="icon" type="image/png" href="<?= $chemin ?>icone.png">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

<link rel="stylesheet" href="<?= $chemin ?>composant/noty/noty.css">
<link rel="stylesheet" href="<?= $chemin ?>composant/noty/animate.css">
<link rel="stylesheet" href="<?= $chemin ?>composant/noty/sunset.css">
<link rel="stylesheet" href="<?= $chemin ?>css/style.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
<script src="<?= $chemin ?>composant/noty/noty.min.js"></script>
<script src="https://kit.fontawesome.com/af8740841f.js" crossorigin="anonymous"></script>
<script src="<?= $chemin ?>composant/std.js"></script>
<script src="<?= $chemin ?>composant/fonction.js"></script>
<script src="<?= $chemin ?>composant/transition/transition.min.js"></script>
