<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
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
            /* background: #FBFBFB; */
            background: linear-gradient(90deg, #021253, #003d9e);
            font-family: 'Poppins', sans-serif;
        }

        .container-fluid {
            height: 60vh;
            width: 90vw;
        }

        .form-container {
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2), 0 6px 20px rgba(0, 0, 0, 0.1);
            background-color: #FBFBFB;
        }

        .form-button {
            width: 100%;
            border-radius: 10px;
            background-color: #003D9E;
            color: #FFF;
        }

        .form-control {
            border-radius: 10px;
            background-color: #fffafa;
        }

        .form-button:hover {
            background-color: #021253;
            color: #FFF;
        }

        .form-header {
            color: #003D9E;
            font-size: 25px;
        }

        .img-container {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .img-container img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            background: linear-gradient(90deg, #021253, #003d9e);
        }

        @media screen and (max-width: 768px) {
            .img-container img {
                object-fit: contain;
                background: linear-gradient(90deg, #021253, #003d9e);
            }
        }

        @media screen and (max-width: 576px) {
            .img-container img {
                object-fit: contain;
                background: linear-gradient(90deg, #021253, #003d9e);
            }
        }
    </style>
</head>

<body>