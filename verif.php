<?php
//démarrer la session
session_start(); 
if (!isset($_SESSION["passed_by_form"]) || $_SESSION["passed_by_form"] != true){
    header("Location: index.php?eee");
}
//se connecter à la base de données
include("connect.db.php");
//récupérer les données du formulaire
if (isset($_POST["submitAdmin"])){
    $email = $_POST["email"];
    $password = $_POST["password"];
    //verifier si les champs sont vides 
    if (empty($email) || empty($password)){
        header("Location: login.php?error=emptyfields&login=admin");
        exit;
    }
    //requête pour vérifier si l'utilisateur existe dans la base de données
    $sql = "SELECT * FROM admin WHERE email = '$email'";
    $req = $conn->prepare($sql);
    $req->execute();
    $result = $req->fetch(PDO::FETCH_ASSOC);
    //si l'utilisateur existe
    if ($result){

        //vérifier si le mot de passe est correct

        
        if (!password_verify($password, $result["password"])){
            header("Location: login.php?error=wrongpassword&login=admin");
            exit;
        }
        else if (password_verify($password, $result["password"])){
            
            //enregistrer les données de l'utilisateur dans la session
            $_SESSION["id"] = $result["id_admin"];
            $_SESSION["email"] = $result["email"];
            $_SESSION["password"] = $result["password"];
            $_SESSION["adminWantToLogin"] =  true;
            
            //rediriger l'utilisateur vers la page d'accueil
            header("Location: ./admin/index.php");
            exit;
        }
        else{
            //verifier si l'utilisateur est dans la table de délégué
            $sql1 = "SELECT * FROM delegue WHERE email = '$email'";
            $req1 = $conn->prepare($sql1);
            $req1->execute();
            $result1 = $req1->fetch(PDO::FETCH_ASSOC);
            if ($result1){
                header("Location: login.php?error=youaredelegue&login=delegue");
                exit;
            }
            else{
                header("Location: login.php?error=wrongemailorpassword&login=admin");
                exit;
            }
        }
    }
    else{
        header("Location: login.php?error=nouser&login=admin");
        exit;
    }

}
    //verifier si pour delegue
else  if (isset($_POST["submitDelegue"])){
        $email = $_POST["email"];
        $matricule = $_POST["matricule"];
        //verifier si les champs sont vides
        if (empty($email) || empty($matricule)){
            header("Location: login.php?error=emptyfields&login=delegue");
            exit;
        }
        //requête pour vérifier si l'utilisateur existe dans la base de données
        $sql = "SELECT * FROM delegue WHERE email = '$email'";
        $req = $conn->prepare($sql);
        $req->execute();
        $result = $req->fetch(PDO::FETCH_ASSOC);
        //si l'utilisateur existe
        if ($result){
            //vérifier si le mot de passe est correct
            if ($matricule != $result["matDelegue"]){
                header("Location: login.php?error=wrongmatricule&login=delegue");
                exit;
            }
            else if ($matricule == $result["matDelegue"]){
                if ($result["date_depart"] != NULL){
                    header ("Location: login.php?error=suspended&login=delegue");
                    exit;
                }
                //démarrer la session
                session_start();
                //enregistrer les données de l'utilisateur dans la session
                $_SESSION["id"] = $result["id_delegue"];
                $_SESSION["email"] = $result["email"];
                $_SESSION["matricule"] = $result["matDelegue"];
                $_SESSION["delegueWantToLogin"] = true;
                //rediriger l'utilisateur vers la page d'accueil
                header("Location: ./delegue/delegue-index.php");
                exit;
            }
            else{
                //verifier si l'utilisateur est dans la table d'admin
                $sql1 = "SELECT * FROM admin WHERE email = '$email'";
                $req1 = $conn->prepare($sql1);
                $req1->execute();
                $result1 = $req1->fetch(PDO::FETCH_ASSOC);
                if ($result1){
                    header("Location: login.php?error=youareadmin&login=admin");
                    exit;
                }
                else{
                    header("Location: login.php?error=wrongemailormatricule&login=delegue");
                    exit;
                }
            }
        }
        else{
            header("Location: login.php?error=nouser");
            exit;
        }
}

