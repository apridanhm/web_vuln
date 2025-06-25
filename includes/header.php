<?php
// Deteksi apakah file berada di dalam folder 'modules' atau tidak
$path_prefix = (str_contains($_SERVER['PHP_SELF'], 'modules/')) ? '../' : '';
?>
<link rel="stylesheet" href="<?= $path_prefix ?>assets/icon/css/all.min.css">

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $page_title ?? "Web Vulnerability" ?></title>
    <link rel="stylesheet" href="<?= $path_prefix ?>assets/css/bootstrap.min.css">
    <style>
        body {
            background-color: #0f0f0f;
            color: #00ff99;
            font-family: 'Courier New', Courier, monospace;
        }

        h2, .lead {
            color: #00ff99;
            text-shadow: 0 0 5px #00ff99;
        }

        a.list-group-item {
            background-color: #111;
            color: #00ff99;
            border: 1px solid #00ff99;
            margin-bottom: 5px;
            transition: 0.3s ease-in-out;
        }

        a.list-group-item:hover {
            background-color: #00ff99;
            color: #111;
            font-weight: bold;
            box-shadow: 0 0 10px #00ff99;
        }

        .btn-hack, .btn-outline-danger {
            background-color: transparent;
            border: 1px solid #00ff99;
            color: #00ff99;
        }

        .btn-hack:hover, .btn-outline-danger:hover {
            background-color: #00ff99;
            color: #000;
            font-weight: bold;
            box-shadow: 0 0 10px #00ff99;
        }

        .terminal-output {
            background-color: #111;
            color: #00ff99;
            border: 1px solid #00ff99;
            padding: 10px;
            margin-top: 15px;
            font-family: 'Courier New', Courier, monospace;
            white-space: pre-wrap;
            box-shadow: 0 0 5px #00ff99;
        }

        .form-control {
            background-color: #000;
            color: #00ff99;
            border: 1px solid #00ff99;
        }

        .form-control:focus {
            background-color: #000;
            color: #00ff99;
            box-shadow: 0 0 5px #00ff99;
        }

        .alert-danger {
            background-color: transparent;
            color: #ff4b4b;
            border: 1px solid #ff4b4b;
            text-align: center;
        }

        ::placeholder {
            color: #00cc77;
            color: rgba(0, 204, 119, 0.5) !important;
        }

        input::placeholder {
            color: #00cc77 !important;
            letter-spacing: 0.5px;
            color: rgba(0, 204, 119, 0.5) !important;
        }

        input::-webkit-input-placeholder {
            color: #00cc77 !important;
            letter-spacing: 0.5px;
            color: rgba(0, 204, 119, 0.5) !important;
        }

        input:-moz-placeholder {
            color: #00cc77 !important;
            letter-spacing: 0.5px;
            color: rgba(0, 204, 119, 0.5) !important;
        }

        input:-ms-input-placeholder {
            color: #00cc77 !important;
            letter-spacing: 0.5px;
            color: rgba(0, 204, 119, 0.5) !important;
        }

        input::-webkit-input-placeholder { color: #00cc77; }
        input::-moz-placeholder { color: #00cc77; }
        input:-ms-input-placeholder { color: #00cc77; }
        input:-moz-placeholder { color: #00cc77; }

        .btn-outline-hack {
            border: 1px solid #00cc77;
            color: #00cc77;
            background-color: transparent;
            transition: 0.3s;
        }

        .btn-outline-hack:hover {
            background-color: #00cc77;
            color: #000;
        }

        html, body {
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        body {
            background-color: #111;
            color: #00cc77;
            font-family: monospace;
        }

        .footer {
            margin-top: auto;
            color: #00cc77;
            font-size: 14px;
        }
    </style>

    <?php
    // Log hanya jika user sudah login dan bukan admin
    if (isset($_SESSION['isLoggedIn']) && $_SESSION['role'] !== 'admin') {
        include_once $path_prefix . 'config/db.php';
        if (isset($conn) && $conn) {
            $uid = $_SESSION['user_id'];
            $endpoint = $_SERVER['PHP_SELF'];
            $safe_endpoint = mysqli_real_escape_string($conn, $endpoint);
            mysqli_query($conn, "INSERT INTO user_logs (user_id, endpoint) VALUES ('$uid', '$safe_endpoint')");
        }
    }
    ?>
</head>
<body class="container mt-5">
