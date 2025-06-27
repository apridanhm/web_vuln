<?php
if (basename($_SERVER['PHP_SELF']) === basename(__FILE__)) {
    http_response_code(403);
    die("ngapain ke sini keluar sana wkwkw");
}
$host = "localhost";
$user = "praktikum";         // user dengan akses terbatas
$password = "praktikum123";
$dbname = "sql_injection_lab";

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>