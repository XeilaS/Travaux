<?php
session_start();
require '../../class/class.database.php';
$db = Database::getInstance();

$id = $_SESSION['membre']['id'];
$email = $_POST['email'];
$fixe = $_POST['fixe'];
$mobile = $_POST['mobile'];

if (!isset($id, $email)) {
    echo "Parametres manquants";
    exit;
}

if ($_POST['autMail'] == 1){
    $sql = <<<EOD
	    update membre
	        set autMail = 1
	    where id = :id;
EOD;
    $curseur = $db->prepare($sql);
    $curseur->bindParam('id', $id);
    $curseur->execute();
    $curseur->closeCursor();

} else{
    $sql = <<<EOD
	    update membre
	        set autMail = 0
	    where id = :id;
EOD;
    $curseur = $db->prepare($sql);
    $curseur->bindParam('id', $id);
    $curseur->execute();
    $curseur->closeCursor();
}

if ($_POST['abtInformation'] == 1){
    $sql = <<<EOD
	    update membre
	        set abtInformation = 1
	    where id = :id;
EOD;
    $curseur = $db->prepare($sql);
    $curseur->bindParam('id', $id);
    $curseur->execute();
    $curseur->closeCursor();
} else{
    $sql = <<<EOD
	    update membre
	        set abtInformation = 0
	    where id = :id;
EOD;
    $curseur = $db->prepare($sql);
    $curseur->bindParam('id', $id);
    $curseur->execute();
    $curseur->closeCursor();
}

// controle
$sql = <<<EOD
   Select email, fixe, mobile
   from membre
   where id = :id;
EOD;
$curseur = $db->prepare($sql);
$curseur->bindParam("id", $id);
$curseur->execute();
$lesLignes = $curseur->fetchAll(PDO::FETCH_ASSOC);

if ($email == $lesLignes[0]['email'] && $fixe == $lesLignes[0]['fixe'] && $mobile == $lesLignes[0]['mobile']){
    // cas ou les données n'ont pas changé
    echo "-3";
} else{
    //if (!$emailOk)
    //    echo "-2";
    //elseif ($fixeOk != 1)
    //    echo "-1";
    //elseif ($mobileOk != 1)
    //    echo "0";
    //else {
        $sql = <<<EOD
        update membre
            set email = :email, fixe = :fixe, mobile = :mobile
        where id = :id;
EOD;
        $curseur = $db->prepare($sql);
        $curseur->bindParam('id', $id);
        $curseur->bindParam('email', $email);
        $curseur->bindParam('fixe', $fixe);
        $curseur->bindParam('mobile', $mobile);
        $curseur->execute();
        $curseur->closeCursor();
        echo "1";
    //}
}
