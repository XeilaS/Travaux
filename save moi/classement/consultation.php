<!DOCTYPE html>
<html lang="fr">
<head>
    <?php
    require '../include/head.php';
    ?>
    <script src="consultation.js"></script>
    <script src="../composant/datatables/datatables.min.js"></script>
    <script src="../composant/datatables/moment.min.js"></script>
    <script src="../composant/datatables/datetime-moment.js"></script>
    <script src="consultation.js"></script>
</head>
<body>
<div class="container" style="padding-left:20px; padding-right:20px; min-width:600px">
    <?php require '../include/menu.php'; ?>

    <div class="card">
        <div class='table-responsive'>
            <table id="leTableau" class='table table-sm  table-bordered'>
                <thead>
                <tr>
                    <th style='width:30px'>Voir</th>
                    <th style='width:100px'>Date</th>
                    <th style='width:250px'>Epreuve</th>
                    <th style='width:50px'>Distance</th>
                    <th style='width:100px' class="text-center">Participants</th>
                </tr>
                </thead>
                <tbody id="lesLignes"></tbody>
            </table>
        </div>
    </div>
    <?php require '../include/pied.php'; ?>
</div>
</body>
</html>