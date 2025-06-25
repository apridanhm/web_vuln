<?php
session_start();
include 'config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = $_POST['username'] ?? '';
    $pass = $_POST['password'] ?? '';

    // VULNERABLE: SQL Injection (hanya pada username)
    $sql = "SELECT * FROM users WHERE username='$user'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        // Cek apakah password disimpan dalam bentuk hash
        if (strlen($row['password']) > 50) {
            // Gunakan password_verify untuk hash
            if (password_verify($pass, $row['password'])) {
                $_SESSION['isLoggedIn'] = true;
                $_SESSION['username']   = $row['username'];
                $_SESSION['user_id']    = $row['id'];
                $_SESSION['role']       = $row['role'];

                header("Location: index.php");
                exit;
            } else {
                $error = "Password salah!";
            }
        } else {
            // Password tidak di-hash
            if ($row['password'] === $pass) {
                $_SESSION['isLoggedIn'] = true;
                $_SESSION['username']   = $row['username'];
                $_SESSION['user_id']    = $row['id'];
                $_SESSION['role']       = $row['role'];

                header("Location: index.php");
                exit;
            } else {
                $error = "Password salah!";
            }
        }
    } else {
        $error = "Username tidak ditemukan!";
    }
}

$page_title = "Login - Web Vuln";
include 'includes/header.php';
?>

<!-- Gambar di atas -->
<div class="text-center mb-3">
    <img src="assets/images/gembok1.png" alt="Gembok" width="150">
</div>

<h2 class="text-center">LOGIN - UNTUK RESPONSI</h2>

<!-- Form Login -->
<div class="row justify-content-center mt-5">
    <div class="col-md-6">
        <div class="form-container">
            <form method="post">
                <div class="mb-3">
                    <input type="text" name="username" class="form-control" placeholder="Username" required>
                </div>
                <div class="mb-3">
                    <input type="password" name="password" class="form-control" placeholder="Password" required>
                </div>
                <div class="d-grid">
                    <button type="submit" class="btn btn-hack">Masuk</button>
                </div>
                <p class="text-center mt-4">Belum punya akun? <a href="register.php">Daftar di sini</a></p>
            </form>

            <?php if (isset($error)): ?>
                <div class="alert alert-danger mt-3"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
