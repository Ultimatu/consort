<?php
session_start();
$_SESSION["passed_by_form"] = true;
//verifier s'il est passer par la page d'acceuil
include_once 'includes/index-frag/login-err.php';
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Page de connexion">
    <meta name="keywords" content="login, connexion, page de connexion">
    <meta name="author" content="Tonde Souleymane">
    <meta name="robots" content="login, follow">
    <meta name="googlebot" content="login, follow">

    <link rel="icon" href="assets/images/logo/logo.png" size="42x42">

    <title>Login page</title>
    <link rel="stylesheet" href="./node_modules/bootstrap/dist/css/bootstrap.min.css">
    <style>
        div.bg-login-image {
            background-size: contain;
            background-repeat: no-repeat;

        }

        body {
            background-color: blue;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-9 col-lg-12 col-xl-10">
                <div class="card shadow-lg o-hidden border-0 my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-flex">
                                <div class="flex-grow-1 bg-login-image" style="background-image: url(&quot;assets/animation/121421-login.gif&quot;);"></div>
                            </div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h4 class="text-dark mb-4">Bienvenue cher <?php if (isset($name)) echo $name ?> !</h4>
                                    </div>
                                    <?php
                                    //afficher les erreurs
                                    if (isset($error) && !empty($error)) {
                                        echo "<div class='alert alert-danger' role='alert'>
                                        $error";
                                        echo "</div>";
                                    }
                                    ?>
                                    <form class="user" method="post" action="verif.php">
                                        <div class="mb-3"><input class="form-control form-control-user" type="email" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Entrez Votre Address Email..." name="email"></div>
                                        <div class="mb-3"><input class="form-control form-control-user" type="password" id="exampleInputPassword" placeholder="Entrez votre <?php if (isset($placeholder)) echo $placeholder ?>" name="<?php if (isset($name_word)) echo $name_word ?>"></div>
                                        <div class="mb-3">
                                            <div class="custom-control custom-checkbox small">
                                                <div class="form-check"><input class="form-check-input custom-control-input" type="checkbox" id="formCheck-1"><label class="form-check-label custom-control-label" for="formCheck-1">Remember Me</label></div>
                                            </div>
                                        </div><button class="btn btn-primary d-block btn-user w-100" type="submit" name="<?php if (isset($submit)) echo  $submit ?>">Login</button>
                                        <hr>
                                    </form>
                                   <?php 
                                   if ($_GET["login"] == "admin"){
                                    echo ' <div class="text-center"><a class="small" href="./admin/password.forgot.php?admin=true">Forgot Password?</a></div>';
                                   }
                                    if ($_GET["login"] == "delegue") {
                                        echo ' <div class="text-center"><a class="small" href="./ask-for-account.php?delegue=true">Demander l\'ouverture d\'un compte?</a></div>';
                                    }
                                   
                                   ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap js -->
    <script src="./node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- jQuery -->
    <script src="./node_modules/jquery/dist/jquery.min.js"></script>
    <!-- Popper.js -->
    <script src="./node_modules/@popperjs/core/dist/umd/popper.min.js"></script>
</body>

</html>