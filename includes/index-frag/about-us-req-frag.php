<?php
if (isset($db)) {
    $req = $db->prepare("SELECT * FROM laboratoire");
    $req->execute();
}
//selection de tous les délégués
$req_del = $db->prepare("SELECT * FROM delegue  WHERE  date_depart IS NULL");
$req_del->execute();
$res_delegue = $req_del->fetchAll(PDO::FETCH_ASSOC);
//selection de l'admin
$req_adm = $db->prepare("SELECT * FROM admin");
$req_adm->execute();
$res_admin = $req_adm->fetchAll(PDO::FETCH_ASSOC);
//selectionner toute la gamme produite du get id
if (isset($_GET["id"])) {
    $id = $_GET["id"];
    $req_gamme = $db->prepare("SELECT * FROM gamme_produit WHERE id_laboratoire = $id");
    $req_gamme->execute();
    $res_gamme = $req_gamme->fetchAll(PDO::FETCH_ASSOC);
}

if (isset($_GET["error"]) && $_SESSION["sent"]) {
    $error = $_GET["error"];
    $error = match ($error) {
        'emptyFields' => "Veuillez remplir tous les champs !",
        'souscriberEmail' => "Veuillez Entrer un email valide pour souscrire",
        'emailInvalid' => "Adresse email invalide",
        default => "une erreur est survenue",
    };
} else if (isset($_GET["success"])  && $_SESSION["sent"]) {
    $success = $_GET["success"];
    $success = match ($success) {
        'followed' => "Félicitation !!!, vous ête un abonner de consort désormais",
        'contacted' => "Votre message à été envoyé et est en attente d'une réponse",
        default => "une erreur est survenue",
    };
}
$go = false;
if (isset($success)) {
    $message = $success;
    $go = true;
    $color = 'success';
} else if (isset($error)) {
    $message = $error;
    $go = true;
    $color = 'danger';
}
