<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();
//verifier s'il est passer par la page de connexion
if (!isset($_SESSION['adminWantToLogin']) || $_SESSION['adminWantToLogin'] != true || !isset($_SESSION["email"])) {
    header("Location: ../index.php");
    exit;
}
$_SESSION["chat"] = true;
include("../connect.db.php");
include_once '../includes/db.connect.php';
//Réccupérer les données de la base de données
$req = $db->prepare("SELECT * FROM admin WHERE email = :email");
$req->execute(array(
    "email" => $_SESSION["email"]
));
$result = $req->fetch(PDO::FETCH_ASSOC);
//verifier si l'email existe dans la base de donnee
if (!$result) {
    header("Location: ../index.php");
    exit;
}
//creer les variables de $nom, $prenom, $email, $password
$_SESSION["id"] = $result["id_admin"];
$nom = $result["nom"];
$prenom = $result["prenom"];
$email = $result["email"];
$badge = $result["badge"];
$admin_photo = $result["admin_photo"];
// requête SQL pour récupérer la taille de chaque table
$sql = "SELECT table_name AS `Table`, round(((data_length + index_length) / 1024 / 1024), 2) `Size (MB)` FROM information_schema.TABLES WHERE table_schema = '$dbname' ORDER BY (data_length + index_length) DESC;";

// exécution de la requête
$stmt = $db->query($sql);
// récupération des résultats sous forme de tableau associatif
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

// initialisation du tableau des données
$table_sizes = array();

// boucle sur les résultats pour remplir le tableau des données
foreach ($results as $row) {
    $table_sizes[$row['Table']] = $row['Size (MB)'];
}
include_once '../includes/req_index.php'
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta name="author" content="Tonde Souleymane">
    <meta name="robots" content="index, follow">
    <meta name="googlebot" content="index, follow">
    <meta name="description" content="Consort est une entreprise qui a pour but de promouvoir des médicaments pharmaceutiques">
    <meta name="keywords" content="Consort, médicaments, pharmaceutiques, promotion, santé, maladie, maladies,
