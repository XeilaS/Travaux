<?php
session_start();
require '../../class/class.database.php';
$db = Database::getInstance();

// vérification des paramètres
if (!isset($_POST['login']) || !isset($_POST['code']) || !isset($_POST['memoriser'])) {
    echo "Paramètres manquants";
    exit;
}

$login = strtolower($_POST["login"]);
$code =  strtolower($_POST["code"]);
$memoriser =  $_POST["memoriser"];

if($login === 'admin') {
    $code = hash('sha1', $code);
    $sql = <<<EOD
	Select  code
	From parametre;
EOD;
    $curseur = $db->query($sql);
    $ligne = $curseur->fetch();
    $curseur->closeCursor();
    if ($code === $ligne['code']) {
        $_SESSION['membre']['id'] = 0;
        $_SESSION['membre']['admin'] = 1;
        $_SESSION['membre']['nom'] = 'Le Webmaster du site';
        $_SESSION['membre']['prenom'] = '';
        echo 1;
    } else {
        echo "Identifiant ou mot de passe invalide";
    }
} else {

// vérification du mot de passe
    $sql = <<<EOD
        SELECT id, nom, prenom, email, lcase(password) as password
        FROM membre 
        WHERE lcase(login) = :login;
EOD;

    $curseur = $db->prepare($sql);
    $curseur->bindParam('login', $login);
    $curseur->execute();
    $ligne = $curseur->fetch(PDO::FETCH_ASSOC);
    $curseur->closeCursor();
    if (!$ligne) {
        echo "Identifiant ou mot de passe invalide";
    } else if ($ligne['password'] != $code) {
        echo "Identifiant ou mot de passe invalide";
    } else {
        $_SESSION['membre']['id'] = $ligne['id'];
        $_SESSION['membre']['nom'] = $ligne['nom'];
        $_SESSION['membre']['prenom'] = $ligne['prenom'];
        $_SESSION['membre']['admin'] = 0;

        if ($memoriser === '1') {
            setcookie('membre', $login . '-' . sha1($ligne['nom'] . $ligne['prenom'] . $_SERVER['REMOTE_ADDR']), time() + 3600 * 24 * 3, '/');
        }
        // mémorisation de la connexion dans le fichier connexion.log
        $c = date("Y-m-d h:i:s") . " " .  $ligne['nom']  . " " .  $ligne['prenom'] .        "\n";
        file_put_contents('connexion.log', $c, FILE_APPEND | LOCK_EX);

        // mémoriser la connexion dans la table membre
        $sql = <<<EOD
        update membre
            set nbConnexion = nbConnexion + 1 
        WHERE id = :id;
EOD;
        $curseur = $db->prepare($sql);
        $curseur->bindParam('id', $ligne['id']);
        $curseur->execute();

        echo 1;
    }
}








