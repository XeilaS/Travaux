<?php
if (session_status() === PHP_SESSION_NONE) session_start();

require_once "class/class.database.php";
$db = Database::getInstance();
// génération des menus espaces membre, ajouter, gérer et administrer

$menu = "";
// Génération des options du menu membre pour un visiteur
if (isset($_SESSION['membre'])) {
    $menu .= <<<EOD
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" style=""
                   role="button" aria-haspopup="true" aria-expanded="false">
                    Espace membres
            </a>
        <div class="dropdown-menu">
            <a class="dropdown-item" href="{$chemin}documentation/consultation.php?idType=3">Documentation à télécharger</a>
            <a class="dropdown-item" href="{$chemin}profil/liste.php">La liste des membres</a>
EOD;

    // génération des options du menu Membre pour membre (et pas un admin)
    if ($_SESSION['membre']['admin'] === 0) {
        $menu .= <<<EOD
            <a class="dropdown-item" href="{$chemin}profil/fiche.php">Ma fiche membre</a>
            <a class="dropdown-item" href="{$chemin}profil/password.php">Modifier mon mot de passe</a>
            </div>
    </li>
EOD;
    }

    // récupérations des fonctionnalités supplémentaires attribuées aux membres menu ajout
    // récupérations des fonctionnalités supplémentaires attribuées aux membres menu ajout
    if ($_SESSION['membre']['admin'] === 1) {
        $sql = <<<EOD
            Select nom, fichier
            From fonction 
            where menu = 'Ajouter'
            Order by nom;
EOD;
        $curseur = $db->query($sql);

    } else {
        $sql = <<<EOD
            Select nom, fichier
            From fonction join droit on fonction.id = droit.idFonction
            and droit.idAdministrateur = :idMembre
            where menu = 'Ajouter'
            Order by nom;
EOD;
        $curseur = $db->prepare($sql);
        $curseur->bindParam('idMembre', $_SESSION['membre']['id']);
        $curseur->execute();
    }
    $lesLignes = $curseur->fetchAll(PDO::FETCH_ASSOC);
    $curseur->closeCursor();
    if (count($lesLignes) > 0) {
        // Ajout du menu Ajouter
        $menu .= <<<EOD
        <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" style=""
                   role="button" aria-haspopup="true" aria-expanded="false">
                    Ajouter
                </a>
                <div class="dropdown-menu">
                
EOD;
        foreach ($lesLignes as $fonction) {
            $nom = $fonction['nom'];
            $fichier = $fonction['fichier'];
            $menu .= <<<EOD
        <a class="dropdown-item" href="$chemin$fichier">$nom</a>
EOD;
        }
        $menu .= <<<EOD
               </div>
        </li>
EOD;
    }

    // récupérations des fonctionnalités supplémentaires attribuées aux membres menu Gérer
    if ($_SESSION['membre']['admin'] === 1) {
        $sql = <<<EOD
            Select nom, fichier
            From fonction 
            where menu = 'Gérer'
            Order by nom;
EOD;
        $curseur = $db->query($sql);
    } else {
        $sql = <<<EOD
            Select nom, fichier
            From fonction join droit on fonction.id = droit.idFonction
            and droit.idAdministrateur = :idMembre
            where menu = 'Gérer'
            Order by nom;
EOD;
        $curseur = $db->prepare($sql);
        $curseur->bindParam('idMembre', $_SESSION['membre']['id']);
        $curseur->execute();
    }

    $lesLignes = $curseur->fetchAll(PDO::FETCH_ASSOC);
    $curseur->closeCursor();
    if (count($lesLignes) > 0) {
        // Ajout du menu Gérer
        $menu .= <<<EOD
        <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" style=""
                   role="button" aria-haspopup="true" aria-expanded="false">
                    Gérer
                </a>
                <div class="dropdown-menu">
                
EOD;
        foreach ($lesLignes as $fonction) {
            $nom = $fonction['nom'];
            $fichier = $fonction['fichier'];
            $menu .= <<<EOD
        <a class="dropdown-item" href="$chemin$fichier">$nom</a>
EOD;
        }
        $menu .= <<<EOD
               </div>
        </li>
EOD;
    }
    if ($_SESSION['membre']['admin'] === 1) {

        $menu .= <<<EOD
        <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" style=""
                   role="button" aria-haspopup="true" aria-expanded="false">
                    Administrer
                </a>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="{$chemin}administrateur/index.php">
                        Définir les administrateurs
                    </a>
                    <a class="dropdown-item" href="{$chemin}droit/index.php">
                        Définir les droits  les administrateurs
                    </a>

                </div>
        </li>
EOD;
    }
}



