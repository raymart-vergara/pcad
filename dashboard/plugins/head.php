<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PCAD | Executive Settings</title>


    <link rel="icon" href="../dist/img/pcad_logo.ico" type="image/x-icon" />
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="../dist/css/font.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../dist/css/adminlte.min.css">
    <!-- Sweet Alert -->
    <link rel="stylesheet" href="../plugins/sweetalert2/dist/sweetalert2.min.css">
    <style>
        .loader {
            border: 16px solid #f3f3f3;
            border-radius: 50%;
            border-top: 16px solid #536A6D;
            width: 50px;
            height: 50px;
            -webkit-animation: spin 2s linear infinite;
            animation: spin 2s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(1080deg);
            }
        }

        @font-face {
            font-family: 'Poppins';
            src: url('../dist/font/poppins/Poppins-Regular.ttf') format('truetype');
        }

        body {
            background: #FBFBFB;
            font-family: 'Poppins', sans-serif;
        }

        /* .pcad-title {
            margin: 0;
            padding: 0;
            font-size: 30px;
        } */

        .form-container {
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2), 0 6px 20px rgba(0, 0, 0, 0.15);
            background-color: #fff;
        }

        .form-button {
            width: 100%;
            border-radius: 20px;
            background-color: #003D9E;
            color: #FFF;
        }

        .form-button:hover {
            background-color: #021253;
            color: #FFF;
        }

        .form-header {
            color: #003D9E;
            font-size: 22px;
        }

        .img-fill {
            width: 500px;
            height: auto;
            object-fit: contain;
            border-radius: 10px 0 0 10px;
        }
    </style>
</head>

<body>