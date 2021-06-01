<?php
require '../include/fonction.php';
require '../class/class.database.php';
$db = Database::getInstance();
if (!estAutorise(16, $db)) {
    echo "Accès interdit";
    exit;
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <?php
    require '../include/head.php';
    ?>
    <script src="../composant/ctrl.js"></script>
    <script src="../composant/date.js"></script>
    <script src="ajout.js"></script>
</head>
<body>

<div class="container" style="padding-left:20px; padding-right:20px; min-width:600px">
    <?php require '../include/menu.php'; ?>
    <div class="cadre bg-white mx-auto">
        <div class="card-header" style="border-radius: 0.25rem;"><h5>Ajouter un classement</h5> </div>
        <div class="card-body">
            <div class="row mt-1 justify-content-around align-items-center">
                <div class="col-sm-5 col-md-4 col-lg-3">
                    <!--------------------------------------- CARD -------------------------------------------------->
                    <div class="card ">
                        <div class="card-header" style="">
                            Nouveau document
                        </div>

                        <!----------------------------------- Drop Drag click fichier ------------------------------------>

                        <div class="card-body">

                            <input type="file" id="fichier" accept=".pdf" style='display: none '>
                            <div id="cible" class="cadreDoc obligatoire">
                                Déposez le document ici <br> ou <br> sélectionnez un document en cliquant dans le cadre
                            </div>
                            <span id='messageDocument' class="messageErreur"></span>
                        </div>
                    </div>
                </div>
                <!--------------------------------------- DEBUT ALIGNEMENT A DROITE ---------------------------------------->

                <div>
                    <!----------------------------------- Sélectionner nom epreuve-------------------------------------------->

                    <div class="form-group">
                        <label for="nomEpreuve" class="obligatoire">Nom de l'epreuve</label>
                        <select id="nomEpreuve"
                                class="form-control col-7 " required>
                            <option value="HIVER">HIVER</option>
                            <option value="PRINTEMPS">PRINTEMPS</option>
                            <option value="ETE">ETE</option>
                            <option value="AUTOMNE">AUTOMNE</option>
                        </select>
                    </div>

                    <!----------------------------------- Fin Selection nom epreuve ----------------------------------------------->

                    <!-- ##### -->

                    <!----------------------------------- Sélectionner Distance-------------------------------------------->

                    <div class="form-group">
                        <label for="distance" class="obligatoire">Distance</label>
                        <select id="distance"
                                class="form-control col-5" required>
                            <option value="10 Km">10 Km</option>
                            <option value="5 Km">5 Km</option>
                        </select>
                    </div>

                    <!----------------------------------- Fin Selection Distance ----------------------------------------------->

                    <!-- ##### -->

                    <!----------------------------------- Nombres participants-------------------------------------------->

                    <div class="form-group">
                        <label for="nbParticipant" class="obligatoire col-form-label">Nombres de
                            participants</label>
                        <input id="nbParticipant"
                               type="text"
                               class="form-control ctrl col-4"
                               pattern="^[0-9]+$"
                               autocomplete="off"
                               required>
                        <span class='messageErreur'></span>
                    </div>

                    <!----------------------------------- Fin Nb de participants -------------------------------------->

                    <!-- ##### -->

                    <!----------------------------------- Date de l'épreuve-------------------------------------------->

                    <div class="form-group">
                        <label for="dateEpreuve" class="obligatoire col-form-label">Date de l'épreuve
                            (jj/mm/aaaa)</label>
                        <input id='dateEpreuve' type="date" min="1983-01-01" class="form-control col-9 ctrl">
                        <span class='messageErreur'></span>
                    </div>


                    <!----------------------------------- FIN ALIGNEMENT A DROITE-------------------------------------------->

                </div>
            </div>
            <div class="text-center">
                <button id='btnAjouter' class="btn btn btn-danger">Ajouter</button>
            </div>
        </div>
    </div>
</body>
</html>