// génération des menus club et 4 saisons

$sql = <<<EOD
        Select saison from parametre
EOD;
$curseur = $db->query($sql);
$ligne = $curseur->fetch(PDO::FETCH_ASSOC);
$curseur->closeCursor();
$saison = $ligne['saison'];

// recherche de fonctions à ne pas afficher dans le menu Club faute de données ou en fonction de la date

$sql = " Select 1 from parametre where curDate() between debutAdhesion and finAdhesion";
$curseur = $db->query($sql);
$ligne = $curseur->fetch();
$curseur->closeCursor();
$adhesion = $ligne ? 0 : 1;

$sql = " Select count(*) From epreuve where date >= curdate()";
$curseur = $db->query($sql);
$ligne = $curseur->fetch();
$curseur->closeCursor();
$epreuve = ($ligne[0] === '0') ? 0 : 1;


$sql = " Select count(*) From document where idType = 1";
$curseur = $db->query($sql);
$ligne = $curseur->fetch();
$curseur->closeCursor();
$docClub = ($ligne[0] === '0') ? 0 : 1;

$sql = "Select count(*) From lien";
$curseur = $db->query($sql);
$ligne = $curseur->fetch();
$curseur->closeCursor();
$lien = ($ligne[0] === '0') ? 0 : 1;

$sql = "Select count(*) From lienffa";
$curseur = $db->query($sql);
$ligne = $curseur->fetch();
$curseur->closeCursor();
$lienffa = ($ligne[0] === '0') ? 0 : 1;


$sql = "Select count(*) From partenaire where domaine in (1,3)";
$curseur = $db->query($sql);
$ligne = $curseur->fetch();
$curseur->closeCursor();
$partenaire = ($ligne[0] === '0') ? 0 : 1;

// alimenter la variable $deconnexion
if(!isset($_SESSION['membre'])) {
    $deconnexion = <<<EOD
       <a class="btn btn-success" href="{$chemin}profil/connexion.php">
         Se connecter
       </a>
EOD;
} else {
    $deconnexion = <<<EOD
       <a class="btn btn-danger" href="{$chemin}profil/deconnexion.php">
         Se déconnecter
       </a>
EOD;
}

// génération du menu club

$menuClub = <<<EOD
    <a class="dropdown-item" href="{$chemin}page/consultation.php?id=1">Présentation du club</a>
    <a class="dropdown-item" href="{$chemin}page/consultation.php?id=4">Les entrainements</a>
    <a class="dropdown-item" href="{$chemin}page/consultation.php?id=11">L'agenda du club</a>
    <div class="dropdown-divider"></div>
    <a class="dropdown-item" href={$chemin}information/consultation.php?idType=1">Les actualités</a>
EOD;

if ($lienffa === 1) {
    $menuClub .= <<<EOD
           <a class="dropdown-item" href="{$chemin}ffa/consultation.php">Résultats sportifs</a>
EOD;
}

if ($epreuve === 1) {
    $menuClub .= <<<EOD
    <a class="dropdown-item" href="{$chemin}epreuve/consultation.php">Les prochaines épreuves organisées</a>
EOD;
}

if ($docClub === 1) {
    $menuClub .= <<<EOD
    <a class="dropdown-item" href="{$chemin}documentation/consultation.php?idType=1">Documentation à télécharger</a>
EOD;
}


if ($partenaire === 1) {
    $menuClub .= <<<EOD
    <a class="dropdown-item" href="{$chemin}partenaire/consultation.php?domaine=1">Les partenaires du club</a>
EOD;
}

if ($lien === 1) {
    $menuClub .= <<<EOD
       <a class="dropdown-item" href="{$chemin}lien/consultation.php">Liens</a>
EOD;
}

