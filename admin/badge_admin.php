<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();
if (!isset($_SESSION['adminWantToLogin'])) {
    header('Location: ../index.php');
    exit;
}
include_once '../includes/db.connect.php';
$req = $db->prepare("SELECT * FROM admin WHERE id_admin = '$_SESSION[id]'");
$req->execute();
$admin = $req->fetch(PDO::FETCH_ASSOC);
$nom = $admin['nom'];
$prenom = $admin['prenom'];
$email = $admin['email'];
$telephone = $admin['telephone'];
$fonction = $admin['fonction'];
//photo
$photo_ad = $admin['admin_photo'];
include_once '../includes/req_index.php';

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <link rel="icon" href="../assets/images/logo/logo.png" size="42x42">
    <title>Profile - Brand</title>
    <link rel="stylesheet" href="../assets/admin/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i&amp;display=swap">
    <link rel="stylesheet" href="../assets/admin/fonts/fontawesome-all.min.css">
    <style>
        .task {
            z-index: 99999 !important;
            position: absolute;
        }

        .sidebar-brand-icon img {
            background-color: white;
            width: 70px;
            height: 70px;
            border-radius: 50%;
            transition: 1.5s;
            animation-name: loading;
            animation-duration: 5s;
            animation-iteration-count: infinite;
            animation-direction: alternate;
            animation-play-state: running;
            animation-timing-function: ease-in-out;



        }

        .sidebar-brand-icon img:hover {
            background-color: rgba(255, 255, 255, 0.65);
            width: 70px;
            height: 70px;
            border-radius: 50%;
            box-shadow: 0 0 10px 10px rgba(0, 0, 0, 0.1);
            z-index: 999999;
            scale: 1.2;

        }

        @keyframes loading {
            0% {
                transform: scale(1);
                filter: hue-rotate(0deg);

            }

            100% {
                transform: scale(1.2);
                filter: hue-rotate(360deg);

            }

        }

        .text-yellow {
            color: yellow;
        }

        .text-magenta {
            color: #070245;
        }

        .text-purple {
            color: #e12cbd;
        }

        .hidden {
            display: none;
        }
        main {
            margin-top: 25px;
            margin-bottom: 25px;
        }

        .card {
            border-radius: 25px;
            animation: comeFromLeftAndRotate 1s;
            box-shadow: 0 0 10px 0 rgba(0, 0, 0, 0.2);
            margin-bottom: 25px;
            max-width: 800px;
            max-height: 400px;
            width: 100%;
            height: 100%;
            overflow-x: auto;

        }

        @keyframes comeFromLeftAndRotate {
            from {
                transform: translateX(-100%) rotate(-360deg);
            }

            to {
                transform: translateX(0) rotate(0);
            }
        }

        .card-img {
            border-radius: 25px 25px 0 0;
            width: 140px;
            height: 140px;
        }

    </style>
</head>

