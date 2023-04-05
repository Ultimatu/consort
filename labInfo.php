<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
//session 
session_start();

$_SESSION["wantToLogin"] = true;
$_SESSION["adminWantToLogin"] = false;
$_SESSION["wantToContact"] = true;
include_once "./includes/db.connect.php";
//se conneter a la base de donnee recuprer les donnees du labo
if (isset($db)) {
    $req = $db->prepare("SELECT * FROM laboratoire WHERE  etat = 'Fonctionnel'");
    $req->execute();
}
//admin
$req_ad = $db->prepare("SELECT * FROM admin");
$req_ad->execute();
$res_ad = $req_ad->fetchAll(PDO::FETCH_ASSOC);
//selectionne deux delegues au hasard
$req_del = $db->prepare(query: "SELECT * FROM delegue WHERE date_depart IS NULL ORDER BY RAND() LIMIT 2");
$req_del->execute();
$res_del = $req_del->fetchAll(PDO::FETCH_ASSOC);

//selectionne toute la gamme produite du get id
if (isset($_GET["id"])) {
    $id = $_GET["id"];
    $req_gamme = $db->prepare("SELECT * FROM gamme_produit WHERE id_laboratoire = $id");
    $req_gamme->execute();
    $res_gamme = $req_gamme->fetchAll(PDO::FETCH_ASSOC);
}

