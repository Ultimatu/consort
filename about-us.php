<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();
$_SESSION["wantToLogin"] = true;
$_SESSION["adminWantToLogin"] = false;
$_SESSION["wantToContact"] = true;
$_SESSION["delegueWantToLogin"] = false;
include_once "./includes/db.connect.php";
//se conneter a la base de donnee recuprer les donnees du labo
include_once 'includes/index-frag/about-us-req-frag.php';


?>


<!doctype html>
<html lang=fr>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="author" content="Tonde Souleymane">
    <meta name="robots" content="about-us, follow">
    <meta name="googlebot" content="about-us, follow">
    <title>About us</title>
    <link rel="stylesheet" href="./node_modules/bootstrap/dist/css/bootstrap.min.css">
    <!-- font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <!-- Google fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- custom css -->
    <link rel="stylesheet" href="assets/css/index-style.css">
    <style>
        .icons i {
            font-size: 2rem;
            color: #fa3d87;
            padding: 0 1rem;
        }
    </style>
</head>

<body>
    <!-- header -->
    <?php
    require_once 'includes/index-frag/about-us-frag.php';
    ?>


    <!-- jQuery -->
    <script src="./node_modules/jquery/dist/jquery.min.js"></script>
    <!-- Popper.js -->
    <script src="./node_modules/@popperjs/core/dist/umd/popper.min.js"></script>
    <!-- Bootstrap js -->
    <script src="./node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

    <!--Php pour verifier si go est definie et afficher le modal -->
    <script>
        $(document).ready(function() {
            // Vérifie si l'URL contient le paramètre 'error'
            if (window.location.href.indexOf("error") > -1) {
                // Affiche le modal
                $('#exampleModal').modal('show');
            }
            // Vérifie si l'URL contient le paramètre 'error'
            if (window.location.href.indexOf("success") > -1) {
                // Affiche le modal
                $('#exampleModal').modal('show');
            }
        });
    </script>
</body>

</html>