<?php
session_start();
include 'config/db.php';

$page_title = "Register Mahasiswa";
$success = "";
$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nim      = $_POST['nim'] ?? '';
    $nama     = $_POST['nama'] ?? '';
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // Validasi singkat
    if (empty($nim) || empty($nama) || empty($username) || empty($password)) {
        $error = "Semua kolom wajib diisi.";
    } else {
        $nim      = mysqli_real_escape_string($conn, $nim);
        $nama     = mysqli_real_escape_string($conn, $nama);
        $username = mysqli_real_escape_string($conn, $username);
        $hash     = password_hash($password, PASSWORD_DEFAULT);

        // Cek apakah username atau NIM sudah ada
        $check = mysqli_query($conn, "SELECT * FROM users WHERE username='$username' OR nim='$nim'");
        if (mysqli_num_rows($check) > 0) {
            $error = "NIM atau Username sudah digunakan.";
        } else {
            $query = "INSERT INTO users (nim, nama, username, password, role) 
                      VALUES ('$nim', '$nama', '$username', '$hash', 'user')";
            if (mysqli_query($conn, $query)) {
                $success = "Registrasi berhasil. Silakan login.";
            } else {
                $error = "Registrasi gagal: " . mysqli_error($conn);
            }
        }
    }
}

include 'includes/header.php';
?>

<div class="text-center mb-3">
    <h2>📝 Registrasi Mahasiswa</h2>
</div>

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="form-container">
            <form method="post">
                <div class="mb-3">
                    <input type="text" name="nim" class="form-control" placeholder="NIM" required>
                </div>
                <div class="mb-3">
                    <input type="text" name="nama" class="form-control" placeholder="Nama Lengkap" required>
                </div>
                <div class="mb-3">
                    <input type="text" name="username" class="form-control" placeholder="Username" required>
                </div>
                <div class="mb-3">
                    <input type="password" name="password" class="form-control" placeholder="Password" required>
                </div>
                <div class="d-grid">
                    <button type="submit" class="btn btn-hack">Daftar</button>
                </div>
            </form>

            <?php if ($error): ?>
                <div class="alert alert-danger mt-3"><?php echo htmlspecialchars($error); ?></div>
            <?php elseif ($success): ?>
                <div class="alert alert-success mt-3"><?php echo htmlspecialchars($success); ?></div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
