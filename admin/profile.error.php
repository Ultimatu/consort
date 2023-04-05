<?php 
//Gérer les erreurs de l'utilisateur
if (isset($_GET['error'])){
    if ($_GET['error'] == "emptyFields"){
        $success= "<div class='alert alert-danger' role='alert'>Veuillez remplir tous les champs du paramètre concerné</div>";
    } else if ($_GET['error'] == "emailNotValid"){
        $success= "<div class='alert alert-danger' role='alert'>L'adresse email n'est pas valide</div>";
    } else if ($_GET['error'] == "passNotCorrespond"){
        $success= "<div class='alert alert-danger' role='alert'>Les mots de passe ne correspondent pas</div>";
    } else if ($_GET['error'] == "passLength"){
        $success= "<div class='alert alert-danger' role='alert'>Le mot de passe doit contenir au moins 8 caractères, une lettre majuscule, une lettre minuscule et un chiffre</div>";
    } else if ($_GET['error'] == "emailAlreadyUsed"){
        $success= "<div class='alert alert-danger' role='alert'>Cette adresse email est déjà utilisée</div>";
    }
    //pasRgex
    else if ($_GET['error'] == "passRegex"){
        $success= "<div class='alert alert-danger' role='alert'>Le mot de passe doit contenir au moins 8 caractères, une lettre majuscule, une lettre minuscule et un chiffre</div>";
    }
    //phototype
    else if ($_GET["error"] == "photoType"){
        $success= "<div class='alert alert-danger' role='alert'>Le type de photo envoyé n'est pas autorisé</div>";
    }
    //signature vide
    else if ($_GET["error"] == "signatureEmpty"){
        $success= "<div class='alert alert-danger' role='alert'>Veuillez remplir le champ signature</div>";
    }
    //photoError
    else if ($_GET["error"] == "photoError"){
        $success= "<div class='alert alert-danger' role='alert'>Une erreur est survenue lors de l'envoi de la photo</div>";
    }
    //photoSize
    else if ($_GET["error"] == "photoSize"){
        $success= "<div class='alert alert-danger' role='alert'>La taille de la photo est trop grande</div>";
    }


}
//Gérer les succès de l'utilisateur
if (isset($_GET['success'])){
    if ($_GET['success'] == "photoChanged"){
        $success =  "<div class='alert alert-success' role='alert'>Votre profil a été modifié avec succès</div>";
    } else if ($_GET['success'] == "signatureChanged"){
        $success = "<div class='alert alert-success' role='alert'>Votre signature a été modifiée avec succès</div>";
    } else if ($_GET['success'] == "passChanged"){
        $success = "<div class='alert alert-success' role='alert'>Votre mot de passe a été modifié avec succès</div>";
    }
    //personalDatas
    else if ($_GET['success'] == "personalDatas"){
        $success =  "<div class='alert alert-success' role='alert'>Vos données personnelles ont été modifiées avec succès</div>";
    }

}

?>