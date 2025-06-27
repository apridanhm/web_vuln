<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($_SESSION['isLoggedIn'])) {
    header("Location: ../login.php");
    exit;
}

$page_title = "SQL Injection";
include '../includes/header.php';

// Gunakan koneksi database khusus SQL Injection
include '../config/db_sqlinject.php';

$output = '';
$username = '';
$rows = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];

    // 🔥 VULNERABLE QUERY - UNTUK PEMBELAJARAN SAJA!
    $query = "SELECT id, username FROM users WHERE username = '$username'";

    // Jalankan multi_query agar bisa eksekusi payload kompleks
    if ($conn->multi_query($query)) {
        do {
            if ($result = $conn->store_result()) {
                while ($row = $result->fetch_assoc()) {
                    $rows[] = $row;
                }
                $result->free();
            }
        } while ($conn->next_result());
    } else {
        $output = "<strong>Query SQL Error:</strong><br>";
        $output .= "<code>" . htmlspecialchars($conn->error) . "</code>";
    }
}
?>

<h2><i class="fas fa-database me-2"></i> SQL Injection</h2>
<p class="lead">Latihan eksploitasi kerentanan SQL Injection.</p>
<p>
    <strong><i class="fas fa-exclamation-triangle text-warning me-2"></i> Tantangan:</strong>
    Coba eksploitasi form ini untuk melakukan SQL injection dan ambil informasi sensitif.
</p>

<form method="post" class="mb-4">
    <div class="mb-3">
        <input type="text" name="username" class="form-control" value="<?= htmlspecialchars($username) ?>" placeholder="Masukkan username">
    </div>
    <div class="d-grid">
        <button type="submit" class="btn btn-hack">Submit</button>
    </div>
</form>

<?php if (!empty($rows)): ?>
    <h5><i class="fas fa-table me-2"></i> Hasil Query:</h5>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>ID</th>
            <th>Username</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($rows as $row): ?>
            <tr>
                <td><?= htmlspecialchars($row['id']) ?></td>
                <td><?= htmlspecialchars($row['username']) ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php elseif (!empty($output)): ?>
    <div class="alert alert-danger">
        <?= $output ?>
    </div>
<?php endif; ?>

<div class="mt-4">
    <strong><i class="fas fa-user-secret text-info me-2"></i> Petunjuk:</strong>
    <ul>
        <li>Coba input seperti: <code>OR </code></li>
        <li>Gunakan <code>UNION SELECT</code> untuk ambil data lain</li>
        <li>Pakai <code>SLEEP()</code> untuk blind SQL injection</li>
        <li>Tambahkan <code>--</code> atau <code>#</code> untuk comment akhir</li>
    </ul>
</div>

<div class="mt-4">
    <a href="../index.php" class="btn btn-outline-hack">Kembali ke Home Page</a>
</div>

<?php include '../includes/footer.php'; ?>