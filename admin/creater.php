<?php
// Path: admin/creater.php
session_start();
$_SESSION["passed_by_creater"] = "true";
if (!isset($_SESSION["adminWantToLogin"]) || !$_SESSION["adminWantToLogin"]) {
    header("Location: ../index.php");
    exit;
}
include_once '../includes/creater_def.php';

?>


<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Register - Brand</title>
    <link rel="stylesheet" href="../assets/admin/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i&amp;display=swap">
    <link rel="stylesheet" href="../assets/admin/fonts/fontawesome-all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <style>
        div.bg-login-image {
            background-size: contain;
            background-repeat: no-repeat;

        }

        form input {
            color: black !important;

        }

        form select {
            color: black !important;
            background-color: #0b5a4b;
        }

        input::first-letter {
            text-transform: capitalize !important;
        }

        .text-muted {
            color: rgba(131, 125, 125, 0.78) !important;
        }

        option.text-disabled {
            color: rgba(131, 125, 125, 0.78) !important;
        }

        a.btn-success {
            border: none;

        }

        .text-dark {
            color: black !important;
        }

        .text-dark-1 {
            color: black !important;
        }

        .empty {
            background-color: #f2f2f2;
            border-color: rgb(190, 175, 10);
        }

        .valid {
            background-color: #93f599;
        }

        .invalid {
            background-color: rgb(190, 175, 10);
        }
    </style>
</head>

<body class=" bg-gradient-primary">
    <div class="container">
        <div class="card shadow-lg o-hidden border-0 my-5">
            <div class="card-body p-0">
                <div class="row">
                    <div class="col-lg-5 d-none d-lg-flex">
                        <?php
                        if (isset($image)) {
                            echo ' <div class="flex-grow-1 bg-login-image" style="background-image: url(&quot;../assets/animation/' . $image . '&quot;);"></div>';
                        } else {
                            echo '<div class="flex-grow-1 bg-login-image" style="background-image: url(&quot;../assets/animation/create.gif&quot;);"></div>';
                        }
                        ?>

                    </div>
                    <div class="col-lg-7">
                        <div class="p-5">
                            <div class="text-center">
                                <h4 class="text-dark mb-4">Ajouter <?php echo $who ?> !</h4>
                            </div>
                            <?php
                            if (isset($msg))
                                echo $msg;
                            if (isset($formulaire))
                                echo $formulaire;
                            echo '<script>
                                  const inputs = document.querySelectorAll("input, select");
                                  inputs.forEach(function(input) {
                                    input.classList.add("empty");
                                    input.addEventListener("change", function() {
                                      if (input.value === "") {
                                        input.classList.add("empty");
                                        input.classList.remove("valid", "invalid");
                                      } else if (input.validity.valid) {
                                        input.classList.add("valid");
                                        input.classList.remove("empty", "invalid");
                                      } else {
                                        input.classList.add("invalid");
                                        input.classList.remove("empty", "valid");
                                      }
                                      if (input.type == "file"){
                                          //verifier le format de la photo
                                            var file = input.files[0];
                                            var fileType = file["type"];
                                            var ValidImageTypes = ["image/gif", "image/jpeg", "image/png"];
                                            if ($.inArray(fileType, ValidImageTypes) < 0) {
                                                input.classList.add("invalid");
                                                input.classList.remove("empty", "valid");
                                            }
                                            else{
                                                input.classList.add("valid");
                                                input.classList.remove("empty", "invalid");
                                            }
                                            //verifier la taille de la photo
                                            var img = new Image();
                                            img.src = window.URL.createObjectURL(file);
                                            img.onload = function() {
                                                var width = img.naturalWidth,
                                                    height = img.naturalHeight;
                                                window.URL.revokeObjectURL(img.src);
                                                if (width > 500 || height > 500){
                                                    input.classList.add("invalid");
                                                    input.classList.remove("empty", "valid");
                                                }
                                                else{
                                                    input.classList.add("valid");
                                                    input.classList.remove("empty", "invalid");
                                                }
                                            }
                                      }
                                    });
                                  });
                                </script>';
                            ?>
                            <hr class="divider">
                            <div class="text-center">
                                <a href="index.php" class="btn btn-success mt-2 text-white text-decoration-underline small">Taches finies!</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="../assets/admin/bootstrap/js/bootstrap.min.js"></script>
    <script src="../assets/admin/js/bs-init.js"></script>
    <script src="../assets/admin/js/theme.js"></script>
    <script src="../assets/js/matDelegue.func.js"></script>
</body>

</html>