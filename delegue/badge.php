<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);


?>



<!DOCTYPE html>
<html>

<head>
    <title>Carte d'identité entreprise</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f5f5f5;
            font-family: Arial, sans-serif;
            font-size: 14px;
            line-height: 1.5;
        }

        .card {
            width: 85mm;
            height: 54mm;
            background-color: #FFF;
            border: 1px solid #000;
            position: relative;
            overflow: hidden;
            margin: auto;
        }

        .card:before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4mm;
            background-color: #08c;
        }

        .card:after {
            content: "";
            position: absolute;
            top: 0;
            right: 0;
            width: 4mm;
            height: 100%;
            background-color: #08c;
        }

        .logo img {
            max-width: 60%;
            display: block;
            margin: 8mm auto 0;
        }

        .identification {
            margin: 8mm 0;
        }

        .identification span {
            display: block;
            margin: 3mm 0;
            font-weight: bold;
            font-size: 4mm;
        }

        .badge {
            font-size: 3mm;
            padding: 1mm 2mm;
            margin-right: 1mm;
            font-weight: normal;
            text-transform: uppercase;
        }

    </style>
</head>

<body>
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-4">
                <div class="logo">
                    <img src="../assets/images/qrcode/qrcode1.png" alt="Logo de l'entreprise">
                </div>
            </div>
            <div class="col-md-8">
                <div class="identification">
                    <span class="badge badge-secondary">ID</span>
                    <span>123456789</span>
                </div>
                <div class="identification">
                    <span class="badge badge-primary">SIRET</span>
                    <span>123 456 789 00010</span>
                </div>
                <div class="identification">
                    <span class="badge badge-success">APE</span>
                    <span>1234Z</span>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="card card-back">
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <div class="logo">
                    <img src="../assets/images/logo.png" alt="Logo de l'entreprise">
                </div>
            </div>
            <div class="col-md-6">
                <div class="qrcode">
                    <img src="../assets/images/qrcode/qrcode2.png" alt="Code QR">
                </div>
            </div>
        </div>
    </div>
</div>



</body>

</html>