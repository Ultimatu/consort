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
if (!isset($_GET['id']) || empty($_GET['id']) || !isset($_GET['action']) || empty($_GET['action']) || !isset($_GET['confirm']) || empty($_GET['confirm'])) {
    header("Location: index.php");
}
$id = $_GET['id'];
$action = $_GET['action'];
$confirm = $_GET['confirm'];
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

if ($confirm == "yes") {
    //si table égale à delegue  , on introduit une date de depart au lieu de supprimer avec current_timestamp
    if ($table == 'delegue') {
        $req = "UPDATE $table SET date_depart = current_timestamp WHERE id_$table = $id";
        $res = $db->prepare($req);
        $res->execute();
        $message = "<div class='alert alert-success'>L'élément a été supprimé avec succès, vous allez être rédirigé à l'accueil dans <span id='counter'>5</span> sécondes</div>";
    } else {
        $req = "DELETE FROM $table WHERE id_$table = $id";
        $res = $db->prepare($req);
        $res->execute();
        $message = "<div class='alert alert-success'>L'élément a été supprimé avec succès, vous allez être rédirigé à l'accueil dans <span id='counter'>5</span> sécondes</div>";
    }
    $req = "DELETE FROM $table WHERE id_$table = $id";
    $res = $db->prepare($req);
    $res->execute();
    $message = "<div class='alert alert-success'>L'élément a été supprimé avec succès, vous allez être rédirigé à l'accueil dans <span id='counter'>5</span> sécondes</div>";
} else {
    header("Location: index.php");
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete and redirect</title>
    <!-- bootstrap locale -->
    <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">
    <!-- fontawesome en ligne -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <style>
        body {
            background-color: #f5f5f5;
            align-items: center;
            justify-content: center;
            display: flex;
            height: 100vh;

        }
        .container {
            width: 100%;
            max-width: 500px;
        }


    </style>

</head>
<body>

    <div class="container">
        <div class="row">
            <div class="col-12">
                <?php echo $message; ?>
            </div>
        </div>
    </div>

    <script src="../node_modules/jquery/dist/jquery.min.js"></script>
    <script src="../node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
    <script>
        var counter = 5;
        setInterval(function() {
            counter--;
            if (counter >= 0) {
                span = document.getElementById("counter");
                span.innerHTML = counter;
            }
            if (counter === 0) {
                clearInterval(counter);
            }
        }, 1000);
        setTimeout(function() {
            window.location.href = "index.php";
        }, 5000);
    </script>

</body>
</html>