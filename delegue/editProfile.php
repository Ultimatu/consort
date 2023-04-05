<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();
if (!isset($_SESSION["delegueWantToLogin"])){
    header("Location: ../index.php");
    exit;
}
//verifier le formulaire
if ((isset($_POST["submit"])) && isset($_FILES["photo"]) && !empty($_FILES["photo"]["tmp_name"])){
    //verifier la taille de l'image et le type de l'image 
    $fileSize = $_FILES["photo"]["size"];
    $fileType = $_FILES["photo"]["type"];
    $fileTmpName = $_FILES["photo"]["tmp_name"];
    $fileError = $_FILES["photo"]["error"];
    $fileExt = explode(".", $_FILES["photo"]["name"]);
    $fileActualExt = strtolower(end($fileExt));
    $allowed = array("jpg", "jpeg", "png");
    if (in_array($fileActualExt, $allowed)){
        if ($fileError === 0){
            if ($fileSize < 1000000){
                //renommer l'image
                $fileNameNew = uniqid('', true).".".$fileActualExt;
                //déplacer l'image vers le dossier images
                $fileDestination = "../admin/images/delegue/".$fileNameNew;
                move_uploaded_file($fileTmpName, $fileDestination);
                //inserer l'image dans la base de données
                require_once "../includes/db.connect.php";
                $id = $_SESSION["id"];
                $sql = "UPDATE delegue SET photo = '$fileNameNew' WHERE id_delegue = '$id'";
                $req = $db->prepare($sql);
                $req->execute();
                //avertir l'admin que le delegue a changé sa photo de profile en envoyant  dans la table modification
                $req = $db->prepare("INSERT INTO modification (date, modification, id_delegue) VALUES (:date, :modification, :id_delegue)");
                $req->execute(array(
                    "date" => date("Y-m-d H:i:s"),
                    "modification" => "Le delegue a changé sa photo de profile ",
                    "id_delegue" => $id
                ));
                header("Location: ./delegue-index.php?upload=success");
                exit;
            }
            else{
                header("Location: ./delegue-index.php?error=bigfile");
                exit;
            }
        }
        else{
            header("Location: ./delegue-index.php?error=erroruploading");
            exit;
        }
    }
    else{
        header("Location: ./delegue-index.php?error=wrongfiletype");
        exit;
    }
    
}
else{
    header("Location: ./delegue-index.php?error=emptyfields");
    exit;
}



?>