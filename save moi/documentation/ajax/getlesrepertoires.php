<?php

$chemin = '../../document/';
$lesRepertoires = [];
//parcours des fichiers du répertoire document
$repertoire = opendir($chemin);
$fichier = readdir($repertoire);
while ($fichier !== false) {
    if ($fichier != "." && $fichier != ".." && is_dir("$chemin$fichier")) {
        $lesRepertoires[] = $fichier;
    }
    $fichier = readdir($repertoire);
}
closedir($repertoire);
echo json_encode($lesRepertoires);