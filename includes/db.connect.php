<?php
 //connection à la base de données
//avec PDO (PHP Data Objects)
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "consort";
try {
    $db = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Erreur de connexion à la base de données: " . $e->getMessage();

}



