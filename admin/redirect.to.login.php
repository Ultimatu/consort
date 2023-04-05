<?php
//Démarrer la session
session_start();
//Si la session n'existe pas
if (!isset($_SESSION['wantToLogin']) || empty($_SESSION['wantToLogin']) || $_SESSION['wantToLogin'] != true) {
    header("location: ../index.php?dhjgh=dire");
    exit();
}
//Si la session redirect existe
if (!isset($_SESSION['redirect']) || empty($_SESSION['redirect']) || $_SESSION['redirect'] != true) {
    header("location: ../index.php");
    exit();
}
?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Redirect five secondes</title>
    <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <style>
        body {
            background-color: #f5f5f5;
        }
        .container {
            margin: 100px auto;
            max-width: 500px;

        }

        .container:hover {
            box-shadow: 0 0 10px rgba(0,0,0,0.5);
            animation: each-border-hover-3d ;
        }
        @keyframes each-border-hover-3d {
            0% {
                transform: translateZ(0);
            }
            100% {
                transform: translateZ(10px);
            }
        }


        h1 {
            font-family: 'Roboto', sans-serif;
            font-weight: 500;
            font-size: 2.5rem;
            color: #212529;
        }
        p {
            font-family: 'Roboto', sans-serif;
            font-weight: 400;
            font-size: 1.5rem;
            color: #212529;
        }
        .spinner-border {
            width: 3rem;
            height: 3rem;
            margin-top: 50px;
        }
    </style>

</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="alert alert-success text-center" role="alert">
                    <i class="fas fa-check-circle fa-5x"></i>
                </div>
            </div>
            <div class="col-12">

                <h1>Vous allez être redirigé dans <span id="countdown">5</span> secondes</h1>
                <p id="display-after-five">Si vous n'êtes pas redirigé, cliquez <a href="../index.php">ici</a></p>
            </div>
            <div class="col-12 d-flex justify-content-center">
                <div class="spinner-border text-primary align-content-center align-items-center" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.getElementById("display-after-five").style.display = "none";
        setTimeout(function () {
            window.location.href = "../login.php?login=admin";
        }, 5300);
        let timeout = 5;
        const downloadTimer = setInterval(function () {
            if (timeout <= 0) {
                clearInterval(downloadTimer);
                document.getElementById("countdown").innerHTML = "Finished";
                document.getElementById("display-after-five").style.display = "block";
            } else {
                document.getElementById("countdown").innerHTML = timeout;
            }
            timeout -= 1;
        }, 1000);


    </script>
    <script src="../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../node_modules/jquery/dist/jquery.min.js"></script>


</body>
</html>