traitement, traitements, laboratoire, laboratoires, pharmacie, pharmacies, pharmacien, pharmaciens, médecin, médecins, médecine, médecines, médecine générale, médecine générales, médecine spécialisée, médecine spécialisées, médecine spécialiste, médecine spécialistes, médecine spécialiste généraliste">
    <link rel="icon" href="../assets/images/logo/logo.png" size="42x42">

    <title>Tableau de Bord</title>
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
                    <li class="nav-item"><a class="nav-link active" href="index.php"><i class="fas fa-tachometer-alt"></i><span>Dashboard</span></a></li>
                    <li class="nav-item"><a class="nav-link" href="profile.php"><i class="fas fa-user"></i><span>Profile</span></a></li>
                    <li class="nav-item"><a class="nav-link" href="badge_admin.php"><i class="fas
                    fa-id-card"></i><span>Badge</span></a></li>
                    <li class="nav-item dropdown no-arrow">
                        <div class="nav-item dropdown no-arrow"><a class="dropdown-toggle nav-link" aria-expanded="false" data-bs-toggle="dropdown" href="#"><span class=" d-lg-inline me-2"><i class="fas fa-table"></i>Tables<span></a>
                            <div class="dropdown-menu shadow dropdown-menu-end animated--grow-in task"><a class="dropdown-item" href="table.php?see=labo"><i class="fas fa-user fa-sm fa-fw me-2 text-gray-400"></i>&nbsp;Laboratoire</a><a class="dropdown-item" href="table.php?see=delegue"><i class="fas fa-cogs fa-sm fa-fw me-2 text-gray-400"></i>&nbsp;Délégués</a><a class="dropdown-item" href="table.php?see=zone"><i class=" fas fa-list fa-sm fa-fw me-2 text-gray-400"></i>&nbsp;Zone</a>
                                <a class="dropdown-item" href="table.php?see=gamme"><i class="fas fa-user fa-sm
                                fa-fw me-2 text-gray-400"></i>&nbsp;Gamme</a><a class="dropdown-item" href="table.php?see=product"><i class="fas fa-cogs fa-sm fa-fw me-2 text-gray-400"></i>&nbsp;Produit</a>

                            </div>
                        </div>
                    </li>
                    <li class="nav-item dropdown no-arrow">
                        <div class="nav-item dropdown no-arrow"><a class="dropdown-toggle nav-link" aria-expanded="false" data-bs-toggle="dropdown" href="#"><span class=" d-lg-inline me-2"><i class="fas fa-tasks"></i> Tâches<span></a>
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
                                                if ($value["badge"] == "connecté") {
                                                    $icons = "success";
                                                } else {
                                                    $icons = "danger";
                                                }
                                                $temps = $value["date"];
                                                $h_format = duree_message($temps);
                                                echo '<a class="dropdown-item d-flex align-items-center" href="chatbox.php?chat=' . $value["id_delegue"] . '">
                                                    <div class="dropdown-list-image me-3">
                                                        <img class="rounded-circle" src="../admin/images/delegue/' . $value["photo"] . '">
                                                        <div class="bg-' . $icons . ' status-indicator"></div> </div><div class="fw-bold"><div class="text-truncate"><span><i class="bi bi-eye-fill me-1"></i>' . $value["message"] . '</span></div><p class="small text-gray-500 mb-0">' . $value["nom"] . ' ' . $value["prenom"] . ' - ' . $h_format . '</p>
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
                                    <div class="nav-item dropdown no-arrow"><a class="dropdown-toggle nav-link" aria-expanded="false" data-bs-toggle="dropdown" href="#"><span class="d-none d-lg-inline me-2 text-gray-600 small"><?php if (isset($nom) && isset($prenom)) echo $nom . " " . $prenom; ?></span><img class="border rounded-circle img-profile" src=" ../assets/images/admin/<?php echo $result['admin_photo'] ?>" width="32" height="32"></a>
                                        <div class="dropdown-menu shadow dropdown-menu-end animated--grow-in"><a class="dropdown-item" href="profile.php"><i class="fas fa-user fa-sm fa-fw me-2 text-gray-400"></i>&nbsp;Profile</a><a class="dropdown-item" href="#"><i class="fas fa-cogs fa-sm fa-fw me-2 text-gray-400"></i>&nbsp;Paramettre</a>
                                            <div class="dropdown-divider"></div><a class="dropdown-item" id="logout" href="#"><i class="fas fa-sign-out-alt fa-sm fa-fw me-2 text-gray-400"></i>&nbsp;Logout</a>
                                        </div>
                                    </div>
                                </li>
                        </ul>
                    </div>
                </nav>
                <div class="container-fluid cont-head" id="my-report">
                    <div class="d-sm-flex justify-content-between align-items-center mb-4">
                        <h3 class="text-dark mb-0">Tableau de bord</h3>
                        <a class="btn btn-primary btn-sm d-none d-sm-inline-block" role="button" href="#" id="btn-generate-report"><i class="fas fa-download fa-sm text-white-50"></i>&nbsp;Générer un rapport</a>

                    </div>
                    <div class="row">
                        <div class="col-md-6 col-xl-3 mb-4">
                            <div class="card shadow border-start-primary py-2">
                                <div class="card-body">
                                    <div class="row align-items-center no-gutters">
                                        <div class="col me-2">
                                            <div class="text-uppercase text-primary fw-bold text-xs mb-1"><span>Nombre de délégués en ligne</span></div>
                                            <div class="text-dark fw-bold h5 mb-0"><span>
                                                    <?php
                                                    echo $nbr_delegue_connecte . "/" . $nbr_delegue;
                                                    ?>
                                                </span></div>
                                        </div>
                                        <div class="col-auto"><i class="fas fa-user fa-2x text-gray-300"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-xl-3 mb-4">
                            <div class="card shadow border-start-success py-2">
                                <div class="card-body">
                                    <div class="row align-items-center no-gutters">
                                        <div class="col me-2">
                                            <div class="text-uppercase text-success fw-bold text-xs mb-1"><span>Laboratoire fonctionnel</span></div>
                                            <div class="text-dark fw-bold h5 mb-0"><span><?php echo $nbr_labo_fonctionnel . "/" . $nbr_labo; ?></span></div>
                                        </div>
                                        <div class="col-auto"><i class="fas fa-home fa-2x text-gray-300"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 col-xl-3 mb-4">
                            <div class="card shadow border-start-warning py-2">
                                <div class="card-body">
                                    <div class="row align-items-center no-gutters">
                                        <div class="col me-2">
                                            <div class="text-uppercase text-warning fw-bold text-xs mb-1"><span>Demande en attente</span></div>
                                            <div class="text-dark fw-bold h5 mb-0 d-flex justify-content-between"><span><?php echo  $nbr_demande; ?></span>
                                                <a href="see_ask.php" class="btn btn-info">voir</a>
                                            </div>
                                        </div>
                                        <div class="col-auto"><i class="fas fa-comments fa-2x text-gray-300"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-7 col-xl-8">
                            <div class="card shadow mb-4">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h6 class="text-primary fw-bold m-0">Tailles des tables </h6>
                                    <div class="dropdown no-arrow"><button class="btn btn-link btn-sm dropdown-toggle" aria-expanded="false" data-bs-toggle="dropdown" type="button"><i class="fas fa-ellipsis-v text-gray-400"></i></button>
                                        <div class="dropdown-menu shadow dropdown-menu-end animated--fade-in">
                                            <p class="text-center dropdown-header">Action :</p><a class="dropdown-item" href="#">&nbsp;Cacher</a><a class="dropdown-item" href="#">&nbsp;Télécharger</a>

                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="chart-area"><canvas data-bss-chart="{&quot;type&quot;:&quot;line&quot;,&quot;data&quot;:{&quot;labels&quot;:[&quot;Affectation&quot;,&quot;Message&quot;,&quot;Delegue&quot;,&quot;Produit&quot;,&quot;Gamme_produit&quot;,&quot;Zones&quot;,&quot;abonner&quot;,&quot;Laboratoire&quot;],&quot;datasets&quot;:[{&quot;label&quot;:&quot;taille en mega octet&quot;,&quot;fill&quot;:true,&quot;data&quot;:[&quot;<?php echo $table_sizes['delegue_zone_produit']; ?>&quot;,&quot;<?php echo $table_sizes['message']; ?>&quot;,&quot;<?php echo $table_sizes['delegue']; ?>&quot;,&quot;<?php echo $table_sizes['produit']; ?>&quot;,&quot;<?php echo $table_sizes['gamme_produit']; ?>&quot;,&quot;<?php echo $table_sizes['zone']; ?>&quot;,&quot;<?php echo $table_sizes['up_souscriber']; ?>&quot;,&quot;<?php echo $table_sizes['laboratoire']; ?>&quot;],&quot;backgroundColor&quot;:&quot;rgba(78, 115, 223, 0.05)&quot;,&quot;borderColor&quot;:&quot;rgba(78, 115, 223, 1)&quot;}]},&quot;options&quot;:{&quot;maintainAspectRatio&quot;:false,&quot;legend&quot;:{&quot;display&quot;:false,&quot;labels&quot;:{&quot;fontStyle&quot;:&quot;normal&quot;}},&quot;title&quot;:{&quot;fontStyle&quot;:&quot;normal&quot;},&quot;scales&quot;:{&quot;xAxes&quot;:[{&quot;gridLines&quot;:{&quot;color&quot;:&quot;rgb(234, 236, 244)&quot;,&quot;zeroLineColor&quot;:&quot;rgb(234, 236, 244)&quot;,&quot;drawBorder&quot;:false,&quot;drawTicks&quot;:false,&quot;borderDash&quot;:[&quot;2&quot;],&quot;zeroLineBorderDash&quot;:[&quot;2&quot;],&quot;drawOnChartArea&quot;:false},&quot;ticks&quot;:{&quot;fontColor&quot;:&quot;#858796&quot;,&quot;fontStyle&quot;:&quot;normal&quot;,&quot;padding&quot;:20}}],&quot;yAxes&quot;:[{&quot;gridLines&quot;:{&quot;color&quot;:&quot;rgb(234, 236, 244)&quot;,&quot;zeroLineColor&quot;:&quot;rgb(234, 236, 244)&quot;,&quot;drawBorder&quot;:false,&quot;drawTicks&quot;:false,&quot;borderDash&quot;:[&quot;2&quot;],&quot;zeroLineBorderDash&quot;:[&quot;2&quot;]},&quot;ticks&quot;:{&quot;fontColor&quot;:&quot;#858796&quot;,&quot;fontStyle&quot;:&quot;normal&quot;,&quot;padding&quot;:20}}]}}}"></canvas></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-5 col-xl-4">
                            <div class="card shadow mb-4">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h6 class="text-primary fw-bold m-0">Totals tables</h6>
                                    <div class="dropdown no-arrow"><button class="btn btn-link btn-sm dropdown-toggle" aria-expanded="false" data-bs-toggle="dropdown" type="button"><i class="fas fa-ellipsis-v text-gray-400"></i></button>
                                        <div class="dropdown-menu shadow dropdown-menu-end animated--fade-in">
                                            <p class="text-center dropdown-header">Actions:</p><a class="dropdown-item" href="#">&nbsp;Ne pas voir</a><a class="dropdown-item" href="#">&nbsp;Télécharger</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="chart-area"><canvas data-bss-chart="{
                                        &quot;type&quot;:&quot;doughnut&quot;,
                                        &quot;data&quot;:{&quot;labels&quot;:[&quot;Produits&quot;,&quot;Zone&quot;,&quot;Gamme&quot;,&quot;Labo&quot;,&quot;Délégué&quot;,&quot;Admin&quot;],&quot;datasets&quot;:[{&quot;label&quot;:&quot;&quot;,&quot;backgroundColor&quot;:[&quot;#e12cbd&quot;,&quot;#4e73df&quot;,&quot;#1cc88a&quot;,&quot;#36b9cc&quot;,&quot;#ffff09&quot;,&quot;#070245&quot;],&quot;borderColor&quot;:[&quot;#ffffff&quot;,&quot;#ffffff&quot;,&quot;#ffffff&quot;,&quot;#ffffff&quot;,&quot;#ffffff&quot;,&quot;#ffffff&quot;],&quot;data&quot;:[&quot;<?php echo $nbr_prod; ?>&quot;,&quot;<?php echo $nbr_gamme; ?>&quot;,&quot;<?php echo $nbr_zone; ?>&quot;,&quot;<?php echo $nbr_labo; ?>&quot;,&quot;<?php echo $nbr_delegue; ?>&quot;,&quot;<?php echo $nbr_admin; ?>&quot;]}]},&quot;options&quot;:{&quot;maintainAspectRatio&quot;:false,&quot;legend&quot;:{&quot;display&quot;:false,&quot;labels&quot;:{&quot;fontStyle&quot;:&quot;normal&quot;}},&quot;title&quot;:{&quot;fontStyle&quot;:&quot;normal&quot;}}}"></canvas></div>
                                    <div class="text-center small mt-4"><span class="me-2"><i class="fas fa-circle text-purple"></i>&nbsp;Produits</span><span class="me-2"><i class="fas fa-circle text-primary"></i>&nbsp;Zone</span><span class="me-2"><i class="fas fa-circle text-success"></i>&nbsp;Gamme</span><span class="me-2"><i class="fas fa-circle text-info"></i>&nbsp;Labo</span><span class="me-2"><i class="fas fa-circle text-yellow"></i>&nbsp;Délégué</span><span class="me-2"><i class="fas fa-circle text-magenta"></i>&nbsp;Admin</span></div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <footer class="bg-white sticky-footer">
                <div class="container my-auto">
                    <div class="text-center my-auto copyright"><span>Copyright © Consort organisation 2023</span></div>
                </div>
            </footer>
        </div><a class="border rounded d-inline scroll-to-top" href="#page-top"><i class="fas fa-angle-up"></i></a>
    </div>
    <div class="alert al"></div>
    <script src="../assets/admin/bootstrap/js/bootstrap.min.js"></script>
    <script src="../assets/admin/js/chart.min.js"></script>
    <script src="../assets/admin/js/bs-init.js"></script>
    <script src="../assets/admin/js/theme.js"></script>
    <script src="../assets/js/logout.js"></script>

</body>

</html>