//verifier si id et labo sont données en get et les recupérer
if (isset($_GET['id']) && isset($_GET['labo'])) {
    $id = $_GET['id'];
    $labo = $_GET['labo'];


    include_once 'includes/db.connect.php';
    //selectionner le labo
    $sql = "SELECT * FROM laboratoire WHERE id_laboratoire = '$id'";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $labo = $stmt->fetchAll(PDO::FETCH_ASSOC);
    //selectionner les gamme_product de ce labo et recuperer les produits de chaque gamme avec pdo
    $sql = "SELECT * FROM gamme_produit WHERE id_laboratoire = '$id'";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $gamme = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $nbr_gamme = count($gamme);
    //selectionner les produits de chaque gamme


} else {
    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Page d'informations sur les laboratoires">
    <meta name="keywords" content="Info, connexion, page de connexion">
    <meta name="author" content="Tonde Souleymane">
    <meta name="robots" content="Info, follow">
    <meta name="googlebot" content="info, follow">
    <link rel="icon" href="assets/images/logo/logo.png" size="42x42">
    <title>Informations laboratoire et produit</title>
    <link rel="stylesheet" href="./node_modules/bootstrap/dist/css/bootstrap.min.css">
    <!-- fontawesome en ligne-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="assets/css/index-style.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-danger sticky-top">
        <div class="container-fluid">

            <img src="./assets/images/logo/logo.png" width="80" height="40" alt="" class="navbar-brand img-fluid logo">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">

                <ul class="navbar-nav mx-auto">
                    <li class="nav-item an">
                        <a class="nav-link" href="index.php">
                            <i class="fa fa-home"></i> Accueil
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle active" href="#drp" id="navbarDropdownMenuLink1" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-industry"></i> Labo partenaires
                        </a>
                        <div class="dropdown-menu cursor-pointer animated--fade-out" aria-labelledby="navbarDropdownMenuLink1">
                            <?php
                            if ($req->rowCount() > 0) {
                                //afficher les donnees
                                while ($row = $req->fetch(PDO::FETCH_ASSOC)) {
                                    echo "<a class='dropdown-item' href='labInfo.php?labo=true&id=" . $row["id_laboratoire"] . "'>" . $row["nom"] . "</a>";
                                }
                            } else {
                                echo "Aucun laboratoire n'a ete enregistre";
                            }
                            ?>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="about-us.php">
                            <i class="fa fa-info-circle"></i>
                            Savoir plus
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="contact-us.php">
                            <i class="fa fa-envelope"></i> Contact
                        </a>
                    </li>

                </ul>
                <form class="d-flex justify-content-between ml-auto my-lg-0">
                    <input class="form-control mr-sm-2 serchBar" type="search" placeholder="Rechercher" aria-label="Search">
                    <button class="btn btn-outline-success my-2 my-sm-0" type="submit"><i class="fas fa-search"></i> </button>
                </form>
                <ul class="navbar-nav me-lg-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-user"></i>
                        </a>
                        <div class="dropdown-menu  dropdown-menu-xxl-start" aria-labelledby="navbarDropdownMenuLink">
                            <div>
                                <a href="login.php?login=delegue" class="btn btn-outline-light btn-lg dropdown-item">Délégue</a>
                            </div>
                            <div>
                                <a href="login.php?login=admin" class="btn btn-outline-light btn-lg dropdown-item">Admin</a>
                            </div>
                        </div>
                    </li>
                </ul>

            </div>
        </div>
    </nav>
    <main>
        <div class="container">
            <!-- affichage du nom du labo  -->
            <h2 class="text-center">Laboratoire : <?php
                                                    foreach ($labo as $labo) {
                                                        echo $labo['nom'];
                                                    }
                                                    ?></h2>
        </div>
        <!-- affichage de chaque gamme de produit dans card et  avec ses produits -->
        <?php
        if (isset($gamme) && $gamme) {
            foreach ($gamme as $gamme) {
                $id_gamme = $gamme['id_gamme'];
                $sql = "SELECT * FROM produit WHERE id_gamme = '$id_gamme'";
                $stmt = $db->prepare($sql);
                $stmt->execute();
                $produit = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $nbr_produit = count($produit);
        ?>
                <div class="card ">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="logo">
                                    <!-- nom de la gamme -->
                                    <h3><?php echo $gamme['categorie'] ?></h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                if (isset($produit) && $produit) {
                    foreach ($produit as $produit) {
                ?>
                        <div class="card">
                            <div class="card-body">
                                <span class="text-muted">
                                    Les produits de la gamme <?php echo $gamme['categorie'] ?>
                                </span>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="logo">
                                            <!-- image du produit -->
                                            <img src="assets/images/product/<?php echo $produit['photo_produit'] ?>" alt="image produit">
                                            <div class="logo">
                                                <!-- nom du produit -->
                                                <h3><?php echo $produit['nom_produit'] ?></h3>
                                            </div>
                                            <!-- description -->
                                            <p class="card-text"><?php echo $produit['description'] ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
            <?php

                    }
                } else {
                    echo "<div class='alert alert-info'>";
                    echo "Cette gamme n'a pas encore de produit";
                    echo "</div>";
                }
            }

        }
            else {
                echo "<div class='alert alert-info'>";
                echo "Ce laboratoire n'a pas encore  de sa gamme";
                echo "</div>";
            }

            ?>

    </main>
    <div class="container">
        <footer class="py-5">
            <div class="row">
                <div class="col-2">
                    <h5>Pages</h5>
                    <ul class="nav flex-column">
                        <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-muted">Accueil</a></li>
                        <li class="nav-item mb-2 dropdown">
                            <a class="nav-link p-0 text-muted dropdown-toggle" href="#" id="navbarDropdownMenuLink2" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Se connecter
                            </a>
                            <div class="dropdown-menu  dropdown-menu-xxl-start" aria-labelledby="navbarDropdownMenuLink2">
                                <div>
                                    <a href="login.php?login=delegue" class="btn btn-outline-light btn-lg dropdown-item">Délégue</a>
                                </div>
                                <div>
                                    <a href="login.php?login=admin" class="btn btn-outline-light btn-lg dropdown-item">Admin</a>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>

                <div class="col-2">
                    <h5>Supprort</h5>
                    <ul class="nav flex-column">
                        <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-muted">FAQs</a></li>
                        <li class="nav-item mb-2"><a href="about-us.php" class="nav-link p-0 text-muted">A propos</a></li>
                    </ul>
                </div>

                <div class="col-2">
                    <h5>Mentions légales</h5>
                    <ul class="nav flex-column">
                        <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-muted">Conditions d'utilisations</a></li>
                        <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-muted">Politiques d'utilisations</a></li>
                    </ul>
                </div>

                <div class="col-4 offset-1">
                    <form action="user.manager.php?provider=index" method="post">
                        <h5>Abonnement</h5>
                        <p class="text-muted">Vous recevrez des nouvelles de nous chaque mois.</p>
                        <div class="d-flex w-100 gap-2">
                            <input id="newsletter1" type="email" name="email" class="form-control" placeholder="Email
                            address" required>
                            <button class="btn btn-outline-success" type="submit" name="submitSouscriber">Souscrire</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="d-flex justify-content-between py-4 my-4 border-top">
                <p>&copy; 2023 Company, Consort. Tout droit Réservé.</p>
                <ul class="list-unstyled d-flex">
                    <li class="ms-3"><a class="link-dark" href="https://www.facebook.com"><i class="fab
                    fa-facebook"></i></a></li>
                    <li class="ms-3"><a class="link-dark" href="https://instagram.com"><i class="fab
                    fa-instagram"></i></a></li>
                    <li class="ms-3"><a class="link-dark" href="https://twitter.com"><i class="fab
                    fa-twitter"></i></a></li>
                    <li class="ms-3"><a class="link-dark" href="https://linkedin.com"><i class="fab
                    fa-linkedin"></i></a></li>
                    <li class="ms-3"><a class="link-dark" href="https://whatsapp.com"><i class="fab
                    fa-whatsapp"></i></a></li>

                </ul>
            </div>
        </footer>
    </div>
    <script src="./node_modules/jquery/dist/jquery.min.js"></script>
    <script src="./node_modules/bootstrap/dist/js/bootstrap.min.js"></script>


</body>

</html>