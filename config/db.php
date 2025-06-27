<?php
if (basename($_SERVER['PHP_SELF']) === basename(__FILE__)) {
    http_response_code(403);
    die("ngapain ke sini keluar sana wkwkw");
}
$conn = mysqli_connect("localhost", "praktikum", "praktikum123", "wevuln");
if (!$conn) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

/*CREATE DATABASE wevuln;
USE wevuln;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50),
    password VARCHAR(50) -- Simpan plain untuk tujuan praktikum (bukan best practice)
);

INSERT INTO users (username, password) VALUES ('admin', 'admin123');*/
?>




