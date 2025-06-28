<?php
session_start();
$page_title = "Base64 Encode & Decode";
include '../includes/header.php';

$input = $_POST['input'] ?? '';
$mode = $_POST['mode'] ?? '';
$result = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($mode === 'encode') {
        $result = base64_encode($input);
    } elseif ($mode === 'decode') {
        $result = base64_decode($input);
    } else {
        $result = 'Mode tidak dikenali.';
    }
}
?>

<div class="text-center mb-4">
    <h2><i class="fas fa-code me-2"></i>Base64 Encode & Decode</h2>
    <p class="lead">Gunakan alat ini untuk meng-encode atau decode teks dalam format Base64.</p>
</div>

<div class="row justify-content-center">
    <div class="col-md-8">
        <form method="post" class="mb-4">
            <div class="mb-3">
                <label class="form-label">Teks:</label>
                <textarea name="input" class="form-control" rows="4" placeholder="Masukkan teks di sini"><?= htmlspecialchars($input) ?></textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Mode:</label>
                <select name="mode" class="form-select">
                    <option value="encode" <?= $mode === 'encode' ? 'selected' : '' ?>>Encode (→ Base64)</option>
                    <option value="decode" <?= $mode === 'decode' ? 'selected' : '' ?>>Decode (← Base64)</option>
                </select>
            </div>
            <div class="d-grid">
                <button type="submit" class="btn btn-hack">Proses</button>
            </div>
        </form>

        <?php if ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
            <div class="alert alert-success mt-3 text-center" style="background-color:#00ff99; color:#000; font-weight:bold; border: 1px solid #00ff99; box-shadow: 0 0 10px #00ff99;">
                <strong>Hasil:</strong><br>
                <code><?= htmlspecialchars($result) ?></code>
            </div>
        <?php endif; ?>
    </div>
</div>

<div class="mt-4 text-center">
    <a href="../index.php" class="btn btn-outline-hack">Kembali ke Home</a>
</div>

<?php include '../includes/footer.php'; ?>
