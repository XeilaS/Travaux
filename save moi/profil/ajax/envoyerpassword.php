<?php
// vérification des paramètres
if (!isset($_POST['email'])) {
    echo "Paramètres manquants";
    exit;
}

// connexion à la base de données
require '../../class/class.database.php';
$db = Database::getInstance();

// récupération des données transmises
$email = $_POST["email"];

// Récupération du membre correspondant
$db = Database::getInstance();

$sql = <<<EOD
    SELECT nom, prenom, password 
    FROM membre
    Where email = :email

EOD;
$curseur = $db->prepare($sql);
$curseur->bindParam('email', $email);
$curseur->execute();
$ligne = $curseur->fetch();
$curseur->closeCursor();
if ($ligne) {
    $code = $ligne['password'];
    $prenom = $ligne['prenom'];
    $nom = $ligne['nom'];

    // récupération de l'adresse de l'expéditeur :
    $sql = <<<EOD
        Select emailContact
        From parametre;
EOD;
    $curseur = $db->query($sql);
    $ligne = $curseur->fetch(PDO::FETCH_ASSOC);
    $curseur->closeCursor();
    $expediteur = $ligne['emailContact'];

    // envoi d'un email
    $sujet = "Demande de code d'accès pour l'espace membre de l'Amicale du Val de Somme";
    $message = "Bonjour $prenom, vous avez demandé l'envoi de votre code d'accès à l'espace membre de l'Amicale du Val de Somme \n";
    $message .= "<br><br> Votre code est le suivant : $code \n \n";
    $message .= "<br><br> Rappel de votre login  : $nom \n \n";
    $message .= "<br><br>Le site du Val de Somme<br>";
    $destinataire = $email;
    ini_set("SMTP", "smtp.free.fr");
    ini_set("sendmail_from", $expediteur);
    $entete = "MIME-Version: 1.0\r\n";
    $entete .= "Content-type: text/html; charset=utf-8\n";
    $entete .= "Reply-to: " . $expediteur . "\r\n";
    $entete .= "From: " . $expediteur . "\r\n";
    $msg = stripslashes($message);
    $ok = mail($destinataire, $sujet, $msg, $entete);
    if ($ok) {
        echo 1;
    } else {
        echo "L'envoi a échoué, veuillez réessayer ultérieurement ou contactez le WebMaster";
    }
} else {
    echo "Cette adresse mail n'a pas été reconnue";
}
