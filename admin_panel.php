<?php
session_start();
include 'config/db.php';

if (!isset($_SESSION['isLoggedIn']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

header("Refresh: 2"); // Auto-refresh setiap 2 detik

$page_title = "Admin Panel";
include 'includes/header.php';

// Hapus semua log jika diminta
if (isset($_POST['clear_logs']) && $_SESSION['role'] === 'admin') {
    mysqli_query($conn, "DELETE FROM user_logs");
    header("Location: admin_panel.php");
    exit;
}

// Ambil semua user
$users = mysqli_query($conn, "SELECT * FROM users");

// Ambil 3 user teraktif (kecuali admin)
$aktif = mysqli_query($conn, "
    SELECT u.username, COUNT(*) AS total
    FROM user_logs l
    JOIN users u ON u.id = l.user_id
    WHERE u.role != 'admin'
    GROUP BY u.id
    ORDER BY total DESC
    LIMIT 3
");

// Ambil log aktivitas terbaru (kecuali admin)
$logs = mysqli_query($conn, "
    SELECT u.username, l.endpoint, l.access_time
    FROM user_logs l
    JOIN users u ON u.id = l.user_id
    WHERE u.role != 'admin'
    ORDER BY l.access_time DESC
    LIMIT 50
");

// 3 endpoint paling sering diakses (kecuali admin dan index.php)
$endpoints_terbanyak = mysqli_query($conn, "
    SELECT endpoint, COUNT(*) AS total
    FROM user_logs l
    JOIN users u ON u.id = l.user_id
    WHERE u.role != 'admin' AND endpoint NOT LIKE '%index.php%'
    GROUP BY endpoint
    ORDER BY total DESC
    LIMIT 3
");

// 3 endpoint paling jarang diakses (kecuali admin dan index.php)
$endpoints_terjarang = mysqli_query($conn, "
    SELECT endpoint, COUNT(*) AS total
    FROM user_logs l
    JOIN users u ON u.id = l.user_id
    WHERE u.role != 'admin' AND endpoint NOT LIKE '%index.php%'
    GROUP BY endpoint
    ORDER BY total ASC
    LIMIT 3
");


?>
<main>
<h2 class="mb-4 text-left"><i class="fas fa-user-shield me-2"></i>Panel Admin</h2>
<!-- Bagian: 3 User Teraktif -->
<div class="mb-4">
    <h4 class="text-center"><i class="fas fa-medal me-2"></i>3 User Teraktif</h4>
    <?php if (mysqli_num_rows($aktif) > 0): ?>
        <div class="mx-auto" style="max-width: 500px;">
            <ol class="list-group list-group-numbered">
                <?php while ($row = mysqli_fetch_assoc($aktif)): ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span><?= htmlspecialchars($row['username']) ?></span>
                        <span class="badge bg-primary rounded-pill"><?= $row['total'] ?> hit</span>
                    </li>
                <?php endwhile; ?>
            </ol>
        </div>
    <?php else: ?>
        <p>Tidak ada data aktivitas.</p>
    <?php endif; ?>
</div>

<br>

<!-- Statistik Endpoint -->
<div class="mb-4">
    <h4 class="text-left"><i class="fas fa-chart-bar me-2"></i>Statistik Endpoint</h4>
    <div class="row">
        <div class="col-md-6">
            <h6><i class="fas fa-arrow-up me-1"></i> Endpoint Paling Sering Diakses</h6>
            <ul class="list-group">
                <?php while ($row = mysqli_fetch_assoc($endpoints_terbanyak)): ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <?= htmlspecialchars($row['endpoint']) ?>
                        <span class="badge bg-success"><?= $row['total'] ?> hit</span>
                    </li>
                <?php endwhile; ?>
            </ul>
        </div>
        <div class="col-md-6">
            <h6><i class="fas fa-arrow-down text-danger me-1"></i> Endpoint Paling Jarang Diakses</h6>
            <ul class="list-group">
                <?php while ($row = mysqli_fetch_assoc($endpoints_terjarang)): ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <?= htmlspecialchars($row['endpoint']) ?>
                        <span class="badge bg-secondary"><?= $row['total'] ?> hit</span>
                    </li>
                <?php endwhile; ?>
            </ul>
        </div>
    </div>
</div>


<!-- Bagian: Log Aktivitas -->
<div class="mb-4">
    <h4 class="text-left"><i class="fas fa-history me-2"></i>Log Aktivitas Terkini</h4>
    <div style="max-height: 300px; overflow-y: auto;">
        <table class="table table-dark table-striped table-sm mb-0">
            <thead>
                <tr>
                    <th>Username</th>
                    <th>Endpoint</th>
                    <th>Waktu</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($log = mysqli_fetch_assoc($logs)): ?>
                    <tr>
                        <td><?= htmlspecialchars($log['username']) ?></td>
                        <td><?= htmlspecialchars($log['endpoint']) ?></td>
                        <td><?= $log['access_time'] ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Bagian: Daftar Semua User -->
<div class="mb-4">
    <h4 class="text-left"><i class="fas fa-users me-2"></i>Daftar Semua User</h4>
    <div style="max-height: 300px; overflow-y: auto;">
        <ul class="list-group mb-0">
            <?php while ($u = mysqli_fetch_assoc($users)): ?>
                <li class="list-group-item">
                    <?= htmlspecialchars($u['username']) ?> (<?= $u['role'] ?>)
                </li>
            <?php endwhile; ?>
        </ul>
    </div>
</div>


</main>


<br><br>
<!-- Tombol Admin Aksi -->
<div class="container mt-auto">
    <div class="row text-center mb-4">
        <div class="col-md-4 mb-2">
            <form method="post">
                <button type="submit" name="clear_logs" class="btn btn-outline-danger w-100">
                    <i class="fas fa-trash-alt me-1"></i> Hapus Semua Log
                </button>
            </form>
        </div>

        <div class="col-md-4 mb-2">
            <a href="index.php" class="btn btn-secondary w-100">
                <i class="fas fa-home me-1"></i> Kembali ke Dashboard
            </a>
        </div>

        <div class="col-md-4 mb-2">
            <a href="logout.php" class="btn btn-outline-warning w-100">
                <i class="fas fa-sign-out-alt me-1"></i> Logout
            </a>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
