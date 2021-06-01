<!DOCTYPE html>
<html lang="fr">
<head>
    <?php
    require '../include/head.php';
    ?>
    <script src="consultation.js"></script>
</head>
<body>
<div class="container" style="padding-left:20px; padding-right:20px; min-width:600px">
    <?php require '../include/menu.php'; ?>
    <div class="card">
        <div class="card-body">
            <div id="msg" class="mt-2"></div>
            <div class='table-responsive mt-3'>
                <table class='table table-sm table-borderless'>
                    <thead>
                    <tr>

                        <th style='width:180px'>Titre</th>
                        <th style='width:180px'>Date émission</th>
                        <th style='width:180px'>Télécharger</th>


                    </tr>
                    </thead>
                    <tbody id="lesLignes"></tbody>
                </table>
            </div>
        </div>
    </div>
    <?php require '../include/pied.php'; ?>
</div>
</body>
</html>


