<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();
// Path: admin/chatbox.php
if (!isset($_SESSION["chat_delegue"]) || $_SESSION["chat_delegue"] != true) {
    header("Location: index.php");
    exit;
}

include_once "../includes/db.connect.php";

if (isset($_SESSION["id"]) && !empty($_SESSION["id"]) && $_SESSION["id"] != "null") {
    $chat_id = $_SESSION["id"];
    //verifier si le delegue existe
    $req = $db->prepare("SELECT * FROM admin");
    $req->execute();
    $admin = $req->fetch(PDO::FETCH_ASSOC);
    if (empty($admin)) {
        header("Location: index.php");
        exit;
    }
} else {
    header("Location: ../index.php");
    exit;
}

//message de delegue
$req = $db->prepare("SELECT *
FROM message
INNER JOIN delegue ON message.id_delegue = delegue.id_delegue
INNER JOIN admin ON message.id_admin = admin.id_admin
WHERE vu_admin = 1 and vu_delegue = 0 AND message.id_delegue = $chat_id AND message.destinataire = 'delegue'
ORDER BY id DESC
");
$req->execute();
$messages = $req->fetchAll(PDO::FETCH_ASSOC);
$nbr_messages = count($messages);
//message d'admin
$req = $db->prepare("SELECT *
FROM message
INNER JOIN delegue ON message.id_delegue = delegue.id_delegue
INNER JOIN admin ON message.id_admin = admin.id_admin
WHERE vu_delegue = 0 AND  vu_admin = 1 AND message.destinataire = 'delegue' AND message.id_delegue = '$chat_id'
ORDER BY id DESC
");
$req->execute();
$admin_messages = $req->fetchAll(PDO::FETCH_ASSOC);
$nbr_admin_messages = count($messages);
//tous les messages
$req = $db->prepare("SELECT *
FROM message
INNER JOIN delegue ON message.id_delegue = delegue.id_delegue
INNER JOIN admin ON message.id_admin = admin.id_admin
WHERE message.id_delegue = $chat_id
ORDER BY date ASC
");

$req->execute();
$all_messages = $req->fetchAll(PDO::FETCH_ASSOC);
if (isset($_POST["submit"])) {
    if (!empty($_POST["message"]) && !empty($_POST["message_id"])) {
        $req = $db->prepare("UPDATE message SET reponse = ?, h_reponse = current_timestamp(), vu_delegue = 1 WHERE id = ?");

        if ($req->execute([$_POST["message"], $_POST["message_id"]])) {
            header("Location: chatBox.php");
            exit;
        } else {
            echo "requette impossible";
        }
    }
} else if (isset($_POST["send"])) {
    if (!empty($_POST["message"])) {
        $req = $db->prepare("INSERT INTO message (id, id_delegue, id_admin, message, date, vu_admin, vu_delegue, destinataire, reponse, h_reponse) VALUES (NULL, ?, ?, ?, current_timestamp(), '0', '1', 'admin', NULL, NULL)");

        if ($req->execute([1, $chat_id, $_POST["message"]])) {
            header("Location: chatBox.php");
            exit;
        } else {
            echo "requette impossible";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WhatsApp Chat</title>
    <link rel="stylesheet" href="../assets/css/style-whatsapp.css">
</head>

<body>
    <div class="chat-container">
        <div class="navbar">
            <img src="../assets/images/logo/logo.png" alt="Logo" class="logo">
            <h1>Chat</h1>
        </div>

        <?php

        foreach ($all_messages as $key => $value) {

            $req = $db->prepare("SELECT nom, prenom
            FROM delegue WHERE matDelegue = '$value[matDelegue]'
            ");
            $req->execute();
            $nom_prenom = $req->fetch(PDO::FETCH_ASSOC);
            $req = null;
            if ($value["destinataire"] == "delegue") {
                $sender = "reponse";
                $date = "h_reponse";
                $recepteur = "message";
                $r_date = "date";
            } else {
                $sender = "message";
                $date = "date";
                $recepteur = "reponse";
                $r_date = "h_reponse";
            }
            $message_class = "read-message";
            if ($value["vu_admin"] == 0) {
                $message_class = "unread-message"; // ajouter la classe CSS "unread-message" pour les messages non lus
            }
            if (!empty($value[$sender])){
                
                if ($value[$date] < $value[$r_date]){
                    echo '<div class="chat-message user-message '.$message_class.'">
                    <p><img class="profile-pic" src="../assets/images/delegue/' . $value["photo"] . '" alt="Nom de l\'auteur" onclick="showImage(this)">' . $value[$sender] . '</p>
                    <p class="message-time">' . $value["date"] . '  </p>
                    </div>';
                }
                else{
                    if (!empty($value[$recepteur])) {
                        echo '<div class="chat-message author-message ' . $message_class . '">
                        <p><img class="profile-pic" src="../assets/images/admin/' . $value["admin_photo"] . '" alt="Nom de l\'auteur" onclick="showImage(this)">' . $value[$recepteur] . '</p>
                        <p class="message-time">' . $value[$r_date] . '</p>
                        </div>';
                    }
                }
                
            }
            if (!empty($value[$recepteur])) {
                if ($value[$r_date] > $value[$date]) {
                    echo '<div class="chat-message author-message ' . $message_class . '">
                <p><img class="profile-pic" src="../assets/images/admin/' . $value["admin_photo"] . '" alt="Nom de l\'auteur" onclick="showImage(this)">' . $value[$recepteur] . '</p>
                <p class="message-time">' . $value[$r_date] . '</p>
                </div>';

                }
            else{
                    if (!empty($value[$sender])) {
                    echo '<div class="chat-message user-message ' . $message_class . '">
                    <p><img class="profile-pic" src="../assets/images/delegue/' . $value["photo"] . '" alt="Nom de l\'auteur" onclick="showImage(this)">' . $value[$sender] . '</p>
                    <p class="message-time">' . $value["date"] . '  </p>
                    </div>';
                        }

            }
        }
        }
        
        if (count($messages) <= 0) { ?>
            <form action="chatBox.php" method="post">
                <div class="message-input">
                    <input type="text" name="message" placeholder="Type a message...">
                    <button type="submit" name="send">Send</button>
                </div>
            </form>
        <?php
        }
        ?>
        <?php
        if (count($messages) > 0) { ?>
            <form action="chatBox.php" method="post">
                <div class="message-select">
                    <select name="message_id" id="message">
                        <option value="null">Répondre à :</option>
                        <?php
                        foreach ($messages as $key => $value) {
                            echo ' <option value="' . $value["id"] . '">' . $value["message"] . '</option>';
                        }

                        ?>
                    </select>
                </div>
                <div class="message-input">
                    <input type="text" name="message" placeholder="Type a message...">
                    <button type="submit" name="submit">Send</button>
                </div>
            </form>
        <?php } ?>


    </div>
    <div>
        <a href="delegue-index.php" class="quitter">Retour à l'accueil</a>
    </div>
    <script>
        function showImage(img) {
            // Créez un élément de div qui contiendra l'image en grand
            var modal = document.createElement("div");
            modal.classList.add("modal");

            // Créez un élément de img pour afficher l'image en grand
            var modalImg = document.createElement("img");
            modalImg.src = img.src;

            // Ajoutez l'image en grand dans le div modal
            modal.appendChild(modalImg);

            // Ajoutez le div modal au corps du document
            document.body.appendChild(modal);

            // Ajoutez un gestionnaire d'événements pour que l'utilisateur puisse fermer la modal en cliquant sur l'image
            modal.addEventListener("click", function() {
                modal.parentNode.removeChild(modal);
            });
        }
    </script>
</body>

</html>