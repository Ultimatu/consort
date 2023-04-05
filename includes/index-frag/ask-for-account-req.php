<?php
if (isset($_POST["submit"])){
    foreach ($_POST as $key => $value){
        ${$key} = $value;
        if (empty($value) && $key != "submit"){
            header("Location: ask-for-account.php?error=empty");
            exit;
        }
    }
    if (empty($lettre) || empty($nom) || empty($prenom) || empty($telephone)){
        header("Location: ask-for-account.php?error=empty");
        exit;
    }
    else if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
        header("Location: ask-for-account.php?error=email");
        exit;
    }
    include_once 'includes/db.connect.php';
    $sql = "SELECT * FROM demande_delegue WHERE email = '$email' AND telephone = '$telephone'";
    $req = $db->prepare($sql);
    $req->execute();
    $res = $req->fetch(PDO::FETCH_ASSOC);
    if ($res != NULL){
        header("Location: ask-for-account.php?error=already");
    }
    else{
        $req = $db->prepare("INSERT INTO demande_delegue(nom, prenom, email, telephone, lettre) VALUES(:nom, :prenom, :email, :telephone, :lettre)");
        $req->execute(array(
            "nom" => $nom,
            "prenom" => $prenom,
            "email" => $email,
            "telephone" => $telephone,
            "lettre" => $lettre
        ));
        header("Location: ask-for-account.php?success=true");
    }
    exit;


}
if (isset($_GET["error"])) {
    if ($_GET["error"] == "empty") {
        $error = "Veuillez remplir tous les champs";
    } else if ($_GET["error"] == "email") {
        $error = "L'email que vous avez entré est invalide";
    }
}
if (isset($_GET["success"]) && ($_GET["success"] == "true")) {
    $success = "Votre demande a été envoyé et est en attente de traitement, vous serez notifier";

}