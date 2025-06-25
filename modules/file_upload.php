<?php
session_start();

if (!isset($_SESSION['isLoggedIn'])) {
    header("Location: ../login.php");
    exit;
}

$page_title = "File Upload - Web Vuln";
include '../includes/header.php';

$upload_dir = '../rahasia_negara/raja_jawir/';
$upload_status = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $filename = $_FILES['uploaded_file']['name'];
    $temp_path = $_FILES['uploaded_file']['tmp_name'];
    $destination = $upload_dir . basename($filename);

    if (move_uploaded_file($temp_path, $destination)) {
        $upload_status = "<div class='alert alert-success mt-3'>✅ File berhasil di-upload ke <code>../rahasia_negara/raja_jawir/$filename</code></div>";
    } else {
        $upload_status = "<div class='alert alert-danger mt-3'>❌ Upload gagal.</div>";
    }
}
?>
 
 <h2 class="text-center">
    <i class="fas fa-file-upload me-2"></i>Modul File Upload
</h2>

<p class="text-center">Silahkan upload file ente di sini</p>

<div class="row justify-content-center mt-4">
    <div class="col-md-6">
        <form method="post" enctype="multipart/form-data" class="border p-4 shadow rounded">
            <div class="mb-3">
                <label for="uploaded_file" class="form-label">Pilih file:</label>
                <input type="file" name="uploaded_file" id="uploaded_file" class="form-control" required>
            </div>
            <div class="d-grid">
            <button type="submit" class="btn btn-hack">
                <i class="fas fa-rocket me-1"></i> Upload
            </button>
            </div>
        </form>
        <?= $upload_status ?>
    </div>
</div>


<div class="mt-4">
    <a href="../index.php" class="btn btn-outline-hack">Kembali ke Home Page</a>
</div>

<?php include '../includes/footer.php'; ?>
