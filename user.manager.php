<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
//Demarrage de la session
session_start();
//verifier si  la session de wantToContact est true
if(!isset($_SESSION['wantToContact']) || $_SESSION['wantToContact'] != true){
    //on redirige vers la page d'accueil
    header("Location: ../index.php???");
    //on arrête le script
    exit;
}


//Connexion a la base de donnees
include_once 'connect.db.php';
//si on click sur submitContact
if(isset($_POST['submitContact']) && isset($_GET["provider"])){
    $_SESSION["sent"] = true;
    $url = $_GET["provider"];
    //on récupère les valeurs des champs
    $nom = $_POST['name'];
    $subject = $_POST['subject'];
    $email = $_POST['email'];
    $message = $_POST['message'];
    //on verifie si les champs sont vides
    if(empty($nom) || empty($subject) || empty($email) || empty($message)){
        //on affiche un message d'erreur
        header("Location: $url.php?error=emptyFields");
        exit;
    } //verifier l'email
    else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){ 
        header("Location: $url.php?error=emailInvalid");
        exit;

    }
    else{
        //on prepare la requete
        $req = $conn->prepare("INSERT INTO up_contact_us(nom, subject, email, message) VALUES(:nom, :subject, :email, :message)");
        //on execute la requete
        $req->execute(array(
            'nom' => $nom,
            'subject' => $subject,
            'email' => $email,
            'message' => $message
        ));
        //on affiche un message de succes
        header("Location: $url.php?success=contacted");
        exit;
        
    }
}
else if (isset($_POST["submitSouscriber"]) && isset($_GET["provider"])){
    $_SESSION["sent"] = true;
    $email = $_POST["email"];
    $url = $_GET["provider"];
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
        header("Location: $url.php?error=souscriberEmail");
    }
    else{
        $sql = "SELECT * FROM up_souscriber WHERE email = '$email'";
        $req = $conn->prepare($sql);
        $req->execute();
        $res = $req->fetch(PDO::FETCH_ASSOC);

        if ($res){
            header("Location: $url.php?error=already");
        }
        else{
            $req = 'INSERT INTO up_souscriber(email) VALUES(:email)';
            $req_up = $conn->prepare($req);
            $req_up->execute(array(
                'email' => $email
            ));
            header("Location: $url.php?success=followed");
        }

    }
    exit;
}
else{
    header("Location: index.php");
}


