<?php

function estAutorise($idFonction, $db) {
    if (session_status() === PHP_SESSION_NONE) session_start();
    // il faut être connecté
    if (!isset($_SESSION['membre'])) return false;
    // Il faut être administrateur
    if ($_SESSION['membre']['admin'] === 1) return true;
    // ou avoir le droit d'accès sur cette fonction
    $sql = <<<EOD
        Select 1
        From droit 
        where idAdministrateur = :idMembre
        and idFonction = :idFonction
EOD;
    $curseur = $db->prepare($sql);
    $curseur->bindParam('idMembre', $_SESSION['membre']['id']);
    $curseur->bindParam('idFonction', $idFonction);
    $curseur->execute();
    $ligne = $curseur->fetch(PDO::FETCH_ASSOC);
    $curseur->closeCursor();
    return (!$ligne) ? false : true;
}