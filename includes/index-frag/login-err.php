<?php
if (isset($_SESSION["wantToLogin"]) && $_SESSION["wantToLogin"] == true && isset($_GET["login"])) {
    if (isset($_GET["login"])) {
        if ($_GET["login"] == "admin") {
            $placeholder = "Mot de passe";
            $name = "admin";
            $submit = "submitAdmin";
            $name_word = "password";
        } else if ($_GET["login"] == "delegue") {
            $placeholder = "Matricule";
            $name = "delegue";
            $submit = "submitDelegue";
            $name_word = "matricule";
        }
    }
} else {
    header("Location: index.php");
    exit;
}
//verifier si il y a une erreur
if (isset($_GET["error"])) {
    if ($_GET["error"] == "emptyfields") {
        $error = "Veuillez remplir tous les champs";
    } else if ($_GET["error"] == "wrongemail") {
        $error = "L'email que vous avez entré n'existe pas";
    } else if ($_GET["error"] == "wrongpassword") {
        $error = "Le mot de passe que vous avez entré est incorrect";
    } else if ($_GET["error"] == "youaredelegue") {
        $error = "Vous êtes un delegue, veuillez vous connecter avec votre matricule";
    } else if ($_GET["error"] == "youareadmin") {
        $error = "Vous êtes un admin, veuillez vous connecter avec votre mot de passe";
    } else if ($_GET["error"] == "wrongmatricule") {
        $error = "Le matricule que vous avez entré est incorrect";
    } else if ($_GET["error"] == "wrongemailorpassword") {
        $error = "L'email ou le mot de passe que vous avez entré est incorrect";
    } else if ($_GET["error"] == "wrongemailormatricule") {
        $error = "L'email ou le matricule que vous avez entré est incorrect";
    } else if ($_GET["error"] == "nouser") {
        $error = "L'utilisateur que vous avez entré n'existe pas";
    }
    else if ($_GET["error"] == "suspended") {
        $error = "Oups, Vous ne pouvez plus accéder à ce compte, veuillez contacter l'admin pour plus d'info";
    }
    else {
        $error = "Une erreur inconnue s'est produite";
    }
}
