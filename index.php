<?php
session_start();
if (!isset($_SESSION['isLoggedIn'])) {
    header("Location: login.php");
    exit;
}

$page_title = "Dashboard - Web Vuln";
include 'includes/header.php';
?>

<div class="text-center">
    <h2 class="mb-3">Welcome, <span class="text-primary"><?= htmlspecialchars($_SESSION['username']); ?></span>!</h2>
    <p class="lead">Pilih aja bebas:</p>
</div>

<div class="row justify-content-center mt-4">
    <div class="col-md-6">
        <h5 style="color:#00ff99;"><i class="fas fa-flask me-2"></i>Modul</h5>
        <div class="list-group">
            <a href="modules/command_injection.php" class="list-group-item list-group-item-action">
                <i class="fas fa-terminal me-2"></i> Command Injection
            </a>
            <a href="modules/file_upload.php" class="list-group-item list-group-item-action">
                <i class="fas fa-upload me-2"></i> File Upload
            </a>
            <a href="modules/brute_force.php" class="list-group-item list-group-item-action">
                <i class="fas fa-lock-open me-2"></i> Brute Force
            </a>
            <a href="modules/file_inclusion.php" class="list-group-item list-group-item-action">
                <i class="fas fa-folder-open me-2"></i> File Inclusion
            </a>
            <a href="modules/find_the_flag.php" class="list-group-item list-group-item-action">
                <i class="fas fa-flag me-2"></i> Capture the Flag
            </a>
            <a href="modules/sql_injection.php" class="list-group-item list-group-item-action">
                <i class="fas fa-database me-2"></i> SQL Injection
            </a>
        </div>

        <div class="mt-4">
            <h5 style="color:#00ff99;"><i class="fas fa-toolbox me-2"></i>Alat Bantu</h5>
            <div class="list-group">
                <a href="modules/base64_tool.php" class="list-group-item list-group-item-action">
                    <i class="fas fa-random me-2"></i> Base64 Encode/Decode
                </a>
            </div>
        </div>


        <?php if ($_SESSION['role'] === 'admin'): ?>
            <div class="mt-4 text-center">
                <a href="admin_panel.php" class="btn btn-outline-warning">
                    <i class="fas fa-user-shield me-1"></i> Panel Admin
                </a>
            </div>
        <?php endif; ?>


        <div class="d-grid mt-3">
            <a href="logout.php" class="btn btn-outline-danger">
                <i class="fas fa-sign-out-alt me-1"></i> Logout
            </a>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
