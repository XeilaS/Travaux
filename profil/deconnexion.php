<?php 
session_start();
// supprimer le contenu du tableau $_SESSION
session_unset();
// supprimer le tableau $_SESSION
session_destroy();
// supprimer le cookie si il existe
if (isset($_COOKIE['membre'])) setcookie('membre', '', time() - 3600, '/');
header("location:../index.php");
