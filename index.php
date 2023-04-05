<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
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
include_once 'includes/index-frag/index-req.php';

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Tonde Souleymane">
    <meta name="robots" content="index, follow">
    <meta name="googlebot" content="index, follow">
    <meta name="description" content="Consort est une entreprise qui a pour but de promouvoir des médicaments pharmaceutiques">
    <meta name="keywords" content="Consort, médicaments, pharmaceutiques, promotion, santé, maladie, maladies,
traitement, traitements, laboratoire, laboratoires, pharmacie, pharmacies, pharmacien, pharmaciens, médecin, médecins, médecine, médecines, médecine générale, médecine générales, médecine spécialisée, médecine spécialisées, médecine spécialiste, médecine spécialistes, médecine spécialiste généraliste">
    <link rel="icon" href="assets/images/logo/logo.png" size="42x42">


    <title>Consort home page</title>
    <!-- bootstrap css -->
    <link rel="stylesheet" href="./node_modules/bootstrap/dist/css/bootstrap.min.css">
    <!-- font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <!-- google fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- custom css -->
    <link rel="stylesheet" href="assets/css/index-style.css">
</head>

<body>
   <?php
   require_once 'includes/index-frag/index-navbar.php';
   require_once 'includes/index-frag/index-carousel.php';
   ?>



  <?php
  require_once 'includes/index-frag/position_embed.php';
  require_once 'includes/index-frag/index-footer.php'
  ?>





    <!-- Modal -->
    <div class="modal fade" id="termsModal" tabindex="-1" role="dialog" aria-labelledby="termsModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="termsModalLabel">Termes d'usage</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>CONSORT : nom de l'entreprise qui souhaite mettre en place un système informatique pour gérer ses activités liées à la promotion de médicaments pharmaceutiques.</p>
                    <p>Partenaires : firmes nationales et internationales avec lesquelles CONSORT travaille pour importer des produits pharmaceutiques.</p>
                    <p>Délégués médicaux : les employés de CONSORT qui font la promotion des produits auprès des médecins et des pharmaciens.</p>
                    <p>Gamme de produits : un ensemble de produits pharmaceutiques liés par leur utilisation et leur public cible.</p>
                    <p>Zone d'affectation : région géographique à laquelle est affecté un délégué médical pour la promotion des produits de CONSORT.</p>
                    <p>Stock de médicaments : quantité de médicaments disponibles pour la vente et la promotion.</p>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="policyModal" tabindex="-1" role="dialog" aria-labelledby="policyModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="policyModalLabel">Politique d'utilisation</h4>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <p>Texte de la politique d'utilisation ici.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-bs-dismiss="modal">Fermer</button>
                </div>
            </div>
        </div>
    </div>



    <!-- jQuery -->
    <script src="./node_modules/jquery/dist/jquery.min.js"></script>
    <!-- Popper.js -->
    <script src="./node_modules/@popperjs/core/dist/umd/popper.min.js"></script>
    <!-- Bootstrap js -->
    <script src="./node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>



</body>

</html>