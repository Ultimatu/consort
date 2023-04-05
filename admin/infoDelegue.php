<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();
//verifier s'il est passé par la page de connexion
if (!isset($_SESSION['adminWantToLogin']) || $_SESSION['adminWantToLogin'] != true || !isset($_SESSION["email"])) {
    header("Location: ../index.php");
    exit;
}
//verifier si un id de produit est passé en parametre
if (!isset($_GET['id']) || empty($_GET['id'])) {
    $message = "<div class='alert alert-danger'>Aucun Delegue n'a été sélectionné</div>";
}
$idDelegue = $_GET['id'];

include '../includes/db.connect.php';

// Requête pour récupérer les données du délégué et les produits associés
$req = "SELECT delegue.*, produit.*, zone.district FROM delegue, produit, zone, delegue_zone_produit WHERE delegue.id_delegue = $idDelegue AND delegue_zone_produit.id_delegue= '$idDelegue' AND produit.id_produit = delegue_zone_produit.id_produit AND zone.id_zone = delegue_zone_produit.id_zone ORDER BY delegue.id_delegue";
$res = $db->prepare($req);
$res->execute();
$delegue_zone_produit = $res->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Détails du délégué</title>
    <!-- Liens CSS de Bootstrap -->
    <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body {
            background-color: #f5f5f5;
        }

        header {
            background-color: #4f65e3;
            padding: 20px;
            border-bottom: 1px solid #ddd;
            display: flex;
            justify-content: space-between;
            align-items: center;

        }

        header h1 {
            margin: 0;
            color: #fff;
            animation: 2s ease-in-out 0s 1 slideInFromLeft;

        }

        .container {
            background-color: #fff;
            padding: 20px;
            margin-top: 20px;
            border: 1px solid #ddd;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        h1 {
            text-align: center;
            margin-bottom: 30px;
        }

        .card {
            margin-bottom: 30px;
        }

        .card-title {
            font-size: 24px;
            margin-bottom: 10px;
        }

        .card-subtitle {
            font-size: 16px;
            margin-bottom: 20px;
        }

        .card-img-top {
            max-width: 500px;
            height: auto;
            margin: 0 auto;
            align-items: center;
            width: 100%;
            max-height: 200px;
            height: 100%;
            object-fit: contain;
        }

        .list-group-item {
            font-size: 18px;
        }

        .btn {
            margin-right: 10px;
        }

        /* animation au card img */
        .card-img-top {
            animation: 2s ease-in-out 0s 1 slideInFromLeft;
        }

        @keyframes slideInFromLeft {
            0% {
                transform: translateX(-100%);
            }

            100% {
                transform: translateX(0);
            }
        }

        /*card animation */
        .card {
            animation: 2s ease-in-out 0s 1 slideInFromRight;
        }

        @keyframes slideInFromRight {
            0% {
                transform: translateX(100%);
            }

            100% {
                transform: translateX(0);
            }
        }
    </style>
</head>

<body>
    <header>
        <a href="index.php" class="btn btn-primary"><i class="fas fa-arrow-left"></i></a>
        <h1>Delegue viewer</h1>

    </header>
    <div class="container">
        <h1>Détails du délégué</h1>

        <?php
        if (isset($message)) {
            echo $message;
        } else {

            if (empty($delegue_zone_produit)) {
                if (!empty($idDelegue)){
                    $req = "SELECT * FROM delegue WHERE id_delegue = '$idDelegue'";
                    $res = $db->prepare($req);
                    $res->execute();
                    $delegue_zone_produit = $res->fetch(PDO::FETCH_ASSOC);
                    $delegue = $delegue_zone_produit;
                    echo "<div class='card mb-3'>
                        <div class='card-body'>
                        <h2 class='card-title'>$delegue[nom] $delegue[prenom]</h2>
                        <h5 class='card-subtitle mb-2 text-muted'>Matricule : $delegue[matDelegue]</h5>
                        <img class='card-img-top' src='../assets/images/delegue/$delegue[photo]' alt='Photo du délégué'>
                        <div class='mt-3'>
                            <a href='editDelegue.php?id=$idDelegue' class='btn btn-primary'>Modifier le délégué</a>
                            <a href='deleter.php?action=delegue&id=$idDelegue' class='btn btn-danger'>Supprimer le délégué</a>
                        </div>
                    </div>
                    </div>";
                }
                else{
                    echo " <a href='index.php' class='btn btn-primary'><i class='fas fa-arrow-left'></i></a><div class='alert alert-danger'>Aucun délégué trouvé.</div>";

                    echo ' <a href="index.php" class="btn btn-primary"><i class="fas fa-arrow-left"></i></a>';
                }
              
            } else {
                // Afficher les informations du délégué
                $delegue = $delegue_zone_produit[0];
                echo "<div class='card mb-3'>
                <div class='card-body'>
                <h2 class='card-title'>$delegue[nom] $delegue[prenom]</h2>
                <h5 class='card-subtitle mb-2 text-muted'>Matricule : $delegue[matDelegue]</h5>
                <img class='card-img-top' src='../assets/images/delegue/$delegue[photo]' alt='Photo du délégué'>
                <h4 class='card-title mt-3'>Zone(s) : </h4>
                <ul class='list-group list-group-flush'>";
                foreach ($delegue_zone_produit as $row) {
                    echo "<li class='list-group-item'>$row[district]</li>";
                }
                echo "</ul>
                <div class='mt-3'>
                    <a href='editDelegue.php?id=$idDelegue' class='btn btn-primary'>Modifier le délégué</a>
                    <a href='deleter.php?action=delegue&id=$idDelegue' class='btn btn-danger'>Supprimer le délégué</a>
                </div>
            </div>
            </div>";

                // Afficher les produits associés
                echo "<h2>Produits associés</h2>";
                foreach ($delegue_zone_produit as $row) {
                    echo "<div class='card mb-3'>
                            <div class='card-body'>
                            <h4 class='card-title'>$row[nom_produit]</h4>
                            <img class='card-img-top' src='../assets/images/product/$row[photo_produit]' alt='Image du produit'>
                            <p class='card-text'>$row[description]</p>
                            </div>
                            </div>";
                }
            }
        }

        // Fermeture de la connexion à la base de données
        $conn = null;
        ?>
    </div>
    <!-- Liens JavaScript de Bootstrap  local node_modules-->
    <script src="../node_modules/jquery/dist/jquery.slim.min.js"></script>
    <script src="../node_modules/popper.js/dist/umd/popper.min.js"></script>
    <script src="../node_modules/bootstrap/dist/js/bootstrap.min.js"></script>

</body>

</html>