$menuClub .= <<<EOD
    <a class="dropdown-item" href="{$chemin}page/consultation.php?id=5">Courses en vue pour la saison</a>
    <div class="dropdown-divider"></div>
    <a class="dropdown-item" href="{$chemin}page/consultation.php?id=2">Informations pour l'adhésion au club</a>
    <a class="dropdown-item" target="_blank" href="https://www.helloasso.com/associations/amicale-du-val-de-somme/adhesions/adhesion-a-l-amicale-du-val-de-somme">S'inscrire pour la saison <?= $saison ?></a>
    <div class="dropdown-divider"></div>
    <a class="dropdown-item" href="{$chemin}page/consultation.php?id=3">Le bureau du club</a>
    <a class="dropdown-item" href="{$chemin}message/ajout.php">Nous poser une question</a> 
EOD;

// recherche de fonctions à ne pas afficher faute de données dans le menu 4 saisons

$sql = " Select count(*) From document where idType = 2";
$curseur = $db->query($sql);
$ligne = $curseur->fetch();
$curseur->closeCursor();
$doc4s = ($ligne[0] === '0') ? 0 : 1;

$sql = "Select count(*) From classement";
$curseur = $db->query($sql);
$ligne = $curseur->fetch();
$curseur->closeCursor();
$classement = ($ligne[0] === '0') ? 0 : 1;

$sql = "Select count(*) From reportage";
$curseur = $db->query($sql);
$ligne = $curseur->fetch();
$curseur->closeCursor();
$reportage = ($ligne[0] === '0') ? 0 : 1;

$sql = "Select count(*) From partenaire where domaine in (2,3)";
$curseur = $db->query($sql);
$ligne = $curseur->fetch();
$curseur->closeCursor();
$partenaire = ($ligne[0] === '0') ? 0 : 1;


// génération du menu 4 saisons

$menu4s = <<<EOD
    <a class="dropdown-item" href="{$chemin}page/consultation.php?id=7">Présentation</a>
    <a class="dropdown-item" href={$chemin}information/consultation.php?idType=2">Les actualités</a>
EOD;

if ($doc4s === 1) {
    $menu4s .= <<<EOD
       <a class="dropdown-item" href="{$chemin}documentation/consultation.php?idType=2">Documentation à télécharger</a>
EOD;
}

if ($classement === 1) {
    $menu4s .= <<<EOD
         <a class="dropdown-item" href="{$chemin}classement/consultation.php">Les classements</a>
EOD;
}

if ($reportage === 1) {
    $menu4s .= <<<EOD
         <a class="dropdown-item" href="{$chemin}reportage/consultation.php">Les reportages photo</a>
EOD;
}

$menu4s .= <<<EOD
    <a class="dropdown-item" href="{$chemin}resultat/resultatc.php">Résultat des courses</a>
    <a class="dropdown-item" href="{$chemin}resultat/resultati.php">Résultat individuel</a>
    <a class="dropdown-item" href="{$chemin}page/consultation.php?id=12">Règlement de l'épreuve</a>
EOD;

if ($partenaire === 1) {
    $menu4s .= <<<EOD
         <a class="dropdown-item" href="{$chemin}partenaire/consultation.php?domaine=2">Les partenaires des 4 saisons</a>
EOD;
}

$menu4s .= <<<EOD
    <a class="dropdown-item" href="{$chemin}public/macategorie.php">Ma catégorie le jour de la course</a>
    <a class="dropdown-item" href="{$chemin}public/impcategories.php">Les catégories en courses à pied</a>
EOD;
?>

<nav class="navbar navbar-expand-sm navbar-dark mt-3" style="background-color: transparent">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#nav-content"
            aria-controls="nav-content" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <a class="navbar-brand" href="<?= $chemin ?>index.php" data-toggle='tooltip' title="Dernières informations"
       data-placement='bottom'>
        <img class=" img-fluid" src="<?= $chemin ?>img/logo.gif" alt="Val de Somme">
    </a>
    <div class="collapse navbar-collapse " id="nav-content">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" style=""
                   role="button" aria-haspopup="true" aria-expanded="false">
                    Le club
                </a>
                <div class="dropdown-menu">
                    <?= $menuClub ?>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" style=""
                   role="button" aria-haspopup="true" aria-expanded="false">
                    Les 4 saisons
                </a>
                <div class="dropdown-menu">
                    <?= $menu4s ?>
                </div>
            </li>

            <?= $menu ?>
        </ul>
        <?= $deconnexion ?>
    </div>
</nav>
<div id='msg' class="mt-1 mb-1"></div>