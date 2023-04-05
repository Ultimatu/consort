<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();
//verifier s'il est passé par la page de connexion
if (!isset($_SESSION['adminWantToLogin']) || $_SESSION['adminWantToLogin'] != true || !isset($_SESSION["email"])) {
    header("Location: ../index.php");
    exit;
}
//verifier si un id est passé en parametre et si une action est demandée
if (!isset($_GET['id']) || empty($_GET['id']) || !isset($_GET['action']) || empty($_GET['action'])) {
    $message = "<div class='alert alert-danger'>Aucune action n'a été sélectionné</div>";
}
$id = $_GET['id'];
$action = $_GET['action'];
include '../includes/db.connect.php';
//faire un switch pour les actions pour connaitre le nom de la table
switch ($action) {
    case 'delegue':
        $table = 'delegue';
        break;
    case 'produit':
        $table = 'produit';
        break;
    case 'zone':
        $table = 'zone';
        break;
    case 'dzp':
        $table = 'delegue_zone_produit';
        break;
    case 'gamme':
        $table = 'gamme';
        break;
    default:
        $message = "<div class='alert alert-danger'>Aucune action n'a été sélectionné</div>";
        break;
}
//faire une alerte pour demander de confirmer la suppression de l'élément
if (isset($table) && !isset($_GET["confirm"])) {
    $req = "SELECT * FROM $table WHERE id_$table = $id";
    $res = $db->prepare($req);
    $res->execute();
    $element = $res->fetch(PDO::FETCH_ASSOC);
    $message = "<div class= 'info'><div class='alert alert-danger'>Voulez-vous vraiment supprimer l'élément suivant: <br>";
    foreach ($element as $key => $value) {
        $message .= "<strong>$key</strong>: $value <br>";
    }
    $message .= "</div>";
    //button de confirmation de l'alerte
    $message .= "<div class='btn btn-outline-danger'> <a href='delete-confirmed.php?confirm=yes&action=$action&id=$id'>Oui</a> </div>";
    $message .= "<div class='btn btn-outline-info'> <a href='deleter.php?confirm=no&action=$action&id=$id'>Non</a> </div></div>";
}
if ( isset($_GET["confirm"]) && ($_GET["confirm"] == "no")){
    header("Location: index.php");
    exit;
}

?>
<!doctype html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Page de suppression</title>
    <!-- lien bootstrap locale -->
    <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">
    <!-- lien fontawesome en ligne -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <style>
        header {
            background-color: #2c3e50;
            color: white;
            padding: 10px;
            text-align: center;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        header h1 {
            margin: 0;
        }

        header h1 {

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

        header a {
            color: white;
            text-decoration: none;
        }

        .container {
            
            max-width: 500px;
            margin: 25px auto;
            align-items: center;
        }
        .info .btn-outline-info{
            margin-left: 45px;
            display: center;
            text-align: end;
            

        }
    </style>

</head>

<body>
    <header>
        <div class="btn btn-outline-info">
            <i class="fas fa-arrow-left"></i>
            <a href="index.php"></a>
        </div>
        <h1>
            Suppression définitive
        </h1>

    </header>
    <div class="container">
        <div class="row">
            <div class="col-12">

                <?php
                if (isset($message)) {
                    echo $message;
                }
                ?>
            </div>
        </div>
        <script src="../node_modules/jquery/dist/jquery.min.js"></script>
        <script src="../node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
</body>

</html>