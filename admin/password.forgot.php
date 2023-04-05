<?php
//verifier la session WantToLogin
session_start();
if (!isset($_SESSION['wantToLogin']) || empty($_SESSION['wantToLogin']) || $_SESSION['wantToLogin'] != true) {
    header("location: ../index.php?gfgfg");
    exit();
}
//verifier session passed_by_form et get admin=true
if (!isset($_SESSION['passed_by_form']) || empty($_SESSION['passed_by_form']) || $_SESSION['passed_by_form'] != true || !isset($_GET['admin']) || empty($_GET['admin']) || $_GET['admin'] != 'true') {
    header("location: ../index.php?ffg");
    exit();
}
//declarer la session passed_by_recovery = true
$_SESSION['passed_by_recovery_form'] = true;
//verifier le formulaire à afficher en verifiant session passed_by_recovery = true
$recovery = false;
if (isset($_SESSION['auth_recovery']) && !empty($_SESSION['auth_recovery']) && $_SESSION['auth_recovery'] == true) {
    $recovery = true;
    $_SESSION['change_form'] = true;
}
//Gérer les erreurs
$error = false;
if (isset($_GET['error']) && !empty($_GET['error'])) {
    $error = $_GET['error'];
    switch ($error) {
        case 'emptyFields':
            $error = "Veuillez remplir tous les champs";
            break;
        case 'wrongDatas':
            $error = "Les données saisies ne correspondent pas à un administrateur";
            break;
        case 'notIdentical':
            $error = "Les deux mots de passe ne sont pas identiques";
            break;
        case 'weakPassword':
            $error = "Le mot de passe doit contenir au moins 8 caractères, une majuscule, une minuscule, un chiffre et un caractère spécial";
            break;
        default:
            $error = false;
            break;
    }
}



?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Passwod recovery consort admin</title>
    <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">
    <!-- icone online cndjs -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <!-- fontfamily -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <!-- css -->
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800;900&display=swap');

        body {
            background: #f5f5f5;
            font-family: 'Montserrat', sans-serif;
        }

        header {
            background: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        header:hover {
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);

        }

        .img-fluid {
            max-width: 140px;
            max-height: 140px;
            width: 100%;
            height: 100%;
            margin: 0 auto;
            display: flex;
            justify-content: center;
            align-items: center;
            transition: all 0.3s;
        }

        .img-fluid:hover {
            transform: scale(1.1);
        }



        .slideFromLeft {
            animation: slideFromLeft 1s;
        }

        @keyframes slideFromLeft {
            0% {
                transform: translateX(-100%);
            }

            100% {
                transform: translateX(0);
            }
        }

        .slideFromRight {
            animation: slideFromRight 1s;
        }

        @keyframes slideFromRight {
            0% {
                transform: translateX(100%);
            }

            100% {
                transform: translateX(0);
            }
        }

        .hover-3d {
            position: relative;
            overflow: hidden;
        }

        .hover-3d::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: #b49814;
            transform: translateX(-100%) skewX(-45deg);
            transform-origin: 0 0;
            transition: transform 0.3s;
        }

        .hover-3d:hover::before {
            transform: translateX(0) skewX(-45deg);
        }

        .form-classic {
            max-width: 500px;
            margin: 0 auto;
        }

        .form-shadow {
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        }

        .form-control-animation {
            animation: form-control-animation 1s;
        }

        /* input submit on display center */
        input[type="submit"] {
            display: flex;
            margin: 0 auto;
            justify-content: center;

        }

        @keyframes form-control-animation {
            0% {
                transform: translateY(100%);
            }

            100% {
                transform: translateY(0);
            }
        }

        .alert {
            animation: alert-animation 1s;
        }

        @keyframes alert-animation {
            0% {
                transform: translateY(-100%);
            }

            100% {
                transform: translateY(0);
            }
        }

        .error-no-display-after5 {
            animation: error-no-display-after5 5s;
        }

        @keyframes error-no-display-after5 {
            0% {
                opacity: 1;
            }

            80% {
                opacity: 1;
            }

            95% {
                opacity: 0.8;
            }

            100% {
                opacity: 0;
            }
        }
    </style>

</head>

<body>
    <!-- header avec bootstrap -->
    <header class="container-fluid bg-dark slideFromRight">
        <div class="row">
            <!-- logo -->
            <div class="col-12">
                <img src="../assets/images/logo/logo.png" alt="logo" class="img-fluid">
            </div>
            <div class="col-12">
                <h1 class="text-center text-white">Consort admin</h1>
            </div>
        </div>
    </header>
    <!-- Vérifier le email, et telephone avec un formulaire avant d'afficher le champ de changement -->
    <div class="container slideFromLeft">
        <div class="row">
            <div class="col-12">
                <h2 class="text-center">Veuillez entrer votre email et votre telephone</h2>
            </div>
        </div>
        <!-- error display -->
        <?php
        if (!empty($error) && isset($error)) {
            echo "<div class='alert alert-danger error-no-display-after5' role='alert'>
                $error
            </div>";
        }
        ?>
        <!-- formualire de verfication -->
        <?php if (!$recovery) { ?>
            <form action="pass.recovery.php" method="post" class="form-control form-classic form-shadow
            form-control-animation">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" class="form-control" placeholder="Email" aria-describedby="helpId">
                    <small id="helpId" class="text-muted">Veuillez entrer votre email</small>
                </div>
                <div class="form-group">
                    <label for="phone">Telephone</label>
                    <input type="text" name="phone" id="phone" class="form-control" placeholder="Telephone" aria-describedby="helpId">
                    <small id="helpId" class="text-muted">Veuillez entrer votre telephone</small>
                </div>
                <div class="d-flex justify-content-center">
                    <button type="submit" class="btn btn-primary hover-3d" name="verifDatas">Submit</button>
                </div>
            </form>
        <?php } ?>
        <!-- formulaire de changement de mot de passe -->
        <?php if ($recovery) { ?>
            <form action="pass.recovery.php" class="form-control" method="post">
                <div class="form-group">
                    <label for="newPass">Nouveau mot de passe</label>
                    <input type="password" name="newPass" id="newPass" class="form-control" placeholder="Nouveau mot de passe" aria-describedby="helpId">
                    <small id="helpId" class="text-muted">Veuillez entrer votre nouveau mot de passe</small>
                </div>
                <div class="form-group">
                    <label for="confirmPass">Confirmer le mot de passe</label>
                    <input type="password" name="confirmPass" id="confirmPass" class="form-control" placeholder="Confirmer le mot de passe" aria-describedby="helpId">
                    <small id="helpId" class="text-muted">Veuillez confirmer votre nouveau mot de passe</small>
                </div>
                <div class="d-flex justify-content-center">
                    <button type="submit" class="btn btn-primary" name="submitNew">Submit</button>
                </div>

            </form>
        <?php } ?>


    </div>

    <script src="../node_modules/jquery/dist/jquery.min.js"></script>
    <script src="../node_modules/bootstrap/dist/js/bootstrap.min.js"></script>

</body>

</html>