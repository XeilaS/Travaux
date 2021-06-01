<?php
session_start();
// statistique
require 'class/class.database.php';
$db = Database::getInstance();

// régénération de la session si un cookie existe
// il faut regénérer la session si un cookie existe et pas la session
if (!isset($_SESSION['membre']) && isset($_COOKIE['membre'])) {
    $user = explode('-', $_COOKIE['membre']);
    $sql = <<<EOD
              SELECT id, nom, prenom, email, idGroupe  FROM membre  WHERE login = :login;
EOD;
    $curseur = $db->prepare($sql);
    $curseur->bindParam('login', $user[0]);
    $curseur->execute();
    $ligne = $curseur->fetch(PDO::FETCH_ASSOC);
    $curseur->closeCursor();
    if ($ligne) {
        // le cookie est-il fiable
        $emprunte = sha1($ligne['nom'] . $ligne['prenom'] . $_SERVER['REMOTE_ADDR']);
        if ($emprunte !== $user[1]) {
            setcookie('membre', '', time() - 3600, '/');
        } else {
            // on allonge la durée de vie du cookie
            setcookie('membre', $ligne['nom'] . '-' . sha1($ligne['nom'] . $ligne['prenom'] . $_SERVER['REMOTE_ADDR']), time() + 3600 * 24 * 3, '/');
            // on regénère la session
            $_SESSION['membre']['id'] = $ligne['id'];
            $_SESSION['membre']['login'] = $user[0];
            $_SESSION['membre']['nom'] = $ligne['nom'];
            $_SESSION['membre']['prenom'] = $ligne['prenom'];
            $_SESSION['membre']['email'] = $ligne['email'];
            $_SESSION['membre']['admin'] = 0;
        }
    }
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <?php
    require 'include/head.php';
    ?>
    <script src="composant/date.js"></script>
    <script src="index.js"></script>
</head>
<body>
<div class="container">
    <?php require 'include/menu.php'; ?>
    <div id='corps2'>
        <div class="row masquer">
            <div class=" bg-transparent text-white text-center col-xl-5 col-md-12 ml-3 mt-1">
                <div class="d-flex" id="titre">
                    <h5 class="text-center masquer ">Bienvenue sur le site du <strong>Val de Somme</strong></h5>
                </div>
                <div class="d-flex text-center" id="facebook1">
                    <a href="https://www.facebook.com/Amicale-du-Val-de-Somme-522202624617617/"
                       class="m-auto text-white" target="'_blank">
                        <img src="<?= $chemin ?>img/facebook.png" class="bg-transparent">
                        Notre page Facebook
                    </a>
                </div>
                <div class="d-flex" id="logo">
                    <a href="http://cda80.athle.com"
                       class="m-auto text-white" target="'_blank">
                        <img src="<?= $chemin ?>img/cd80.png" class="bg-transparent">
                    </a>
                    <a href="https://courses80.fr"
                       class="m-auto text-white" target="'_blank">
                        <img src="<?= $chemin ?>img/courses80.png" class="bg-transparent">
                    </a>
                </div>
            </div>
            <div id='photos' class="col-6 masquer ml-5">
                <div class="carousel slide m-1 masquer" data-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img src="photo/annee.png" height="250px" class="image rounded-circle " alt="">
                        </div>
                        <div class="carousel-item">
                            <img src="photo/vds.jpg" height="250px" class="image rounded-circle " alt="">
                        </div>
                        <div class="carousel-item">
                            <img src="photo/vds2.jpg" height="250px" alt="" class="image rounded-circle">
                        </div>
                        <div class="carousel-item">
                            <img src="photo/vds3.jpg" height="250px" alt="" class="image rounded-circle">
                        </div>
                        <div class="carousel-item">
                            <img src="photo/vds4.jpg" height="250px" alt="" class="image rounded-circle">
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div id="prochaineEpreuve" class="card text-secondary border-dark bg-light mb-1" style="display:none">
            <div class="card-header text-danger">Prochaine épreuve organisée par le club</div>
            <div class="card-body" style="">
                <div class="row">
                    <div class="col-xl-6 col-md-12 ">
                        <div id="dateEpreuve"></div>
                        <div id="nomEpreuve"></div>
                        <div id="descriptionEpreuve"></div>
                    </div>
                    <div class="col-xl-6 col-md-12 masquer">
                        <div id="horloge" style="display: block">
                            <div>
                                <div class="smalltext">Jour</div>
                                <span id="jour"></span>
                            </div>
                            <div>
                                <div class="smalltext">Heure</div>
                                <span id="heure"></span>
                            </div>
                            <div>
                                <div class="smalltext">Minute</div>
                                <span id="minute"></span>
                            </div>
                            <div>
                                <div class="smalltext">Seconde</div>
                                <span id="seconde"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row m-3">
            <div id='club' class="col-sm p-3  ">
                <a href="information/consultation.php?idType=1" style="font-size: 1.5rem; width:100%"
                   class="btn-outline-primary btn btn-transparent btn-lg border rounded border-light text-light">
                    <span class="fa fa-comment"></span>
                    <br>
                    Les actualités du club
                </a>
            </div>
            <div id='saisons' class="col-sm p-3  ">
                <a href="information/consultation.php?idType=2" style="font-size: 1.5rem; width:100%"
                   class="btn-outline-primary btn btn-transparent btn-lg border rounded border-light text-light">
                    <span class="fa fa-comment"></span>
                    <br>
                    Les actualités des 4 saisons
                </a>
            </div>
        </div>

    </div>
    <?php require 'include/pied.php'; ?>
</div>
</body>
</html>