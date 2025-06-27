<?php
session_start();
include '../config/db.php';
$page_title = "Modul Brute Force";
include '../includes/header.php';

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input_user = $_POST['username'] ?? '';
    $input_pass = $_POST['password'] ?? '';

    $input_user = mysqli_real_escape_string($conn, $input_user);
    $input_pass = mysqli_real_escape_string($conn, $input_pass);

    $result = mysqli_query($conn, "SELECT * FROM brute_users WHERE username = '$input_user' AND password = '$input_pass'");

    if (mysqli_num_rows($result) === 1) {
        $message = "<div class='alert alert-success text-center' style='background-color:#00ff99; color:#000; font-weight:bold; box-shadow:0 0 10px #00ff99;'>Login berhasil sebagai <strong>" . htmlspecialchars($input_user) . "</strong></div>";
    } else {
        $message = "<div class='alert alert-danger text-center'>Login gagal! Username atau password salah.</div>";
    }
}
?>

<div class="text-center mb-4">
    <h2><i class="fas fa-unlock me-2"></i>Modul Brute Force</h2>
    <p class="lead">Cobalah menebak kombinasi username dan password untuk login!</p>
</div>

<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="form-container p-3 border rounded" style="border:1px solid #00ff99;">
            <form method="post">
                <div class="mb-3">
                    <input type="text" name="username" class="form-control" placeholder="Username" required autofocus>
                </div>
                <div class="mb-3">
                    <input type="password" name="password" class="form-control" placeholder="Password" required>
                </div>
                <div class="d-grid">
                    <button type="submit" class="btn btn-hack">Coba Login</button>
                </div>
            </form>

            <?= $message ?>
        </div>
    </div>
</div>
<div class="mt-4">
    <a href="../index.php" class="btn btn-outline-hack">Kembali ke Home Page</a>
</div>
<?php include '../includes/footer.php'; ?>
