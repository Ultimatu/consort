<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();
if (!isset($_SESSION['adminWantToLogin']) || !$_SESSION['adminWantToLogin'] || !isset($_SESSION['email'])) {
    header('Location: ../index.php');
    exit;
}


if (isset($_GET["see"]) && !empty($_GET["see"])) {
    switch ($_GET["see"]) {
        case "labo":

            $display_include = "../includes/table.fragment.labo.php";
            break;
        case "gamme":
            $display_include = "../includes/table.fragment.gamme.php";
            break;
        case "zone":
            $display_include = "../includes/table.fragment.zones.php";
            break;
        case "delegue":
            $display_include = "../includes/table.fragment.delegue.php";
            break;
        case "product":
            $display_include = "../includes/table.fragment.pro.php";
            break;
        default:
            $display_include = "../includes/table.fragment.labo.php";
            break;
    }
}
include_once '../includes/db.connect.php';
include_once '../connect.db.php';
include_once 'admin-prof.php';
if (isset($_POST["search"]) && !empty($_POST["search"]) && isset($_GET["onlyDel"]) && $_GET["onlyDel"] == "yes") {
    $search = $_POST["search"];
    $sql = "SELECT * FROM delegue WHERE nom LIKE '%$search%' OR prenom LIKE '%$search%' OR email LIKE '%$search%' OR telephone LIKE '%$search%' OR adresse LIKE '%$search%' OR badge LIKE '%$search%'";
    $res = $db->prepare($sql);
    $res->execute();
    if (!$res) {
        echo "Query failed: " . $db->errorInfo()[2];
        exit;
    }
    $delegue_req = $res->fetchAll(PDO::FETCH_ASSOC);
} else if (isset($db)) {
    $sql = "SELECT * FROM delegue WHERE date_depart IS NULL";
    $res = $db->prepare($sql);
    $res->execute();
    $delegue_req = $res->fetchAll(PDO::FETCH_ASSOC);
}
if (isset($_GET["S_All"]) && $_GET["S_All"] == "yes") {
    header('Location: table.php');
    exit;
}
include_once("../includes/req_index.php");

if (isset($_POST["search"]) && !empty($_POST["search"]) && isset($_GET["forProd"]) && $_GET["forProd"] == "yes") {
    $search = $_POST["search"];
    $req = "SELECT DISTINCT p.*, gm_p.* FROM produit p JOIN gamme_produit gm_p ON gm_p.id_gamme = p.id_produit WHERE p.nom_produit LIKE '%$search%' OR p.id_produit LIKE '%$search%' OR gm_p.categorie LIKE '%$search%' OR gm_p.id_gamme LIKE '%$search%' ORDER BY p.id_produit";

    $res = $conn->prepare($req);
    $res->execute();
    $products = $res->fetchAll(PDO::FETCH_ASSOC);
} else {
    $req = "SELECT `produit`.*, `gamme_produit`.* FROM `produit` LEFT JOIN `gamme_produit` ON `produit`.`id_gamme` = `gamme_produit`.`id_gamme` WHERE `produit`.`id_gamme` = `gamme_produit`.`id_gamme`; 
    ";
    $res = $conn->prepare($req);
    $res->execute();
    $products = $res->fetchAll(PDO::FETCH_ASSOC);
}
//selectionnez toutes les zones

