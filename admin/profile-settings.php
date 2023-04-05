<?php
//activer la session
session_start();

//verifier les authorisation  de adminWantToLogin
if(!isset($_SESSION['adminWantToLogin']) || empty($_SESSION['adminWantToLogin']) || $_SESSION['adminWantToLogin'] != true){
    header("location: ../index.php");
    exit();
}
include "../includes/db.connect.php";
include 'admin-prof.php';
//traiter les differentes requetes de post
//pour le changement de photo de profile
if (isset($_POST["newPhoto"]) && !empty($_POST["photo"])  && isset($_FILES["photo"]) && !empty
    ($_FILES["photo"]["name"])) {
    //recuperer les donnees
    $newPhoto = $_FILES["photo"];
    $newPhotoName = $newPhoto["name"];
    $newPhotoTmpName = $newPhoto["tmp_name"];
    $newPhotoSize = $newPhoto["size"];
    $newPhotoError = $newPhoto["error"];
    $newPhotoType = $newPhoto["type"];
    //recuperer l'extension de la photo
    $newPhotoExt = explode(".", $newPhotoName);
    $newPhotoActualExt = strtolower(end($newPhotoExt));
    //les extensions autorisees
    $allowed = array("jpg", "jpeg", "png", "gif", "svg");
    //verifier si l'extension est autorisee
    if (in_array($newPhotoActualExt, $allowed)) {
        //verifier si il y a une erreur
        if ($newPhotoError === 0) {
            //verifier la taille de la photo
            if ($newPhotoSize < 1000000) {
                //generer un nouveau nom pour la photo
                $newPhotoNameNew = uniqid('', true) . "." . $newPhotoActualExt;
                //chemin de la photo
                $newPhotoDestination = "../admin/images/admin/" . $newPhotoNameNew;
                //deplacer la photo dans le dossier
                if (move_uploaded_file($newPhotoTmpName, $newPhotoDestination)){
                    //supprimer l'ancienne photo dans le dossier
                    unlink("../admin/images/admin/".$photo_ad."");
                    $req = $db->prepare("UPDATE admin SET admin_photo = :newPhoto WHERE id_admin = '$_SESSION[id]'");
                    $req->execute(array(
                        "newPhoto" => $newPhotoNameNew
                    ));
                    //rediriger vers la page de profile
                    header("location: profile.php?success=photoChanged");
                    exit();
                }

            } else {
                header("location: profile.php?error=photoSize");
                exit();
            }
        } else {
            header("location: profile.php?error=photoError");
            exit();
        }
    } else {
        header("location: profile.php?error=photoType");
        exit();
    }

}
//pour la signature
if (isset($_POST["signature"])){
    //verifier si la signatureInput est vide
    if (empty($_POST["signatureInput"])){
        header("location: profile.php?error=signatureEmpty");
        exit();
    } else {
        //recuperer la signature
        $signature = $_POST["signatureInput"];
        //modifier la signature
        $req = $db->prepare("UPDATE admin SET signature = :signature WHERE id_admin = '$_SESSION[id]'");
        $req->execute(array(
            "signature" => $signature
        ));
        //rediriger vers la page de profile
        header("location: profile.php?success=signatureChanged");
        exit();
    }

}
//pour le mot de passe avec submitNewPass
if (isset($_POST['submitNewPass'])){
    //Vérifier les champs
    $newPass = $_POST['password'];
    $newPassConfirm = $_POST['confPassword'];
    //verifier si les champs sont vides
    if (empty($newPass) || empty($newPassConfirm)){
        header("location: profile.php?error=emptyFields");
        exit();
    } else {
        //verifier si les deux mots de passe sont identiques
        if ($newPass != $newPassConfirm){
            header("location: profile.php?error=passNotCorrespond");
            exit();
        }
        else if (strlen($newPass) < 8){
            //verifier la longueur du mot de passe
            header("location: profile.php?error=passLength");

        }//expression regex d'un mot de pass sur
        else if(!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{6,}$/', $newPass)){
            header("location: profile.php?error=passRegex");
            exit();
        } else {
            //crypter le mot de passe
            $newPass = password_hash($newPass, PASSWORD_DEFAULT);
            //modifier le mot de passe
            $req = $db->prepare("UPDATE admin SET password = :newPass WHERE id_admin = '$_SESSION[id]'");
            $req->execute(array(
                "newPass" => $newPass
            ));
            //rediriger vers la page de profile
            header("location: profile.php?success=passChanged");
            exit();
        }
        
        
        
    }
}

//pour les informations personnelles, email, nom, prenom de personalDatas1
if (isset($_POST['personalDatas1'])){
    //recuperer les donnees
    $newEmail = $_POST['email'];
    $newFirstName = $_POST['first_name'];
    $newLastName = $_POST['last_name'];
    //verifier si les champs sont vides
    if (empty($newEmail) || empty($newFirstName) || empty($newLastName)){
        header("location: profile.php?error=emptyFields");
        exit();
    } else {
        //verifier si l'email est valide
        if (!filter_var($newEmail, FILTER_VALIDATE_EMAIL)){
            header("location: profile.php?error=emailNotValid");
            exit();
        }
        else if($newEmail == $_SESSION["email"]){
            header('Location: profile.php?error=emailAlreadyUsed');
            exit;
        } else {
            //modifier les informations personnelles

            $req = $db->prepare("UPDATE admin SET email = :newEmail, nom = :newFirstName, prenom = :newLastName WHERE id_admin = '$_SESSION[id]'");
            $req->execute(array(
                "newEmail" => $newEmail,
                "newFirstName" => $newFirstName,
                "newLastName" => $newLastName
            ));
            //rediriger vers la page de profile
            header("location: profile.php?success=personalDatasChanged");
            exit();
        }
    }
}
//pour les informations personnelles, telephone, adresse, ville, pays de personalDatas2
if (isset($_POST['personalDatas2'])){
    //recuperer les donnees
    $newPhone = $_POST['phone'];
    $newAddress = $_POST['adresse'];
    $newCountry = $_POST['country'];
    //verifier si les champs sont vides
    if (empty($newPhone) || empty($newAddress) || empty($newCountry)){
        header("location: profile.php?error=emptyFields");
        exit();
    } else {
        //modifier les informations personnelles
        $req = $db->prepare("UPDATE admin SET telephone = :newPhone, adresse = :newAddress, pays = :newCountry WHERE id_admin = '$_SESSION[id]'");
        $req->execute(array(
            "newPhone" => $newPhone,
            "newAddress" => $newAddress,
            "newCountry" => $newCountry
        ));
        //rediriger vers la page de profile
        header("location: profile.php?success=personalDatasChanged");
        exit();
    }
}
