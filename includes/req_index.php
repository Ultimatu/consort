<?php
//selectionner tout les delegues
$req = $db->prepare("SELECT * FROM delegue WHERE date_depart IS NULL");
$req->execute();
$delegues = $req->fetchAll(PDO::FETCH_ASSOC);
$nbr_delegue = count($delegues);
//selectionner tout les laboratoires
$req = $db->prepare("SELECT * FROM laboratoire");
$req->execute();
$laboratoires = $req->fetchAll(PDO::FETCH_ASSOC);
$nbr_labo = count($laboratoires);

//selectionner tout les zones
$req = $db->prepare("SELECT * FROM zone");
$req->execute();
$zones = $req->fetchAll(PDO::FETCH_ASSOC);
$nbr_zone = count($zones);

//selectionner tout les admin
$req = $db->prepare("SELECT * FROM admin");
$req->execute();
$admins = $req->fetchAll(PDO::FETCH_ASSOC);
$nbr_admin = count($admins);

//selectionner touts les gammes de produits
$req = $db->prepare("SELECT * FROM gamme_produit");
$req->execute();
$gamme = $req->fetchAll(PDO::FETCH_ASSOC);
$nbr_gamme = count($gamme);


//selectionner touts les  de produits
$req = $db->prepare("SELECT * FROM produit");
$req->execute();
$produit = $req->fetchAll(PDO::FETCH_ASSOC);
$nbr_prod = count($produit);
if ($nbr_prod == null) $nbr_prod = 0.001;

//selectionner touts les  delegues en ligne
$req = $db->prepare("SELECT * FROM delegue WHERE badge = 'connecté%'");
$req->execute();
$delegues_connecte = $req->fetchAll(PDO::FETCH_ASSOC);
$nbr_delegue_connecte = count($delegues_connecte);
//selectionner les laboratoirees fonctionels
$req = $db->prepare("SELECT * FROM laboratoire WHERE etat LIKE '%fonctionnel%'");
$req->execute();
$labo_fonctionnel = $req->fetchAll(PDO::FETCH_ASSOC);
$nbr_labo_fonctionnel = count($labo_fonctionnel);

//selectionner toutes les demandes de creation de compte delegue
$req = $db->prepare("SELECT * FROM demande_delegue WHERE status LIKE '%en attente%'");
$req->execute();
$demandes = $req->fetchAll(PDO::FETCH_ASSOC);
$nbr_demande = count($demandes);
//selectionner les news de la table news
if (isset($_GET["news_v"]) && !empty($_GET["news_v"])) {
    $req = $db->prepare("UPDATE modification SET status = 'vu' WHERE id_modification= '$_GET[news_v]'");
    $req->execute();
}
$req = $db->prepare("SELECT * FROM modification, delegue WHERE modification.status IS NULL AND delegue.id_delegue = modification.id_delegue");
$req->execute();
$news = $req->fetchAll(PDO::FETCH_ASSOC);
$nbr_news = count($news);
if ($nbr_news == null) {
    $icons = "info";
    $nbr_news__ = $nbr_news;
} else {
    $icons = "danger";
    $nbr_news__ = $nbr_news . "+";
}

//selectionner tous les messages adresser à l'admin
$req = $db->prepare("SELECT * FROM message INNER JOIN delegue ON message.id_delegue = delegue.id_delegue WHERE vu_admin = 0 ORDER BY id");
$req->execute();
$messages = $req->fetchAll(PDO::FETCH_ASSOC);
$nbr_messages = count($messages);
//faire l'heure actuel moins l'heure de l'envoie du message





function duree_message($heure_envoi)
{
    $now = new DateTime();  // Heure actuelle
    $heure_envoi = new DateTime($heure_envoi);  // Heure d'envoi du message

    // Calcule la différence de temps entre l'heure d'envoi et l'heure actuelle
    $diff = $now->diff($heure_envoi);

    // Détermine la durée du message en fonction de la différence de temps
    if ($diff->y > 0 || $diff->m > 0 || $diff->d > 0) {
        // Si la différence est supérieure à 1 jour, retourne la date complète d'envoi
        return $heure_envoi->format("envoyé le d/m/Y à H:i:s");
    } elseif ($diff->h > 1) {
        // Si la différence est supérieure à 1 heure, retourne le temps en heures
        return $diff->h - 1 . " h" . ($diff->h > 1 ? "s" : "") . " et " . $diff->i . " min" . ($diff->i > 1 ? "s" : "");
    } elseif ($diff->i > 0) {
        // Si la différence est supérieure à 1 minute, retourne le temps en minutes
        return $diff->i . " min" . ($diff->i > 1 ? "s" : "");
    } else {
        // Sinon, retourne le temps en secondes
        return $diff->s . " sec" . ($diff->s > 1 ? "s" : "");
    }
}


//fermer la connexion
$req->closeCursor();
$db = null;

?>