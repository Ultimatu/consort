<?php 
//selectionner tous les donnees d'admin
include("../includes/db.connect.php");
$req = $db->prepare("SELECT * FROM admin WHERE id_admin = '$_SESSION[id]'");
$req->execute();
$admin = $req->fetch(PDO::FETCH_ASSOC);
$nom = $admin['nom'];
$prenom = $admin['prenom'];
//photo
$photo_ad = $admin['admin_photo'];

?>