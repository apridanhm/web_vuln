<?php
session_start();
include_once __DIR__ . '/../../config/db.php';

if (!isset($_SESSION['isLoggedIn']) || !isset($_SESSION['user_id'])) {
    echo "<div class='alert alert-danger'>Akses ditolak. Silakan login terlebih dahulu.</div>";
    exit;
}

$user_id = (int) $_SESSION['user_id'];
$query = mysqli_query($conn, "SELECT nama, nim, username FROM users WHERE id = $user_id");

if ($query && mysqli_num_rows($query) > 0):
    $row = mysqli_fetch_assoc($query);
?>

<div class="terminal-output mt-4">
    <h4 class="mb-3" style="color:#00ff99; text-shadow:0 0 5px #00ff99;">ini profile.php anggap aja file2.php</h4>
    <p>Nama: <strong><?= htmlspecialchars($row['nama']) ?></strong></p>
    <p>Username: <strong><?= htmlspecialchars($row['username']) ?></strong></p>
    <p>NIM: <?= htmlspecialchars($row['nim']) ?: '<em>(tidak tersedia)</em>' ?></p>
    <p>Status: <span style="color: #00cc77;"><?= $_SESSION['role'] === 'admin' ? 'Admin' : 'Mahasiswa' ?></span></p>
</div>

<?php else: ?>
    <div class="alert alert-warning mt-3">Data pengguna tidak ditemukan di database.</div>
<?php endif; ?>
