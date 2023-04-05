<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();
//verifier s'il est passer par la page de connexion
if (!isset($_SESSION['adminWantToLogin']) || $_SESSION['adminWantToLogin'] != true || !isset($_SESSION["email"])) {
    header("Location: ../index.php");
    exit;
}
//verifier si un id de produit est passé en parametre
if (!isset($_GET['prod']) || empty($_GET['prod']) || !isset($_GET['nom']) || empty($_GET['nom'])) {
    $message = "<div class='alert alert-danger'>Aucun produit n'a été sélectionné</div>";
}
$prod = $_GET['prod'];
$nom = $_GET['nom'];
//connexion à la base de données
include_once '../includes/db.connect.php';
//selectionner tous les produits de la base de données qui ont l'id_produit passé en parametre dans l'url
$sql = "SELECT * FROM produit WHERE id_produit = '$prod' OR nom_produit = '$nom'";
//préparation de la requête
$stmt = $db->prepare($sql);
//exécution de la requête
$stmt->execute();
//récupération des résultats
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
//envoyer un message d'erreur si aucun produit n'a été trouvé
if (empty($result)) {
    $message = "<div class='alert alert-danger'>Aucun produit n'a été trouvé avec l'prod $prod</div>";
}
//fermeture de la requête
$stmt = null;
//fermeture de la connexion
//recuperer les delegues affectés à ce produit
$sql = "SELECT * FROM delegue WHERE id_delegue IN (SELECT id_delegue FROM delegue_zone_produit WHERE id_produit = ?)";
//préparation de la requête
$stmt = $db->prepare($sql);
//liaison des paramètres
$stmt->bindParam(1, $prod);
//exécution de la requête
$stmt->execute();
//récupération des résultats
$delegue = $stmt->fetchAll(PDO::FETCH_ASSOC);

//envoyer un message d'erreur si aucun produit n'a été trouvé
if (empty($delegue)) {
    $message_delegue = "<div class='alert alert-info'>Aucun délégué n'a été trouvé affecté à ce produit</div>";
}

//selectionner la gamme du produit
$sql = "SELECT * FROM gamme_produit WHERE id_gamme IN (SELECT id_gamme FROM produit WHERE id_produit = ?)";
//préparation de la requête
$stmt = $db->prepare($sql);
//liaison des paramètres
$stmt->bindParam(1, $prod);
//exécution de la requête
$stmt->execute();
//récupération des résultats
$gamme = $stmt->fetchAll(PDO::FETCH_ASSOC);
//fermeture de la requête
//selectionner le laboratoire de la gamme du produit
$sql = "SELECT * FROM laboratoire WHERE id_laboratoire IN (SELECT id_laboratoire FROM gamme_produit WHERE id_gamme IN (SELECT id_gamme FROM produit WHERE id_produit = ?))";
//préparation de la requête
$stmt = $db->prepare($sql);
//liaison des paramètres
$stmt->bindParam(1, $prod);
//exécution de la requête
$stmt->execute();
//récupération des résultats
$laboratoire = $stmt->fetchAll(PDO::FETCH_ASSOC);
//fermeture de la requête
$stmt = null;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produit infos</title>
    <!-- bootstarp -->
    <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">
    <!-- fontawesome en ligne -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        .container-gamme{
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            max-width: 800px;
            margin: 0 auto;

        }
        .container-gamme h1{
            text-align: center;
        }
        /* animation au table et h1 et p */
        p, h1, table{
            animation: 2s ease-in-out 0s 1 slideInFromLeft;
        }
        @keyframes slideInFromLeft {
            0% {
                transform: translateX(-100%);
            }
            100% {
                transform: translateX(0);
            }
        }
        /* hover de couleur au table et h1 et p et slide 3d*/
        p:hover, h1:hover, table:hover{
            color: #fff;
            background-color: #007bff;
            border-color: #007bff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
            transform: translate3d(0, 0, 0);
            transition: all 0.3s ease;

        }

    </style>

</head>

<body>
    <!-- si aucun prod n'est envoyez affichez seulement le message d'alert-->
    <div class="container-fluid">
        <header>
            <!-- un header de bootstrap -->
            <h1>
                <a href="index.php" class="btn btn-primary"><i class="fas fa-arrow-left"></i></a>
                <span class="text-center">Informations sur le produit <?php echo $nom; ?></span>
            </h1>
        </header>

        <?php
        if (isset($message) && !empty($message)) {
            echo $message;
        } else {

            //afficher un tableau montrant les delegues affectés à ce produit
            if (isset($message_delegue) && !empty($message_delegue)) {
                echo $message_delegue;
            } else {
                echo "<marque scrollamount='10' behavior='scroll' direction='left'><h1 class='text-center alert alert-success'>Delegues affectés à ce produit</h1></marque>";
                echo "<table class='table table-striped table-hover'>";
                echo "<thead>";
                echo "<tr>";
                echo "<th scope='col'>Nom</th>";
                echo "<th scope='col'>Prenom</th>";
                echo "<th scope='col'>Email</th>";
                echo "<th scope='col'>Telephone</th>";
                echo "<th scope='col'>Adresse</th>";
                //chat
                echo "<th scope='col'>Chat</th>";
                echo "</tr>";
                echo "</thead>";
                echo "<tbody>";

                foreach ($delegue as $row) {
                    echo "<tr>";
                    echo "<td>" . $row['nom'] . "</td>";
                    echo "<td>" . $row['prenom'] . "</td>";
                    echo "<td>" . $row['email'] . "</td>";
                    echo "<td>" . $row['telephone'] . "</td>";
                    echo "<td>" . $row['adresse'] . "</td>";
                    //chat
                    echo "<td><a href='chatbox.php?chat=" . $row['id_delegue'] . "' class='btn btn-primary'><i class='fas fa-comment'></i></a></td>";
                    echo "</tr>";
                }
            }
            //afficher la gamme du produit dans un paragraphe et son laboratoire dans un autre
            echo "</tbody>";
            echo "</table>";
            //div 
            echo "<div class='container container-gamme'>";
            echo "<marque scrollamount='10' behavior='scroll' direction='left'><h1 class='text-center alert alert-success'>Gamme du produit et laboratoire de fabrication</h1></marque>";
            foreach ($gamme as $row) {
                echo "<p class='text-center alert alert-info'>Gamme : " . $row['categorie'] . "</p>";

            } 
            foreach ($laboratoire as $row) {
                echo "<p class='text-center alert alert-info'>Laboratoire: " . $row['nom'] . "</p>";
            }
            echo "</div>";

            


        }
        ?>


    </div>

    <!-- jquery et bootstrap min locale -->
    <script src="../node_modules/jquery/dist/jquery.min.js"></script>
    <script src="../node_modules/bootstrap/dist/js/bootstrap.min.js"></script>

</body>

</html>