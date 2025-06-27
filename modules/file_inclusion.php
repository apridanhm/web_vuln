<?php
session_start();
$page_title = "🐞 Modul File Inclusion (Rentan)";
include '../includes/header.php';

// Direktori rahasia
$base_dir = realpath(__DIR__ . '/../rahasia_negara/mk_projo') . '/';

// Ambil parameter ?page
$page = $_GET['page'] ?? 'welcome.php';

// Hilangkan karakter ../ yang bisa digunakan untuk traversal, tapi tetap rentan secara dasar
$page = basename($page);

// Buat path absolut
$target = $base_dir . $page;
?>

<div class="text-center mb-4">
    <h2 style="text-shadow: 0 0 5px #00ff99;"><i class="fas fa-bug me-2"></i>Modul File Inclusion <span style="color:red">(Rentan)</span></h2>
    <p class="lead">Akses file lokal dengan parameter <code>?page=...</code></p>
</div>

<div class="mb-3 text-center">
    <a href="?page=welcome.php" class="btn btn-outline-hack m-1">Welcome</a>
    <a href="?page=profile.php" class="btn btn-outline-hack m-1">Profile</a>
    <a href="?page=about.php" class="btn btn-outline-hack m-1">About</a>
</div>

<div class="terminal-output">
<?php
    if (file_exists($target)) {
        include $target;
    } else {
        echo "<span style='color: red;'>File tidak ditemukan!</span>";
    }
?>
</div>

<div class="mt-4">
    <a href="../index.php" class="btn btn-outline-hack">Kembali ke Home Page</a>
</div>

<?php include '../includes/footer.php'; ?>
