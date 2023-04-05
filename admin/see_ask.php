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
include '../includes/db.connect.php';
if (isset($_GET["action"])  && isset($_GET["id"])){
    $action = $_GET["action"];
    $id = $_GET["id"];
    if ($action == "delete"){
        $req = "DELETE  FROM demande_delegue WHERE id_demande = '$id'";
        $res = $db->prepare($req);
        $res->execute();
    }
    else if($action == "see"){
        $req = "UPDATE  demande_delegue SET status = 'traite' WHERE id_demande = '$id'";
        $res = $db->prepare($req);
        $res->execute();
    }
} 

// Requête pour récupérer les données du délégué et les produits associés
$req = "SELECT * FROM demande_delegue WHERE status = 'en attente'";
$res = $db->prepare($req);
$res->execute();
$demande_deleguue = $res->fetchAll(PDO::FETCH_ASSOC);

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


        .btn {
            margin-right: 10px;
        }

        /* animation au card img */

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
        <h1>Demandes viewer</h1>

    </header>
    <div class="container">
        <h1>Détails des demandes</h1>

        <?php
        if (isset($demande_deleguue) && !empty($demande_deleguue)){
            // Afficher les informations du délégué
            foreach ($demande_deleguue as $row) {
                echo "<div class='card mb-3'>
                <div class='card-body'>
                <h2 class='card-title'>$row[nom] $row[prenom]</h2>
                <h5 class='card-subtitle mb-2 text-muted'>Telephone : $row[telephone]</h5>
                <h5 class='card-subtitle mb-2 text-muted'>Email : $row[email]</h5>
                
                <p class='card-text mt-3'>$row[lettre] </p>
                <div class='mt-3'>
                    <a href='see_ask.php?id=$row[id_demande]&action=traited' class='btn btn-primary'>Marquer comme traiter</a>
                    <a href='see_ask.php?action=delete&id=$row[id_demande]' class='btn btn-danger'>Supprimer</a>
                </div> </div>
            </div>";
            }
        }
        else{
            echo "<div class='container align-items-center'>
            <p  class='alert alert-info'>Aucune demande en cours</p>
            <a href='index.php' class='btn btn-success'>Retour à l'accueil</a>
            </div>";
        }
        // Fermeture de la connexion à la base de données
        $db = null;
        ?>
    </div>
    <!-- Liens JavaScript de Bootstrap  local node_modules-->
    <script src="../node_modules/jquery/dist/jquery.slim.min.js"></script>
    <script src="../node_modules/popper.js/dist/umd/popper.min.js"></script>
    <script src="../node_modules/bootstrap/dist/js/bootstrap.min.js"></script>

</body>

</html>