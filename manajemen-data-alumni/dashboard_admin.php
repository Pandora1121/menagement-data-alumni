<?php
session_start();
include 'koneksi.php';

// Cek login
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}

// Ambil role & inisial (untuk avatar kotak biru)
$role = $_SESSION['role'];
$username = $_SESSION['username'] ?? "Admin"; // Default ke Admin jika session kosong
$initials = strtoupper(substr($username, 0, 2));

// Proteksi halaman: Admin dan Superadmin boleh masuk, tapi tampilan ini diset untuk Admin
if ($role != 'admin' && $role != 'superadmin') {
    header("Location: dashboard_user.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | Educational Info</title>
    <link rel="stylesheet" href="style/dashboard_superadmin.css">
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
            <a href="#"><i class="fa-solid fa-house"></i> Dashboard</a>
            
            <div class="nav-group">
                <a href="#" class="active"><i class="fa-solid fa-user-graduate"></i> Alumni</a>
                <div class="sub-nav">
                    <a href="#">Basic Info</a>
                    <a href="#" class="active-sub">Alumni Info</a>
                    <a href="#">Professional Info</a>
                </div>
            </div>
            
            <a href="#"><i class="fa-solid fa-briefcase"></i> Guru</a>
            <a href="#"><i class="fa-solid fa-calendar-event"></i> Event</a>
            <a href="#"><i class="fa-solid fa-gear"></i> Settings</a>
        </nav>

        <a href="logout.php" class="logout-link" onclick="return confirm('Apakah Anda yakin ingin keluar?')">
            <i class="fa-solid fa-right-from-bracket"></i> Log out
        </a>
    </aside>

    <main class="main-content">
        
        <header class="main-header">
            <div class="search-global">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text" placeholder="Search data alumni...      Ctrl + K">
            </div>

            <div class="user-meta">
                <div class="theme-toggle"><i class="fa-solid fa-moon"></i></div>
                <div class="user-identity">
                    <div class="user-text">
                        <span class="user-name"><?= htmlspecialchars($username) ?></span>
                        <span class="user-role"><?= htmlspecialchars($role) ?></span>
                    </div>
                    <div class="avatar-box"><?= $initials ?></div>
                </div>
            </div>
        </header>

        <section class="content-header">
            <div class="breadcrumb">
                <span class="parent">Manage</span>
                <h2>Alumni Information</h2>
            </div>
            <div class="header-btns">
                <button class="btn-secondary"><i class="fa-solid fa-file-csv"></i> Import CSV</button>
                <a href="tambah.php" class="btn-primary"><i class="fa-solid fa-plus"></i> Add Alumni</a>
            </div>
        </section>

        <div class="data-card">
            <div class="table-tools">
                <div class="search-table">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text" placeholder="Search in educational table">
                </div>
            </div>

            <table>
                <thead>
                    <tr>
                        <th width="40"><input type="checkbox"></th>
                        <th>No</th>
                        <th>Nama Alumni</th>
                        <th>Angkatan</th>
                        <th>Jurusan</th>
                        <th>Status</th>
                        <th style="text-align: center;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    $data = mysqli_query($koneksi, "SELECT * FROM alumni");
                    while ($d = mysqli_fetch_assoc($data)) {
                    ?>
                    <tr>
                        <td><input type="checkbox"></td>
                        <td><?= $no++ ?></td>
                        <td class="text-bold"><?= htmlspecialchars($d['nama']) ?></td>
                        <td><?= htmlspecialchars($d['angkatan']) ?></td>
                        <td><?= htmlspecialchars($d['jurusan']) ?></td>
                        <td>
                            <span class="status-badge">
                                <i class="fa-solid fa-check-double"></i> Saved
                            </span>
                        </td>
                        <td style="text-align: center;" class="actions-cell">
                            <a href="#" class="btn-view" title="View"><i class="fa-regular fa-eye"></i></a>
                            <a href="edit.php?id=<?= $d['id_alumni'] ?>" class="btn-edit" title="Edit"><i class="fa-regular fa-pen-to-square"></i></a>
                            </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>

            <div class="table-footer">
                <div class="pagination-info">Showing <?= mysqli_num_rows($data) ?> alumni</div>
                <div class="pagination-controls">
                    <div class="rows-per-page">
                        Rows per page: <b>10</b> <i class="fa-solid fa-chevron-down"></i>
                    </div>
                    <div class="page-numbers">
                        <button><i class="fa-solid fa-chevron-left"></i></button>
                        <button class="active">1</button>
                        <button><i class="fa-solid fa-chevron-right"></i></button>
                    </div>
                </div>
            </div>
        </div>

        <footer class="footer">
            <p>&copy; <?= date("Y"); ?> WisnuTriSatria. All Rights Reserved.</p>
        </footer>
    </main>

</body>
</html>