<body id="page-top">
    <div id="wrapper">
        <nav class="navbar navbar-dark align-items-start sidebar sidebar-dark  accordion bg-gradient-primary p-0">
            <div class="container-fluid d-flex flex-column p-0"><a class="navbar-brand d-flex justify-content-center align-items-center sidebar-brand m-0" href="#">
                    <div class="sidebar-brand-icon rounded-circle"><img src="../assets/images/logo/logo.png" alt=""></div>
                    <div class="sidebar-brand-text mx-3"><span>Consort</span></div>
                </a>
                <hr class="sidebar-divider my-0">
                <ul class="navbar-nav text-light" id="accordionSidebar">
                    <li class="nav-item"><a class="nav-link" href="index.php"><i class="fas fa-tachometer-alt"></i><span>Dashboard</span></a></li>
                    <li class="nav-item"><a class="nav-link" href="profile.php"><i class="fas
                    fa-user"></i><span>Profile</span></a></li>
                    <li class="nav-item"><a class="nav-link active" href="#"><i class="fas
                    fa-id-card-alt"></i><span>Badge</span></a></li>
                    <li class="nav-item dropdown no-arrow">
                        <div class="nav-item dropdown no-arrow"><a class="dropdown-toggle nav-link" aria-expanded="false" data-bs-toggle="dropdown" href="#"><span class=" d-lg-inline me-2"><i class="fas fa-table"></i>Tables<span></a>
                            <div class="dropdown-menu shadow dropdown-menu-end animated--grow-in task"><a class="dropdown-item" href="table.php?see=labo"><i class="fas fa-user fa-sm fa-fw me-2 text-gray-400"></i>&nbsp;Laboratoire</a><a class="dropdown-item" href="table.php?see=delegue"><i class="fas fa-cogs fa-sm fa-fw me-2 text-gray-400"></i>&nbsp;Délégués</a><a class="dropdown-item" href="table.php?see=zone"><i class=" fas fa-list fa-sm fa-fw me-2 text-gray-400"></i>&nbsp;Zone</a>
                                <a class="dropdown-item" href="table.php?see=gamme"><i class="fas fa-user fa-sm
                                fa-fw me-2 text-gray-400"></i>&nbsp;Gamme</a><a class="dropdown-item" href="table.php?see=product"><i class="fas fa-cogs fa-sm fa-fw me-2 text-gray-400"></i>&nbsp;Produit</a>

                            </div>
                        </div>
                    </li>
                    <li class="nav-item dropdown no-arrow">
                        <div class="nav-item dropdown no-arrow"><a class="dropdown-toggle nav-link" aria-expanded="false" data-bs-toggle="dropdown" href="#"><span class="d-lg-inline me-2"><i class="fas fa-tasks"></i> Tâches<span></a>
                            <div class="dropdown-menu shadow dropdown-menu-end animated--grow-in task"><a class="dropdown-item" href="creater.php?task=delegue"><i class="fas fa-user fa-sm fa-fw me-2 text-gray-400"></i>&nbsp;Créer Délégué</a><a class="dropdown-item" href="creater.php?task=labo"><i class="fas fa-cogs fa-sm fa-fw me-2 text-gray-400"></i>&nbsp;Créer laboratoire</a><a class="dropdown-item" href="creater.php?task=zone"><i class=" fas fa-list fa-sm fa-fw me-2 text-gray-400"></i>&nbsp;Créer Zone</a>
                                <a class="dropdown-item" href="creater.php?task=new_gamme"><i class="fas fa-user fa-sm
                                fa-fw me-2 text-gray-400"></i>&nbsp;Ajouter une gamme</a><a class="dropdown-item" href="creater.php?task=new_product"><i class="fas fa-cogs fa-sm fa-fw me-2 text-gray-400"></i>&nbsp;Nouveau produit</a><a class="dropdown-item" href="creater.php?task=affect"><i class=" fas fa-list fa-sm fa-fw me-2 text-gray-400"></i>&nbsp;Affectation</a>

                            </div>
                        </div>
                    </li>
                </ul>
                <div class="text-center d-none d-md-inline"><button class="btn rounded-circle border-0" id="sidebarToggle" type="button"></button></div>
            </div>
        </nav>
        <div class="d-flex flex-column" id="content-wrapper">
            <div id="content">
                <nav class="navbar navbar-light navbar-expand bg-white shadow mb-4 topbar static-top">
                    <div class="container-fluid"><button class="btn btn-link d-md-none rounded-circle me-3" id="sidebarToggleTop" type="button"><i class="fas fa-bars"></i></button>
                        <form class="d-none d-sm-inline-block me-auto ms-md-3 my-2 my-md-0 mw-100 navbar-search">
                            <div class="input-group"><input class="bg-light form-control border-0 small" type="text" placeholder="Search for ..."><button class="btn btn-primary py-0" type="button"><i class="fas fa-search"></i></button></div>
                        </form>
                        <ul class="navbar-nav flex-nowrap ms-auto">
                            <li class="nav-item dropdown d-sm-none no-arrow"><a class="dropdown-toggle nav-link" aria-expanded="false" data-bs-toggle="dropdown" href="#"><i class="fas fa-search"></i></a>
                                <div class="dropdown-menu dropdown-menu-end p-3 animated--grow-in" aria-labelledby="searchDropdown">
                                    <form class="me-auto navbar-search w-100">
                                        <div class="input-group"><input class="bg-light form-control border-0 small" type="text" placeholder="Search for ...">
                                            <div class="input-group-append"><button class="btn btn-primary py-0" type="button"><i class="fas fa-search"></i></button></div>
                                        </div>
                                    </form>
                                </div>
                            </li>
                            <li class="nav-item dropdown no-arrow mx-1">
                                <div class="nav-item dropdown no-arrow"><a class="dropdown-toggle nav-link" aria-expanded="false" data-bs-toggle="dropdown" href="#"><span class="badge bg-<?php echo $icons ?> badge-counter"><?php echo $nbr_news__ ?></span><i class="fas fa-bell fa-fw"></i></a>
                                    <div class="dropdown-menu dropdown-menu-end dropdown-list animated--grow-in">
                                        <h6 class="dropdown-header">Centre de nouvelles</h6><a class="dropdown-item d-flex align-items-center" href="#">
                                            <?php
                                            //afficher les nouvelles 
                                            if ($nbr_news > 0) {
                                                foreach ($news as $key => $value) {
                                                    echo  '<a class="dropdown-item d-flex align-items-center" href="?news_v=' . $value["id_modification"] . '"><div class="me-3">
                                                <div class="bg-primary icon-circle"><i class="fas fa-file-alt text-white"></i></div>
                                            </div>
                                            <div><span class="small text-gray-500">' . $value["nom"] . '' . $value["date"] . '</span>
                                                <p>' . $value["modification"] . '!</p>
                                            </div>
                                        </a>';
                                                }
                                            }
                                            ?>
                                    </div>
                            </li>
                            <li class="nav-item dropdown no-arrow mx-1">
                                <div class="nav-item dropdown no-arrow"><a class="dropdown-toggle nav-link" aria-expanded="false" data-bs-toggle="dropdown" href="#"><span class="badge bg-success badge-counter">
                                            <?php
                                            //afficher le nombre de messages non lus
                                            if ($nbr_messages > 0) {
                                                echo $nbr_messages;
                                            } else {
                                                echo "0";
                                            }
                                            ?>

                                        </span><i class="fas fa-envelope fa-fw"></i></a>
                                    <div class="dropdown-menu dropdown-menu-end dropdown-list animated--grow-in">
                                        <h6 class="dropdown-header">chatBox</h6>
                                        <?php
                                        //afficher les messages non lus
                                        if (isset($messages) && $nbr_messages > 0) {
                                            foreach ($messages as $key => $value) {
                                                $temps = $value["date"];
                                                $h_format = duree_message($temps);
                                                echo '<a class="dropdown-item d-flex align-items-center" href="chatbox.php?chat=' . $value["id_delegue"] . '">
                                                    <div class="dropdown-list-image me-3">
                                                        <img class="rounded-circle" src="../assets/images/delegue/' . $value["photo"] . '">
                                                        <div class="bg-danger status-indicator"></div>
                                                    </div>
                                                    <div class="fw-bold">
                                                        <div class="text-truncate">
                                                            <span><i class="bi bi-eye-fill me-1"></i>' . $value["message"] . '</span>
                                                        </div>
                                                        <p class="small text-gray-500 mb-0">' . $value["nom"] . ' ' . $value["prenom"] . ' - ' . $h_format . '</p>
                                                    </div>
                                                </a>';
                                            }
                                        }

                                        ?>
                                        <marquee behavior="scroll" direction="left" width="500">
                                            Cliquez sur un message pour repondre ou supprimé !
                                        </marquee>

                                    </div>
                                </div>
                                <div class="shadow dropdown-list dropdown-menu dropdown-menu-end" aria-labelledby="alertsDropdown"></div>
                            </li>
                            <?php
                            //afficher les messages non lus
                            if (isset($nbr_delegue)) { ?>
                                <li class="nav-item dropdown no-arrow mx-1">
                                    <div class="nav-item dropdown no-arrow"><a class="dropdown-toggle nav-link" aria-expanded="false" data-bs-toggle="dropdown" href="#"><span class="badge bg-danger badge-counter">
                                                <?php
                                                //afficher le nombre de messages non lus
                                                if ($nbr_delegue > 0) {
                                                    echo $nbr_delegue;
                                                } else {
                                                    echo "0";
                                                }
                                                ?>

                                            </span><i class="fas fa-user fa-fw"></i></a>
                                        <div class="dropdown-menu dropdown-menu-end dropdown-list animated--grow-in">
                                            <h6 class="dropdown-header">Ecrire à un délégué</h6>
                                        <?php
                                        //afficher les messages non lus
                                        if (isset($delegues)) {
                                            foreach ($delegues as $key => $value) {

                                                echo '<a class="dropdown-item d-flex align-items-center" href="chatbox.php?chat=' . $value["id_delegue"] . '">
                                                    <div class="dropdown-list-image me-3">
                                                        <img class="rounded-circle" src="../assets/images/delegue/' . $value["photo"] . '">
                                                        <div class="bg-danger status-indicator"></div>
                                                    </div>
                                                    <div class="fw-bold">
                                                        <div class="text-truncate">
                                                            <span><i class="bi bi-eye-fill me-1"></i>' . $value["badge"] . '</span>
                                                        </div>
                                                        <p class="small text-gray-500 mb-0">' . $value["nom"] . ' ' . $value["prenom"] . '</p>
                                                    </div>
                                                </a>';
                                            }
                                        }
                                    }
                                        ?>


                                        </div>
                                    </div>
                                    <div class="shadow dropdown-list dropdown-menu dropdown-menu-end" aria-labelledby="alertsDropdown"></div>
                                </li>

                                <div class="d-none d-sm-block topbar-divider"></div>
                                <li class="nav-item dropdown no-arrow">
                                    <div class="nav-item dropdown no-arrow"><a class="dropdown-toggle nav-link" aria-expanded="false" data-bs-toggle="dropdown" href="#"><span class="d-none d-lg-inline me-2 text-gray-600 small"><?php if (isset($admin["nom"])) echo $admin["nom"] . " " . $admin["prenom"]; ?></span><img class="border rounded-circle img-profile" src="../assets/images/admin/<?php echo $admin['admin_photo'] ?>"></a>
                                        <div class="dropdown-menu shadow dropdown-menu-end animated--grow-in"><a class="dropdown-item" href="#"><i class="fas fa-user fa-sm fa-fw me-2 text-gray-400"></i>&nbsp;Profile</a>
                                            <div class="dropdown-divider"></div><a class="dropdown-item" id="logout" href="#"><i class="fas fa-sign-out-alt fa-sm fa-fw me-2 text-gray-400"></i>&nbsp;Logout</a>
                                        </div>
                                    </div>
                                </li>
                        </ul>
                    </div>
                </nav>
                <main class="col-md-9 ms-sm-1  col-lg-10 px-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h2>Votre badge</h2>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4 card-img d-flex justify-content-center">
                                    <img src="../assets/images/admin/<?php echo $admin["admin_photo"] ?>" alt="profile"
                                         class="img-profile img-thumbnail">
                                </div>
                                <div class="col-md-8">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h4>Nom</h4>
                                            <p><?php echo $admin["nom"]; ?></p>
                                        </div>
                                        <div class="col-md-6">
                                            <h4>Prénom</h4>
                                            <p><?php echo $admin["prenom"]; ?></p>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h4>Adresse</h4>
                                            <p><?php echo $admin["adresse"]; ?></p>
                                        </div>
                                        <div class="col-md-6">
                                            <h4>Numéro de téléphone</h4>
                                            <p><?php echo $admin["telephone"]; ?></p>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h4>Email</h4>
                                            <p><?php echo $admin["email"]; ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center">
                        <a href="update_delegue.php" class="btn btn-success w-75">Modifier</a>
                    </div>
                </main>
            </div>
            <footer class="bg-white sticky-footer">
                <div class="container my-auto">
                    <div class="text-center my-auto copyright"><span id="typed"></span></div>
                </div>
            </footer>
        </div><a class="border rounded d-inline scroll-to-top" href="#page-top"><i class="fas fa-angle-up"></i></a>
    </div>
    <script src="../assets/admin/bootstrap/js/bootstrap.min.js"></script>
    <script src="../assets/admin/js/bs-init.js"></script>
    <script src="../assets/admin/js/theme.js"></script>
    <!-- online typed js-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/typed.js/2.0.11/typed.min.js"></script>
    <script src="../assets/js/typed.js"></script>
    <script src="../assets/js/logout.js"></script>

</body>

</html>