<?php
//getliens est utiliser pour la consultation donc consultation.js mais aussi pour la gestions des liens mais
require '../../class/class.database.php';
$db = Database::getInstance();
//récupération des données
$sql = <<<EOD
SELECT id, nom, url, description, rang, logo
FROM lien
order by rang;
EOD;
$curseur = $db->query($sql);
$lesLiens = $curseur->fetchAll(PDO::FETCH_ASSOC);
$curseur->closeCursor();


$rep = '../logo/';
$nb = count($lesLiens);
$i = 0;
for ($i = 0; $i < $nb; $i++) {
//  vérification de l'existence du logo
   $lien =   $lesLiens[$i];
   $nomFichier = $rep . $lien['logo'] ;
   if (empty($lien['logo']))
       $lesLiens[$i]['logo'] = 'defaut.png';
   elseif (!file_exists($nomFichier))
       $lesLiens[$i]['logo'] = 'nontrouve.png';
}
echo json_encode($lesLiens);