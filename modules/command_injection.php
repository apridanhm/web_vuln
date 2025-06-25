<?php
session_start();
if (!isset($_SESSION['isLoggedIn'])) {
    header("Location: ../login.php");
    exit;
}

$page_title = "Command Injection";
include '../includes/header.php';

$output = '';
$flag_hint = "Cari file tersembunyi di server melalui command injection untuk menemukan flag!";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $host = $_POST['host'] ?? '';
    // VULNERABLE: input langsung digunakan dalam shell_exec tanpa sanitasi
    $output = shell_exec("ping -c 1 $host 2>&1");
}
?>

<h2><i class="fas fa-terminal me-2"></i>Command Injection</h2>
<p class="lead">Masukkan IP atau hostname untuk melakukan <code>ping</code>.</p>
<p>
    <strong><i class="fas fa-exclamation-triangle text-warning me-2"></i> Tantangan:</strong>
    Cobalah eksploitasi command injection untuk menemukan file berisi flag atau expore yang lainnya!
</p>


<form method="post" class="mb-4">
    <div class="mb-3">
        <input type="text" name="host" class="form-control" placeholder="contoh: 8.8.8.8; ls /">
    </div>
    <div class="d-grid">
        <button type="submit" class="btn btn-hack">Ping Target</button>
    </div>
</form>

<?php if (!empty($output)): ?>
    <h5><i class="fas fa-terminal me-2"></i> Output:</h5>
    <div class="terminal-output"><?php echo htmlspecialchars($output); ?></div>
<?php endif; ?>

<div class="mt-4">
    <strong><i class="fas fa-user-secret text-info me-2"></i> Petunjuk:</strong>
    <ul>
        <li>Gunakan <code>;</code> atau <code>&&</code> untuk menambahkan perintah shell.</li>
    </ul>
</div>

<div class="mt-4">
    <a href="../index.php" class="btn btn-outline-hack">Kembali ke Home Page</a>
</div>

<?php include '../includes/footer.php'; ?>
