<?php 
session_start();
$destroy = false;
include_once '../includes/db.connect.php';
if (isset($_SESSION["id"]) && !empty($_SESSION["id"])){
    $req = $db->prepare("UPDATE delegue SET badge = 'deconnecté' WHERE id_delegue = '$_SESSION[id]' ");
    if ($req->execute()){
        $destroy = true;
    }
    else{
        echo "error";
    }
    if ($destroy){
        session_destroy();
        header("Location: ../index.php");
        exit;
    }
}
else{
    header("Location: ../index.php");
    exit;
}

?>