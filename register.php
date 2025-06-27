<?php
session_start();
include 'config/db.php';

$page_title = "Register Mahasiswa";
$error = "";
$success = "";

// Proses registrasi
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nim      = $_POST['nim'] ?? '';
    $nama     = $_POST['nama'] ?? '';
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if (empty($nim) || empty($nama) || empty($username) || empty($password)) {
        $error = "Semua kolom wajib diisi.";
    } else {
        $nim      = mysqli_real_escape_string($conn, $nim);
        $nama     = mysqli_real_escape_string($conn, $nama);
        $username = mysqli_real_escape_string($conn, $username);
        $hash     = password_hash($password, PASSWORD_DEFAULT);

        $check = mysqli_query($conn, "SELECT * FROM users WHERE username='$username' OR nim='$nim'");
        if (mysqli_num_rows($check) > 0) {
            $error = "NIM atau Username sudah digunakan.";
        } else {
            $query = "INSERT INTO users (nim, nama, username, password, role) 
                      VALUES ('$nim', '$nama', '$username', '$hash', 'user')";
            if (mysqli_query($conn, $query)) {
                $success = "Registrasi berhasil! kamu akan diarahkan ke halaman login...";
                // Redirect setelah 10 detik
                header("refresh:10;url=login.php");
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
                <div class="alert alert-danger mt-3 text-center">
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php elseif ($success): ?>
                <div id="successAlert" class="alert alert-success mt-3 text-center"
                    style="background-color:#00ff99; color:#000; font-weight:bold; border: 1px solid #00ff99; box-shadow: 0 0 10px #00ff99;">
                    <?= htmlspecialchars($success) ?> <br>
                    Mengalihkan ke halaman login dalam <span id="countdown">10</span> detik...
                </div>

                <script>
                    let seconds = 10;
                    const countdownEl = document.getElementById('countdown');

                    const timer = setInterval(() => {
                        seconds--;
                        countdownEl.textContent = seconds;
                        if (seconds <= 0) {
                            clearInterval(timer);
                            window.location.href = "login.php";
                        }
                    }, 1000);
                </script>

            <?php endif; ?>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
