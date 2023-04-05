<?php
//la session 
session_start();
//verifier s'il est passé par la page de connexion
if (!isset($_SESSION['adminWantToLogin']) || $_SESSION['adminWantToLogin'] != true || !isset($_SESSION["email"])) {
    header("Location: ../index.php");
    exit;
}
//verifier si un id est passé en parametre et si une action est demandée
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: index.php");
}
$id = $_GET['id'];
//faire un formulaire pour modifier le delegue
//connecter à la base de données et selectionner les données du delegue
include '../includes/db.connect.php';
$req = "SELECT * FROM delegue WHERE id_delegue = $id";
$res = $db->prepare($req);
$res->execute();
$delegue = $res->fetch(PDO::FETCH_ASSOC);
//si le formulaire est soumis
$redirect = false;
if (isset($_POST['submit']) && $_GET['id']){
    //traiter les données
    foreach ($_POST as $key => $value) {
        $$key = trim($value);
        if (empty($value) && $key != "date_depart" && $key != "submit") {
            $message = "<div class='alert alert-danger'>Veuillez remplir tous les champs</div>";
            break;
        }
    }
    //verifier les données email et telephone 
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "<div class='alert alert-danger'>Veuillez entrer un email valide</div>";
    } elseif (!preg_match("/^[0-9]{10}$/", $telephone)) {
        $message = "<div class='alert alert-danger'>Veuillez entrer un numéro de téléphone valide</div>";
    } else {
        //modifier les données dans la base de données
        $req = "UPDATE delegue SET nom = :nom, prenom = :prenom, email = :email, telephone = :telephone, fonction = :fonction, date_entree = :date_entree,  date_depart = :date_depart WHERE id_delegue = $id";
        //verifier si la date de départ est vide et entrer null dans la base de données
        if (empty($date_depart)) {
            $date_depart = null;
        }
        $res = $db->prepare($req);
        $res->execute(array(
            ":nom" => $nom,
            ":prenom" => $prenom,
            ":email" => $email,
            ":telephone" => $telephone,
            ":date_depart" => $date_depart,
            ":date_entree" => $date_entree,
            ":fonction" => $fonction
        ));
        $message = "<div class='alert alert-success'>Les données ont été modifiées avec succès, vous serez rédiriger vers l'accueil</div>";
        $redirect = true;
    }
    
}

?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page de modification de delegue</title>
    <!-- local css npm -->
    <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">
    <!-- icone online -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body {
            background-color: #f5f5f5;
        }

        header {
            background-color: #4f65e3;
            padding: 20px;
            border-bottom: 1px solid #ddd;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        header h1 {
            margin: 0;
            color: #fff;
            animation: 2s ease-in-out 0s 1 slideInFromLeft;
        }

        header a {
            animation: 2s ease-in-out 0s 1 slideInFromRight;
        }

        .fadeIn {
            animation: 2s ease-in-out 0s 1 fadeIn;
        }

        @keyframes slideInFromLeft {
            0% {
                transform: translateX(-100%);
            }

            100% {
                transform: translateX(0);
            }
        }

        @keyframes slideInFromRight {
            0% {
                transform: translateX(100%);
            }

            100% {
                transform: translateX(0);
            }
        }

        @keyframes fadeIn {
            0% {
                opacity: 0;
            }

            100% {
                opacity: 1;
            }
        }

        .moveLikeCubeAnimate {
            animation: 2s ease-in-out 0s 1 moveLikeCubeAnimate;
        }

        @keyframes moveLikeCubeAnimate {
            0% {
                transform: translateZ(-100px) rotateY(90deg);
                opacity: 0;
            }

            50% {
                transform: translateZ(-100px) rotateY(90deg);
                opacity: 0.5;
            }

            100% {
                transform: translateZ(0) rotateY(0deg);
                opacity: 1;
            }
        }

        .container {
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            max-width: 600px;
            margin: 0 auto;
        }
        /* marge entre les form-group */
        .form-group {
            margin-bottom: 20px;
        }
    </style>


</head>

<body>
    <!-- header de la page avec bootstrap -->
    <header class="container-fluid bg-primary text-white">
        <a href="index.php" class="btn btn-light"><i class="fas fa-arrow-left"></i></a>
        <h1 class="display-4">Modification du délégué</h1>
    </header>
    <!-- formulaire de modification nom, prenom, adresse, matDelegue, telephone, email, fonction, date_entree, date_depart -->
    <div class="container fadeIn">
        <?php 
        if (isset($message)) {
            echo $message;
        }
        if ($redirect) {
            header("refresh:3;url=index.php");
        }
        ?>
        <form action="editDelegue.php?id=<?php echo $id ?>" method="post" class="moveLikeCubeAnimate">
            <div class="form-group">
                <label for="nom">Nom</label>
                <input type="text" name="nom" id="nom" class="form-control" value="<?php echo $delegue['nom'] ?>">
            </div>
            <div class="form-group">
                <label for="prenom">Prénom</label>
                <input type="text" name="prenom" id="prenom" class="form-control" value="<?php echo $delegue['prenom'] ?>">
            </div>
            <div class="form-group">
                <label for="adresse">Adresse</label>
                <input type="text" name="adresse" id="adresse" class="form-control" value="<?php echo $delegue['adresse'] ?>">
            </div>
            <div class="form-group">
                <label for="matDelegue">Matricule délégué</label>
                <input type="text" name="matDelegue" id="matDelegue" class="form-control" value="<?php echo $delegue['matDelegue'] ?>">
            </div>
            <div class="form-group">
                <label for="telephone">Téléphone</label>
                <input type="text" name="telephone" id="telephone" class="form-control" value="<?php echo $delegue['telephone'] ?>">
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="text" name="email" id="email" class="form-control" value="<?php echo $delegue['email'] ?>">
            </div>
            <div class="form-group">
                <label for="fonction">Fonction</label>
                <input type="text" name="fonction" id="fonction" class="form-control" value="<?php echo $delegue['fonction'] ?>">
            </div>
            <div class="form-group">
                <label for="date_entree">Date entrée</label>
                <input type="date" name="date_entree" id="date_entree" class="form-control" value="<?php echo $delegue['date_entree'] ?>">
            </div>
            <div class="form-group">
                <label for="date_depart">
                    Date de départ
                </label>
                <input type="date" name="date_depart" id="date_depart" class="form-control" value="<?php echo $delegue['date_depart'] ?>">
            </div>
            <div class="d-flex justify-content-center">
                <button type="submit" class="btn btn-primary" name="submit">Modifier</button>
            </div>

        </form>
    </div>

    <!-- local js npm -->
    <script src="../node_modules/jquery/dist/jquery.min.js"></script>
    <script src="../node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="../node_modules/popper.js/dist/umd/popper.min.js"></script>

</body>

</html>