if (isset($_POST["search"]) && !empty($_POST["search"]) && isset($_GET["forZones"]) && $_GET["forZones"] == "yes") {
    $search = $_POST["search"];
    $req = "SELECT * FROM zone WHERE district LIKE '%$search%' OR id_zone LIKE '%$search%' ORDER BY id_zone";
    $res = $conn->prepare($req);
    $res->execute();
    $zones = $res->fetchAll(PDO::FETCH_ASSOC);
} else {
    $req = "SELECT * FROM zone ORDER BY id_zone";
    $res = $conn->prepare($req);
    $res->execute();
    $zones_req = $res->fetchAll(PDO::FETCH_ASSOC);
}
//selectionnez tous les laboratoires
if (isset($_POST["search"]) && !empty($_POST["search"]) && isset($_GET["forLabo"]) && $_GET["forLabo"] == "yes") {
    $search = $_POST["search"];
    $req = "SELECT * FROM laboratoire WHERE nom LIKE '%$search%' OR id_laboratoire LIKE '%$search%' ORDER BY id_laboratoire";
    $res = $conn->prepare($req);
    $res->execute();
    $labo_req = $res->fetchAll(PDO::FETCH_ASSOC);
} else {
    $req = "SELECT * FROM laboratoire ORDER BY id_laboratoire";
    $res = $conn->prepare($req);
    $res->execute();
    $labo_req = $res->fetchAll(PDO::FETCH_ASSOC);
}
//selectionnez tous les gammes
if (isset($_POST["search"]) && !empty($_POST["search"]) && isset($_GET["forGamme"]) && $_GET["forGamme"] == "yes") {
    $search = $_POST["search"];
    $req = "SELECT gm.*, lab.* FROM gamme_produit gm JOIN laboratoire lab ON lab.id_laboratoire = gm.id_laboratoire WHERE gm.categorie LIKE '%$search%' OR gm.id_gamme LIKE '%$search%' OR lab.nom LIKE '%$search%'  OR lab.pays  OR lab.adresse LIKE '%$search%' LIKE '%$search%' OR lab.id_laboratoire LIKE '%$search%' ORDER BY gm.id_gamme";
    $res = $conn->prepare($req);
    $res->execute();
    $gamme_req = $res->fetchAll(PDO::FETCH_ASSOC);
} else {
    $req = "SELECT gm.*, lab.* FROM gamme_produit gm JOIN laboratoire lab ON lab.id_laboratoire = gm.id_laboratoire ORDER BY gm.id_gamme";
    $res = $conn->prepare($req);
    $res->execute();
    $gamme_req = $res->fetchAll(PDO::FETCH_ASSOC);
}
//fermer ou ouvrir le laboratoire selon l'action du Get
if (isset($_GET["action"]) && $_GET["action"] == "Ouvrir") {
    $id = $_GET["id"];
    echo "test";

    $req = "UPDATE laboratoire SET etat = 'Fonctionnel' WHERE id_laboratoire = '$id'";
    $res = $conn->prepare($req);
    if ($res->execute()) {
        header('Location: table.php?see=labo');
        exit;
    } else {
        echo "Query failed: " . $db->errorInfo()[2];
        exit;
    }
} else if (isset($_GET["action"]) && $_GET["action"] == "Fermer") {
    $id = $_GET["id"];
    $req = "UPDATE laboratoire SET etat = 'Fermer' WHERE id_laboratoire = '$id'";
    $res = $conn->prepare($req);
    if ($res->execute()) {
        header('Location: table.php?see=labo');
        exit;
    } else {
        echo "Query failed: " . $db->errorInfo()[2];
        exit;
    }
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Table - Dashboard</title>
    <link rel="stylesheet" href="../assets/admin/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i&amp;display=swap">
    <link rel="stylesheet" href="../assets/admin/fonts/fontawesome-all.min.css">
    <style>
        .task {
            z-index: 99999 !important;
            position: absolute;
        }

        .sidebar-brand-icon {
            margin-top: 25px;
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

        .text-upper {
            text-transform: uppercase;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            text-align: left;
            border: 1px solid;
            border-radius: 10px;
            overflow: hidden;
            cursor: pointer;
        }

        td:hover {
            border-bottom: 1px solid;
            color: #ff0066;

        }

        thead tr:hover,
        tfoot tr:hover {
            color: #ff0066;
            background-color: rgba(12, 12, 14, 0.8);
        }

        thead tr:hover th:hover,
        tfoot tr:hover td:hover {
            border-bottom: 1px solid #ff0066;
            border-right: 2px solid white;
        }

        tr {
            scale: 0.99;
        }

        tbody tr:hover {
            background-color: wheat;
            scale: 1;
            transition: 0.5s;
            color: whitesmoke;
        }

        tr:hover div.alert-danger:hover {
            color: white !important;
            background-color: rgba(42, 52, 98, 0.8) !important;
        }

        a.btn {
            text-decoration: none;
        }

        .modal1 {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.8);
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .modal1 img {
            max-width: 80%;
            max-height: 80%;
        }

        .gaper a {
            gap: 20px;
            margin: 5px auto;

        }

        .gaper a:hover {
            background-color: wheat !important;

        }

        #dataTable tbody tr {
            margin-bottom: 45px !important;
        }
    </style>
</head>

<body id="page-top">

    <div id="wrapper">
        <nav class="navbar navbar-dark align-items-start sidebar sidebar-dark accordion bg-gradient-primary p-0">
            <div class="container-fluid d-flex flex-column p-0"><a class="navbar-brand d-flex justify-content-center align-items-center sidebar-brand m-0" href="#">
                    <div class="sidebar-brand-icon rounded-circle"><img src="../assets/images/logo/logo.png" alt=""></div>
                    <div class="sidebar-brand-text mx-3"><span>Consort</span></div>
                </a>
                <hr class="sidebar-divider my-0">
                <ul class="navbar-nav text-light" id="accordionSidebar">
                    <li class="nav-item"><a class="nav-link" href="index.php"><i class="fas fa-tachometer-alt"></i><span>Dashboard</span></a>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="profile.php"><i class="fas fa-user"></i><span>Profile</span></a></li>
                    <li class="nav-item dropdown no-arrow">
                        <div class="nav-item dropdown no-arrow"><a class="dropdown-toggle nav-link active" aria-expanded="false" data-bs-toggle="dropdown" href="#"><span class=" d-lg-inline me-2"><i class="fas fa-table"></i>Tables<span></a>
                            <div class="dropdown-menu shadow dropdown-menu-end animated--grow-in task"><a class="dropdown-item" href="table.php?see=labo"><i class="fas fa-user fa-sm fa-fw me-2 text-gray-400"></i>&nbsp;Laboratoire</a><a class="dropdown-item" href="table.php?see=delegue"><i class="fas fa-cogs fa-sm fa-fw me-2 text-gray-400"></i>&nbsp;Délégués</a><a class="dropdown-item" href="table.php?see=zone"><i class=" fas fa-list fa-sm fa-fw me-2 text-gray-400"></i>&nbsp;Zone</a>
                                <a class="dropdown-item" href="table.php?see=gamme"><i class="fas fa-user fa-sm
                                fa-fw me-2 text-gray-400"></i>&nbsp;Gamme</a><a class="dropdown-item" href="table.php?see=product"><i class="fas fa-cogs fa-sm fa-fw me-2 text-gray-400"></i>&nbsp;Produit</a>

                            </div>
                        </div>
                    </li>
                    <li class="nav-item dropdown no-arrow">
                        <div class="nav-item dropdown no-arrow"><a class="dropdown-toggle nav-link" aria-expanded="false" data-bs-toggle="dropdown" href="#"><span class=" d-lg-inline me-2"><i class="fas fa-tasks"></i> Tâches<span></a>
                            <div class="dropdown-menu shadow dropdown-menu-end animated--grow-in task"><a class="dropdown-item" href="creater.php?task=delegue"><i class="fas fa-user fa-sm fa-fw me-2 text-gray-400"></i>&nbsp;Créer Délégué</a><a class="dropdown-item" href="creater.php?task=labo"><i class="fas fa-cogs fa-sm fa-fw me-2 text-gray-400"></i>&nbsp;Créer
                                    laboratoire</a><a class="dropdown-item" href="creater.php?task=zone"><i class=" fas fa-list fa-sm fa-fw me-2 text-gray-400"></i>&nbsp;Créer Zone</a>
                                <a class="dropdown-item" href="creater.php?task=new_gamme"><i class="fas fa-user fa-sm
                                fa-fw me-2 text-gray-400"></i>&nbsp;Ajouter une gamme</a><a class="dropdown-item" href="creater.php?task=new_product"><i class="fas fa-cogs fa-sm fa-fw me-2 text-gray-400"></i>&nbsp;Nouveau produit</a><a class="dropdown-item" href="creater.php?task=affect"><i class=" fas fa-list fa-sm fa-fw me-2 text-gray-400"></i>&nbsp;Affectation</a>

                            </div>
                        </div>
                    </li>
                </ul>
                <div class="text-center d-none d-md-inline">
                    <button class="btn rounded-circle border-0" id="sidebarToggle" type="button"></button>
                </div>
            </div>
        </nav>
        <div class="d-flex flex-column" id="content-wrapper">
            <div id="content">
                <nav class="navbar navbar-light navbar-expand bg-white shadow mb-4 topbar static-top">
                    <div class="container-fluid">
                        <button class="btn btn-link d-md-none rounded-circle me-3" id="sidebarToggleTop" type="button"><i class="fas fa-bars"></i></button>
                        <form class="d-none d-sm-inline-block me-auto ms-md-3 my-2 my-md-0 mw-100 navbar-search">
                            <div class="input-group"><input class="bg-light form-control border-0 small" type="text" placeholder="Search for ...">
                                <button class="btn btn-primary py-0" type="button"><i class="fas fa-search"></i></button>
                            </div>
                        </form>
                        <ul class="navbar-nav flex-nowrap ms-auto">
                            <li class="nav-item dropdown d-sm-none no-arrow"><a class="dropdown-toggle nav-link" aria-expanded="false" data-bs-toggle="dropdown" href="#"><i class="fas fa-search"></i></a>
                                <div class="dropdown-menu dropdown-menu-end p-3 animated--grow-in" aria-labelledby="searchDropdown">
                                    <form class="me-auto navbar-search w-100">
                                        <div class="input-group"><input class="bg-light form-control border-0 small" type="text" placeholder="Search for ...">
                                            <div class="input-group-append">
                                                <button class="btn btn-primary py-0" type="button"><i class="fas fa-search"></i></button>
                                            </div>
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
                                                    echo '<div class="me-3">
                                                <div class="bg-primary icon-circle"><i class="fas fa-file-alt text-white"></i></div>
                                            </div>
                                            <div><span class="small text-gray-500">' . $value["date"] . '</span>
                                                <p>' . $value["modification"] . '!</p>
                                            </div>
                                        </a><a class="dropdown-item d-flex align-items-center" href="#">';
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
                                                            <span><i class="bi 	Paris	bi-eye-fill me-1"></i>' . $value["message"] . '</span>
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
                            if ($nbr_messages <= 0) { ?>
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
                                        if (isset($delegue_req)) {
                                            foreach ($delegue_req as $key => $value) {

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
                                    <div class="nav-item dropdown no-arrow"><a class="dropdown-toggle nav-link" aria-expanded="false" data-bs-toggle="dropdown" href="#"><span class="d-none d-lg-inline me-2 text-gray-600 small"><?php if (isset($nom) && isset($prenom)) echo $nom . " " . $prenom; ?></span><img class="border rounded-circle img-profile" src="../assets/images/admin/<?php echo $photo_ad ?>"></a>
                                        <div class="dropdown-menu shadow dropdown-menu-end animated--grow-in"><a class="dropdown-item" href="#"><i class="fas fa-user fa-sm fa-fw me-2 text-gray-400"></i>&nbsp;Profile</a><a class="dropdown-item" href="#"><i class="fas fa-cogs fa-sm fa-fw me-2 text-gray-400"></i>&nbsp;Settings</a><a class="dropdown-item" href="#"><i class="fas fa-list fa-sm fa-fw me-2 text-gray-400"></i>&nbsp;Activity
                                                log</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" id="logout" href="#"><i class="fas fa-sign-out-alt fa-sm fa-fw me-2 text-gray-400"></i>&nbsp;Logout</a>
                                        </div>
                                    </div>
                                </li>
                        </ul>
                    </div>
                </nav>
                <?php
                if (isset($display_include)) {
                    include($display_include);
                }
                ?>

            </div>
            <footer class="bg-white sticky-footer">
                <div class="container my-auto">
                    <div class="text-center my-auto copyright"><span>Copyright © Brand 2023</span></div>
                </div>
            </footer>
        </div>
        <a class="border rounded d-inline scroll-to-top" href="#page-top"><i class="fas fa-angle-up"></i></a>
    </div>
    <script src="../assets/admin/bootstrap/js/bootstrap.min.js"></script>
    <script src="../assets/admin/js/bs-init.js"></script>
    <script src="../assets/admin/js/theme.js"></script>
    <script src="../node_modules/jquery/dist/jquery.min.js"></script>
    <script src="../assets/js/logout.js"></script>
    <script src="../assets/js/showimage.js"></script>

</body>

</html>