<?php

// Inclure le fichier mpdf
require_once __DIR__ . '/vendor/autoload.php';

// Créer un objet mpdf
$mpdf = new \Mpdf\Mpdf();

// Ajouter le code HTML
$html = '<h1>Mon diagramme</h1><canvas id="myChart"></canvas>';
$mpdf->WriteHTML($html);

// Générer le fichier PDF
$file = $mpdf->Output('', 'S');

// Envoyer le fichier en tant que réponse de téléchargement
header('Content-Type: application/pdf');
header('Content-Disposition: attachment; filename="mon-diagramme.pdf"');
header('Content-Length: ' . strlen($file));
echo $file;
