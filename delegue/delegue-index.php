<?php
session_start();
if (!isset($_SESSION['delegueWantToLogin'])) {
    header("Location: ../index.php");
    exit;
}
$_SESSION["chat_delegue"] = true;
include_once '../includes/db.connect.php';
try {
    $req = "SELECT * FROM delegue WHERE id_delegue = '$_SESSION[id]'";
    $res = $db->prepare($req);
    $res->execute();
    $user_datas = $res->fetch(PDO::FETCH_ASSOC);
    //verifier si l'utilisateur a une photo de profil
    if ($user_datas['photo'] == "no_file.png") {
        $display_change_option = true;
    }
    //Montrer que le delegue est connecté en changeant deconnecté en connecté dans la table delegue
    $req = "UPDATE delegue SET badge = 'connecté' WHERE id_delegue = '$_SESSION[id]'";
    $res = $db->prepare($req);
    $res->execute();
    //recuperer les produits de la table produit et les zones de la table zone dont le delegue est responsable par la table delegue_zone_produit
    $req = "SELECT * FROM produit, zone, delegue_zone_produit WHERE delegue_zone_produit.id_delegue = '$_SESSION[id]' AND delegue_zone_produit.id_produit = produit.id_produit AND delegue_zone_produit.id_zone = zone.id_zone";
    $res = $db->prepare($req);
    $res->execute();
    $produit_zone = $res->fetchAll(PDO::FETCH_ASSOC);

    //selectionner tous les messages non-lus
    $req = "SELECT * FROM message WHERE vu_admin = 1  AND vu_delegue = 0 AND id_delegue = '$_SESSION[id]' ORDER BY date ASC";
    $res = $db->prepare($req);
    $res->execute();
    $non_lu = $res->fetchAll(PDO::FETCH_ASSOC);
    $total_non_lu = count($non_lu);
    $color = "";
    if ($total_non_lu > 0) {
        $color = "red";
    }
} catch (PDOException $e) {
    echo 'Une erreur est suvenue lors de la requette';
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Home - Delegue - Page</title>
    <link rel="stylesheet" href="../assets/delegue/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat:400,700&amp;display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic&amp;display=swap">
    <link rel="stylesheet" href="../assets/delegue/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="../assets/delegue/css/aos.min.css">
    <link rel="stylesheet" href="../assets/delegue/css/animate.min.css">

    <style>
        img.images {
            height: 100% !important;
            object-fit: cover !important;
            width: 100% !important;

        }

        img.images:hover {
            scale: 1.1;
            transform: matrix(5, 33);
            transition: 0.5s;
        }

        .col-md-6 {
            max-height: 400px !important;
            height: 100% !important;
            object-fit: contain !important;
            max-width: 400px !important;
            width: 100% !important;
        }

        .logo {
            background-color: white !important;
            border-radius: 50%;
        }

        .profile {
            object-fit: cover !important;
        }




        .whatsapp-icon {
            position: relative;
        }

        .whatsapp-icon .counter {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 12px;
            font-weight: bold;
            color: white;
            background-color: red;
            padding: 2px 5px;
            border-radius: 50%;
        }

        .fa-whatsapp {
            font-size: 35px !important;
        }

        .zone:hover {
            background-color: #0b5ed7 !important;
            transition: 0.8s;
            cursor: pointer;


        }
    </style>
</head>

<body id="page-top" data-bs-spy="scroll" data-bs-target="#mainNav" data-bs-offset="72">
    <nav class="navbar navbar-light navbar-expand-lg fixed-top bg-secondary rubberBand animated text-uppercase" id="mainNav">
        <div class="container"><a class="navbar-brand" href="#page-top"><img class="logo" src="../assets/images/logo/logo.png" width="140" height="100" alt="logo de l'entreprise"></a><button data-bs-toggle="collapse" data-bs-target="#navbarResponsive" class="navbar-toggler text-white bg-primary wobble animated navbar-toggler-right text-uppercase rounded" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation"><i class="fa fa-bars"></i></button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item mx-0 mx-lg-1"><a class="nav-link py-3 px-0 px-lg-3 rounded" href="#portfolio">Centre</a></li>
                    <li class="nav-item mx-0 mx-lg-1"><a class="nav-link py-3 px-0 px-lg-3 rounded" href="#about">Zone</a></li>
                    <li class="nav-item mx-0 mx-lg-1 whatsapp-icon"><a class="nav-link py-3 px-0 px-lg-3 rounded" href="chatBox.php"><i class="fa fa-whatsapp fa-fw"></i>
                            <span class="counter"><?php echo $total_non_lu; ?></span>
                        </a></li>
                    <li class="nav-item mx-0 mx-lg-1"><a class="nav-link py-3 px-0 px-lg-3 rounded" href="badge.php">Badge</a></li>

                </ul>
                <ul class="navbar-nav ms-auto">

                    <li class="nav-item mx-0 mx-lg-1"><a class="nav-link py-3 px-0 px-lg-3 rounded" href="#" onclick="deconnect()"><i class="fas fa-logout fa-fw"></i>Déconnexion</a></li>
                </ul>
            </div>

        </div>
    </nav>
    <header class="text-center text-white bg-primary masthead">
        <div class="container"><img class="img-fluid d-block mx-auto mb-5 rounded-circle profile" data-aos="fade-up" data-aos-duration="500" data-aos-offset="25px" data-aos-delay="200" src="../assets/images/delegue/<?php echo  $user_datas["photo"]; ?>" width="160" height="160">
            <!-- bouton pour permettre de changer de photo de profile du délégué -->
            <?php
            //afficher l'option de changer de photo de profile que si le delegue est connecté et que la photo de profile est celle par defaut
            if ($display_change_option) {
                echo '<a class="btn btn-info btn-xl text-uppercase" role="button" href="#portfolio-modal-' . $user_datas["id_delegue"] . '" data-bs-toggle="modal">Changer de photo de profile</a>';
            }
            ?>
            <h1 class="flash animated"><?php
                                        echo $user_datas["nom"] . " " . $user_datas["prenom"];
                                        ?></h1>
            <hr class="shake animated star-light">
            <h2 class="font-weight-light mb-0"><?php
                                                echo "Fonction actuelle : " . $user_datas["fonction"];
                                                ?>
            </h2>
        </div>
    </header>
    <section id="portfolio" class="portfolio">
        <div class="container">
            <h2 class="text-uppercase text-center text-secondary">Produits dont vous êtes en charge</h2>
            <hr class="star-dark mb-5">
            <?php
            if (isset($produit_zone) && !empty($produit_zone)) {
                echo '<div class="row">';
                foreach ($produit_zone as $key => $value) {
                    echo '
                <div class="col-md-6 col-lg-4"><a class="d-block mx-auto portfolio-item" href="#portfolio-modal-' . $value["id_produit"]+5 . '" data-bs-toggle="modal">
                        <div class="d-flex portfolio-item-caption position-absolute h-100 w-100">
                            <div class="text-center text-white my-auto portfolio-item-caption-content w-100"><i class="fa fa-search-plus fa-3x"></i></div>
                        </div>
                        <img class="img-fluid images" width="400" height="400" src="../assets/images/product/' . $value["photo_produit"] . '">
                    </a>
                </div>
                ';
                }
                echo "</div>";
            } else {
                echo ' <div class="alert alert-warning">Vous n\'avez pas de charge attribuer pour l\'instant</div>';
                echo '<a href="#contact" class="alert alert-info">Faire une demande d\'affectation</a>';
            }
            ?>
    </section>
    <section class="text-white bg-primary mb-0" id="about">
        <div class="container">
            <h2 class="text-uppercase text-center text-white">Zone dans lequelle vous êtes affecté</h2>
            <hr class="star-light mb-5">
            <div class="row">
                <?php
                if (isset($produit_zone) && !empty($produit_zone)) {
                    echo '<div class="row">';
                    foreach ($produit_zone as $key => $value) {
                        echo '
                    <div class="col-lg-4 ms-auto">
                    <div class="alert alert-info bg-dark text-white zone">
                        <p class="lead ">Zone de : ' . $value['district'] . '</p>
                        <p class="lead">Produit : ' . $value['nom_produit'] . '</p>
                    </div>
                </div>
                ';
                    }
                    echo "</div>";
                } ?>
            </div>
    </section>
    <footer class="text-center footer">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-5 mb-lg-0">
                    <h4 class="text-uppercase mb-4">Contact</h4>
                    <p><?php
                        echo $user_datas["adresse"];
                        ?><br><?php
                                echo $user_datas["telephone"];
                                ?></p>
                </div>
                <div class="col-md-4 mb-5 mb-lg-0">
                    <h4 class="text-uppercase">Liens sociaux</h4>
                    <ul class="list-inline">
                        <li class="list-inline-item"><a class="btn btn-outline-light text-center btn-social rounded-circle" role="button" href="#"><i class="fa fa-facebook fa-fw"></i></a></li>
                        <li class="list-inline-item"><a class="btn btn-outline-light text-center btn-social rounded-circle" role="button" href="#"><i class="fa fa-google-plus fa-fw"></i></a></li>
                        <li class="list-inline-item"><a class="btn btn-outline-light text-center btn-social rounded-circle" role="button" href="#"><i class="fa fa-twitter fa-fw"></i></a></li>
                        <li class="list-inline-item"><a class="btn btn-outline-light text-center btn-social rounded-circle" role="button" href="#"><i class="fa fa-dribbble fa-fw"></i></a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h4 class="text-uppercase mb-4">Conosrt</h4>
                    <p class="lead mb-0"><span>Page spéciale aux délégués.&nbsp;</span></p>
                </div>
            </div>
        </div>
    </footer>
    <div class="text-center text-white copyright py-4">
        <div class="container"><small>Copyright ©&nbsp;Consort 2023</small></div>
    </div>
    <div class="d-lg-none scroll-to-top position-fixed rounded"><a class="text-center d-block rounded text-white" href="#page-top"><i class="fa fa-chevron-up"></i></a></div>

    <?php

    echo '<div class="row">';
    foreach ($produit_zone as $key => $value) {
        echo '
                        <div class="modal text-center" role="dialog" tabindex="-1" id="portfolio-modal-' . $value["id_produit"]+5 . '">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header"><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div>
                                    <div class="modal-body">
                                        <div class="container text-center">
                                            <div class="row">
                                                <div class="col-lg-8 mx-auto">
                                                    <h2 class="text-uppercase text-secondary mb-0">Nom: ' . $value["nom_produit"] . '</h2>
                                                    <hr class="star-dark mb-5"><img class="img-fluid mb-5" src="../assets/images/product/' . $value["photo_produit"] . '">
                                                    <p class="mb-5">Description: ' . $value["description"] . '</p>
                                                </div>
                                                <div class="col-lg-8 mx-auto">
                                                    <h2 class="text-uppercase text-secondary mb-0">Zone</h2>
                                                    <hr class="star-dark mb-5">
                                                    <p class="mb-5">Zone  ' . $value["district"] . '</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer pb-5"><a class="btn btn-primary btn-lg mx-auto rounded-pill portfolio-modal-dismiss" role="button" data-bs-dismiss="modal"><i class="fa fa-close"></i>&nbsp;Fermer le produit</a></div>
                                </div>
                            </div>
                            </div>
                            </div>';
    }
    if ($display_change_option) {
        echo '     <div class="modal text-center" role="dialog" tabindex="-1" id="portfolio-modal-' . $user_datas["id_delegue"] . '">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header"><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div>
                                    <div class="modal-body">
                                        <div class="container text-center">
                                             <div class="row">
                                                <div class="col-lg-8 mx-auto">
                                                    <form id="contactForm" name="sentMessage" action="editProfile.php" method="post" enctype="multipart/form-data">
                                                    <label class="form-label">Entrez la nouvelle photo</label>
                                                        <div class="control-group">
                                                        <div class="mb-0 form-floating controls pb-2"><input class="form-control" type="file" id="photo" required="" name="photo"><small class="form-text text-danger help-block"></small>
                                                        </div>
                                                    </div>
                                                        <div>
                                                        <button class="btn btn-primary btn-xl" id="sendMessageButton" type="submit" name="submit">Send</button>
                                                        </div>
                                                    </form>
                                                </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer pb-5"><a class="btn btn-primary btn-lg mx-auto rounded-pill portfolio-modal-dismiss" role="button" data-bs-dismiss="modal"><i class="fa fa-close"></i>&nbsp;Annuler</a></div>
                                </div>
                            </div>
                            </div>';
    }



    ?>

    <script src="../assets/delegue/bootstrap/js/bootstrap.min.js"></script>
    <script src="../assets/delegue/js/aos.min.js"></script>
    <script src="../assets/delegue/js/bs-init.js"></script>
    <script>
        function deconnect() {
            a = confirm("voulez-vous vraiment vous déconnecter?")
            if (a == true) {
                window.location.href = "deconnect.php";
            }

        }
    </script>
</body>

</html>