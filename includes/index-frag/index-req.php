<?php
$req_ad = $db->prepare("SELECT * FROM admin");
$req_ad->execute();
$res_ad = $req_ad->fetchAll(PDO::FETCH_ASSOC);
//selectionne deux delegues au hasard
$req_del = $db->prepare(query: "SELECT * FROM delegue WHERE date_depart IS NULL ORDER BY RAND() LIMIT 2");
$req_del->execute();
$res_del = $req_del->fetchAll(PDO::FETCH_ASSOC);

//selectionnez les news dans la table news
$sql = "SELECT `news`.*, `produit`.*
FROM `news`
	, `produit` WHERE produit.photo_produit = news.cle LIMIT 3";
$req_pub = $db->prepare($sql);
$req_pub->execute();
$res_pub = $req_pub->fetchAll(PDO::FETCH_ASSOC);

//selectionne toute la gamme produite du get id
if (isset($_GET["id"])) {
    $id = $_GET["id"];
    $req_gamme = $db->prepare("SELECT * FROM gamme_produit WHERE id_laboratoire = $id");
    $req_gamme->execute();
    $res_gamme = $req_gamme->fetchAll(PDO::FETCH_ASSOC);
}
