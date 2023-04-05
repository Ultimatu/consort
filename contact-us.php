<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();
$_SESSION["wantToLogin"] = true;
$_SESSION["wantToContact"] = true;
$_SESSION["adminWantToLogin"] = false;
$_SESSION["delegueWantToLogin"] = false;

include_once "./includes/db.connect.php";
include_once 'includes/index-frag/contact-us-req.php';
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Tonde Souleymane">
    <meta name="robots" content="contact-us, follow">
    <meta name="googlebot" content="contact-us, follow">
    <link rel="icon" href="assets/images/logo/logo.png" size="42x42">
    <title>Consort Contact us</title>
    <!-- bootstrap css -->
    <link rel="stylesheet" href="./node_modules/bootstrap/dist/css/bootstrap.min.css">
    <!-- font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <!-- Google fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- custom css -->
<link rel="stylesheet" href="./assets/css/index-style.css">
</head>

<body>
    <?php
    require_once 'includes/index-frag/contact-us-frag.php';
    ?>
    <!-- jQuery -->
    <script src="./node_modules/jquery/dist/jquery.min.js"></script>
    <!-- Popper.js -->
    <script src="./node_modules/@popperjs/core/dist/umd/popper-base.min.js"></script>
    <!-- Bootstrap js -->
    <script src="./node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
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