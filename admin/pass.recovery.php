<?php
//Debut de la session
session_start();
//Si la session n'existe pas
if (!isset($_SESSION['wantToLogin']) || empty($_SESSION['wantToLogin']) || $_SESSION['wantToLogin'] != true) {
    header("location: ../index.php");
    exit();
}
//Si la session n'existe pas
if (!isset($_SESSION['passed_by_form']) || empty($_SESSION['passed_by_form']) || $_SESSION['passed_by_form'] != true ) {
    header("location: ../index.php");
    exit();
}
//Si la session passed_by_recovery_form existe
if (!isset($_SESSION['passed_by_recovery_form']) || empty($_SESSION['passed_by_recovery_form']) || $_SESSION['passed_by_recovery_form'] != true) {
    header("location: ../index.php");
    exit();
}
$_SESSION['auth_recovery'] = false;
include "../includes/db.connect.php";
//verifier que les données email et telephone appartiennent à un admin
if (isset($_POST["verifDatas"])){
    //recuperer les données
    $email = $_POST["email"];
    $telephone = $_POST["phone"];
    //verifier les champs vides
    if (empty($email) || empty($telephone)) {
        header("location: password.forgot.php?admin=true&error=emptyFields");
        exit();
    }
    $req = $db->prepare("SELECT * FROM admin WHERE email = '$email' AND telephone = '$telephone'");
    $req->execute();
    $admin = $req->fetch(PDO::FETCH_ASSOC);
    //Si l'admin n'existe pas
    if (!$admin) {
        header("location: password.forgot.php?admin=true&error=wrongDatas");
        exit();
    }
    //Si l'admin existe
    if ($admin) {
        //declarer la session passed_by_recovery_form = true
        $_SESSION['passed_by_recovery_form'] = true;
        $_SESSION['auth_recovery'] = true;
        //declarer la session id_admin
        $_SESSION['admin_id_recovery'] = $admin['id_admin'];
        header("location: password.forgot.php?admin=true");
        exit();
    }
}
//faire le changement de mot de passe
if (isset($_POST["submitNew"]) && isset($_SESSION["change_form"])){
    echo "ok";
    //recuperer les données
    $new_password = $_POST["newPass"];
    $confirm_password = $_POST["confirmPass"];
    $_SESSION['auth_recovery'] = true;
    //verifier les champs vides
    if (empty($new_password) || empty($confirm_password)) {
        header("location: password.forgot.php?admin=true&error=emptyFields");
        exit();
    }
    //verifier que les deux mots de passe sont identiques
    if ($new_password != $confirm_password) {
        header("location: password.forgot.php?admin=true&error=notIdentical");
        exit();
    }
    //verifier que le mot de passe est assez long
    if (strlen($new_password) < 8) {
        header("location: password.forgot.php?admin=true&error=tooShort");
        exit();
    }
    //verifier regex de mot de passe solide , lettre majuscule, minuscule, chiffre, caractere special
    if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/', $new_password)) {
        header("location: password.forgot.php?admin=true&error=weakPassword");
        exit();
    }
    //crypter le mot de passe
    $new_password = password_hash($new_password, PASSWORD_DEFAULT);
    //modifier le mot de passe
    $req = $db->prepare("UPDATE admin SET password = '$new_password' WHERE id_admin = '$_SESSION[admin_id_recovery]'");
    if ($req->execute()) {
        //supprimer la session passed_by_recovery_form
        unset($_SESSION['passed_by_recovery_form']);
        unset($_SESSION['passed_by_form']);
        //supprimer la session id_admin
        unset($_SESSION['admin_id_recovery']);
        //supprimer la session change_form
        unset($_SESSION['change_form']);
        //supprimer la session auth_recovery
        unset($_SESSION['auth_recovery']);
        //session de redirection
        $_SESSION['redirect'] = true;
        header("location: redirect.to.login.php?admin=true&success=passChanged");
        exit;
    }

}
?>