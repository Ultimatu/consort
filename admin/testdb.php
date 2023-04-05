<?php

$username = "root";
$password = "";
$dbname = "consort";

// informations de connexion à la base de données
$servername = "localhost";


try {
    // connexion à la base de données
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // configuration de PDO pour lever les exceptions en cas d'erreur
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // requête SQL pour récupérer la taille de chaque table
    $sql = "SELECT table_name AS `Table`, round(((data_length + index_length) / 1024 / 1024), 2) `Size (MB)` FROM information_schema.TABLES WHERE table_schema = '$dbname' ORDER BY (data_length + index_length) DESC;";

    // exécution de la requête
    $stmt = $conn->query($sql);
    // récupération des résultats sous forme de tableau associatif
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // initialisation du tableau des données
    $table_sizes = array();

    // boucle sur les résultats pour remplir le tableau des données
    foreach ($results as $row) {
        $table_sizes[$row['Table']] = $row['Size (MB)'];
    }

    // affichage du tableau des données
    print_r($table_sizes);
} catch (PDOException $e) {
    echo "Erreur de connexion à la base de données: " . $e->getMessage();
}
?>
