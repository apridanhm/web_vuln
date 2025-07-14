<?php
session_start();
if (!isset($_SESSION['isLoggedIn'])) {
    header("Location: ../login.php");
    exit;
}

$page_title = "Upload Hasil Responsi";
include '../includes/header.php';

$upload_dir = $_SERVER['DOCUMENT_ROOT'] . "/upload_hasil/";
if (!is_dir($upload_dir)) {
    mkdir($upload_dir, 0755, true);
}

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $file = $_FILES['responsi_file'];
    $allowedExt = ['pdf', 'docx'];
    $filename = basename($file['name']);
    $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

    if (in_array($ext, $allowedExt)) {
        $safeName = $_SESSION['username'] . '_' . time() . '.' . $ext;
        $targetPath = $upload_dir . $safeName;

        if (move_uploaded_file($file['tmp_name'], $targetPath)) {
            $message = "<div class='alert alert-success mt-3 text-center'>Berhasil upload file: <strong>$safeName</strong></div>";
        } else {
            $message = "<div class='alert alert-danger mt-3 text-center'>Gagal upload file. Coba lagi.</div>";
        }
    } else {
        $message = "<div class='alert alert-warning mt-3 text-center'>Hanya file .pdf dan .docx yang diperbolehkan.</div>";
    }
}
?>

<div class="container mt-5">
    <div class="text-center mb-4">
        <h2><i class="fas fa-upload me-2"></i>Upload Hasil Responsi</h2>
        <p>Unggah file dengan format <strong>.pdf</strong> atau <strong>.docx</strong>.</p>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-6">
            <form method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <input type="file" name="responsi_file" class="form-control" accept=".pdf,.docx" required>
                </div>
                <div class="d-grid">
                    <button type="submit" class="btn btn-hack">
                        <i class="fas fa-paper-plane me-1"></i> Upload
                    </button>
                </div>
            </form>

            <?= $message ?>
        </div>
    </div>

    <div class="text-center mt-4">
        <a href="../index.php" class="btn btn-outline-hack">
            <i class="fas fa-home me-1"></i> Kembali ke Dashboard
        </a>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
