<?php
session_start();
include 'koneksi.php';

// Cek login
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}

// Proteksi: Jika bukan user (admin/superadmin), arahkan ke dashboard admin
if ($_SESSION['role'] != 'user') {
    header("Location: dashboard_admin.php");
    exit;
}

$role = $_SESSION['role'];
$username = $_SESSION['username'] ?? "User";
$initials = strtoupper(substr($username, 0, 2));
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard | Alumni IT</title>
    <link rel="stylesheet" href="style/dashboard_user.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

    <aside class="sidebar-aside">
        <div class="brand">
            <div class="brand-logo">IT</div>
            <div class="brand-text">
                <span class="main-title">INFORMATION</span>
                <span class="sub-title">Alumni</span>
            </div>
        </div>

        <nav class="side-nav">
            <a href="#" class="active"><i class="fa-solid fa-house"></i> Dashboard</a>
            <a href="#"><i class="fa-solid fa-user-graduate"></i> Directory Alumni</a>
            <a href="#"><i class="fa-solid fa-briefcase"></i> Job Board</a>
            <a href="#"><i class="fa-solid fa-calendar-event"></i> Event List</a>
        </nav>

        <a href="logout.php" class="logout-link" onclick="return confirm('Ingin keluar dari dashboard?')">
            <i class="fa-solid fa-right-from-bracket"></i> Log out
        </a>
    </aside>

    <main class="main-content">
        
        <header class="main-header">
            <div class="search-global">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text" placeholder="Cari nama alumni...">
            </div>

            <div class="user-meta">
                <div class="theme-toggle"><i class="fa-solid fa-moon"></i></div>
                <div class="user-identity">
                    <div class="user-text">
                        <span class="user-name"><?= htmlspecialchars($username) ?></span>
                        <span class="user-role">Member</span>
                    </div>
                    <div class="avatar-box" style="background: #10b981;"><?= $initials ?></div>
                </div>
            </div>
        </header>

        <section class="content-header">
            <div class="breadcrumb">
                <span class="parent">View Only</span>
                <h2>Directory Alumni</h2>
            </div>
            </section>

        <div class="data-card">
            <div class="table-tools">
                <div class="search-table">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text" placeholder="Filter data...">
                </div>
            </div>

            <table>
                <thead>
                    <tr>
                        <th width="50">No</th>
                        <th>Nama Alumni</th>
                        <th>Angkatan</th>
                        <th>Jurusan</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    $data = mysqli_query($koneksi, "SELECT * FROM alumni");
                    while ($d = mysqli_fetch_array($data)) {
                    ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td class="text-bold"><?= htmlspecialchars($d['nama']) ?></td>
                        <td><?= htmlspecialchars($d['angkatan']) ?></td>
                        <td><?= htmlspecialchars($d['jurusan']) ?></td>
                        <td>
                            <span class="status-badge">
                                <i class="fa-solid fa-user-check"></i> Aktif
                            </span>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>

            <div class="table-footer">
                <div class="pagination-info">Menampilkan data alumni terbaru</div>
            </div>
        </div>

        <footer class="footer">
            <p>&copy; <?= date("Y"); ?> WisnuTriSatria. All Rights Reserved.</p>
        </footer>
    </main>

</body>
</html>