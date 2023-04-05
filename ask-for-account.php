<?php
session_start();
$_SESSION["passed_by_form"] = true;
//verifier s'il est passer par la page d'acceuil
if (!isset($_SESSION["wantToLogin"]) || !($_SESSION["wantToLogin"])|| !($_SESSION["passed_by_form"])) {
    header("Location: index.php");
    exit;
}

include_once 'includes/index-frag/ask-for-account-req.php';
?>


<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
                                        <h4 class="text-dark mb-4">Formulez votre demande</h4>
                                    </div>
                                    <?php
                                    //afficher les erreurs
                                    if (isset($error) && !empty($error)) {
                                        echo "<div class='alert alert-danger' role='alert'>
                                        $error";
                                        echo "</div>";
                                    }
                                    if (isset($success) && !empty($success)) {
                                        echo "<div class='alert alert-success' role='alert'>
                                        $success";
                                        echo "</div>";
                                    }
                                    ?>
                                    <form class="user" method="post" action="ask-for-account.php">
                                        <div class="row mb-3">
                                            <div class="col-sm-6 mb-3 mb-sm-0"><input class="form-control form-control-user" type="text" id="exampleFirstName" placeholder="Nom" name="nom"></div>
                                            <div class="col-sm-6"><input class="form-control form-control-user" type="text" id="exampleLastName" placeholder="Prenom" name="prenom"></div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-sm-6 mb-3 mb-sm-0"><input class="form-control form-control-user" type="email" id="exampleFirstName" placeholder="Email" name="email"></div>
                                            <div class="col-sm-6 mb-3 mb-sm-0"><input class="form-control form-control-user" type="text" id="exampleTel" placeholder="Telephone" name="telephone"></div>
                                        </div>
                                        <div class="row mb-3">
                                            <textarea class="form-control form-control-user" name="lettre"
                                                      cols="20"
                                                      rows="5" id="exampleLettre" placeholder="Adresser un message..."></textarea>
                                        </div>

                                        <button class="btn btn-primary d-block btn-user w-100" type="submit" name="submit">Soumettre</button>
                                        <div class="d-flex justify-content-center mt-auto">
                                            <a href="index.php" class="btn btn-info mt-2 w-75">Retour a
                                                l'accueil</a>
                                        </div>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script src="./node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="./node_modules/jquery/dist/jquery.slim.min.js.js"></script>
    <script src="./node_modules/jquery/dist/jquery.min.js"></script>

    <!-- lien vers jquery min -->

    <!-- Popper.js -->
    <script src="./node_modules/@popperjs/core/dist/umd/popper.min.js"></script>
    <!-- Bootstrap js -->
</body>

</html>