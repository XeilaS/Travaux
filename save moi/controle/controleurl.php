<?php

require '../class/class.database.php';

$db = Database::getInstance();
$sql = <<<EOD
        Select id, url
        From reportage
EOD;
$curseur = $db->query($sql);
$lesLignes = $curseur->fetchAll(PDO::FETCH_ASSOC);
$curseur->closeCursor();

foreach ($lesLignes as $ligne) {
    if (!urlExists($ligne['url'])) {
        // suppression dans la base de données
        $sql = <<<EOD
            delete from reportage
            where id = :id
EOD;
        $curseur = $db->prepare($sql);
        $curseur->bindParam('id', $ligne['id']);
        $curseur->execute();
    }
}

// réponse en trois minutes pour 120 test
function urlExists($url)
{
    $f = @fopen($url, "r");
    if ($f) {
        fclose($f);
        return true;
    } else return false;
}


// source https://garridodiaz.com/check-if-url-exists-and-is-online-php/
// les codes HTTP https://facemweb.com/creation-site-internet/codes-http

function urlExists0($url) {
    @$headers = get_headers($url);
    if (preg_match('/^HTTP/d.ds+(200|301|302)/', $headers[0])){
        return true;
    }
    else return false;
}


// moins de 30 secondes mais mauvaise réponse car les urls sont des raccourcis qui existent toujours
function urlExists1($url) {
    $resURL = curl_init();
    curl_setopt($resURL, CURLOPT_URL, $url);
    curl_setopt($resURL, CURLOPT_HEADERFUNCTION, 'curlHeaderCallback');
    curl_setopt($resURL, CURLOPT_FAILONERROR, 1);
    curl_exec ($resURL);
    echo $intReturnCode = curl_getinfo($resURL, CURLINFO_HTTP_CODE);
    curl_close ($resURL);
    if ($intReturnCode != 200 && $intReturnCode != 302 && $intReturnCode != 304) {
        return false;
    }
    else return true;
}



// réponse en moins de 10 secondes pour 120 test mais mauvaise réponse

function urlExists2($url)
{
    $url = @parse_url($url);
    if (!$url) return false;

    $url = array_map('trim', $url);
    $url['port'] = (!isset($url['port'])) ? 80 : (int)$url['port'];

    $path = (isset($url['path'])) ? $url['path'] : '/';
    $path .= (isset($url['query'])) ? "?$url[query]" : '';

    if (isset($url['host']) && $url['host'] != gethostbyname($url['host'])) {

        $fp = fsockopen($url['host'], $url['port'], $errno, $errstr, 30);

        if (!$fp) return false; //socket not opened

        fputs($fp, "HEAD $path HTTP/1.1\r\nHost: $url[host]\r\n\r\n"); //socket opened
        $headers = fread($fp, 4096);
        fclose($fp);

        if (preg_match('#^HTTP/.*\s+[(200|301|302)]+\s#i', $headers)) {//matching header
            return true;
        } else return false;

    } // if parse url
    else return false;
}

