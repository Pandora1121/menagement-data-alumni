<?php
session_start();
include 'koneksi.php';

// cek sudah login atau belum
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}

// ambil role
$role = $_SESSION['role'];

// hanya admin & superadmin yang boleh masuk
if ($role != 'admin' && $role != 'superadmin') {
    header("Location: dashboard_user.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Alumni - IT</title>
    <link rel="stylesheet" href="style/dashboard_superadmin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>

    <aside class="sidebar-aside">
        <div class="brand">
            <div class="brand-logo">IT</div>
            <div class="brand-text">
                <span class="main-title">Telkom</span>
                <span class="sub-title">Information</span>
            </div>
        </div>

        <nav class="side-nav">
            <a href="#"><i class="fa-solid fa-table-cells-large"></i> Dashboard</a>
            <div class="nav-group">
                <a href="#" class="active"><i class="fa-solid fa-user-group"></i> Alumni</a>
                <div class="sub-nav">
                    <a href="#">Basic Info</a>
                    <a href="#" class="active-sub">Alumni Info</a>
                    <a href="#">Professional Info</a>
                    <a href="#">Engagement</a>
                </div>
            </div>
            <a href="#"><i class="fa-solid fa-briefcase"></i> Guru</a>
            <a href="#"><i class="fa-solid fa-calendar-days"></i> Event</a>
            <a href="#"><i class="fa-solid fa-comments"></i> Forum</a>
            <a href="#"><i class="fa-solid fa-folder-open"></i> Resource</a>
            <a href="#"><i class="fa-solid fa-chart-simple"></i> Report</a>
            <a href="#"><i class="fa-solid fa-users"></i> Users</a>
            <a href="#"><i class="fa-solid fa-gear"></i> Settings</a>
        </nav>

        <a href="logout.php" class="logout-link"><i class="fa-solid fa-arrow-right-from-bracket"></i> Log out</a>
    </aside>

    <main class="main-content">
        <header class="main-header">
            <div class="search-global">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text" placeholder="Search something                  Ctrl + K">
            </div>
            <div class="user-meta">
                <div class="theme-toggle"><i class="fa-solid fa-moon"></i></div>
                <div class="user-identity">
                    <img src="https://ui-avatars.com/api/?name=<?= $role ?>&background=4f46e5&color=fff" alt="Avatar" class="user-avatar">
                    <div class="user-text">
                        <span class="user-name">Guru Telkom</span>
                        <span class="user-role"><?= htmlspecialchars($role) ?></span>
                    </div>
                </div>
            </div>
        </header>

        <section class="content-header">
            <div class="breadcrumb">
                <span class="parent">Manage</span>
                <h2 class="current-page">Alumni Information</h2>
                <?php if ($role == 'superadmin') { ?>
                    <small style="color: #4f46e5; font-weight: bold;">Mode Superadmin 🔥</small>
                <?php } ?>
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
                <div class="filter-actions">
                    <select class="select-filter">
                        <option>Filter by Status</option>
                    </select>
                    <button class="btn-export">Export Data <i class="fa-solid fa-download"></i></button>
                    <button class="btn-icon-setting"><i class="fa-solid fa-sliders"></i></button>
                </div>
            </div>

            <table>
                <thead>
                    <tr>
                        <th width="40"><input type="checkbox"></th>
                        <th>No</th>
                        <th>Nama <i class="fa-solid fa-sort"></i></th>
                        <th>Angkatan <i class="fa-solid fa-sort"></i></th>
                        <th>Jurusan <i class="fa-solid fa-sort"></i></th>
                        <th>Status</th>
                        <th class="text-center">Action</th>
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
                        <td><span class="status-badge"><i class="fa-solid fa-check"></i> Saved</span></td>
                        <td class="text-center actions-cell">
                            <a href="#" class="btn-view"><i class="fa-regular fa-eye"></i></a>
                            <a href="edit.php?id=<?= $d['id_alumni'] ?>" class="btn-edit"><i class="fa-regular fa-pen-to-square"></i></a>
                            
                            <?php if ($role == 'superadmin') { ?>
                                <a href="delete.php?id=<?= $d['id_alumni'] ?>" onclick="return confirm('Hapus?')" class="btn-delete"><i class="fa-regular fa-trash-can"></i></a>
                            <?php } ?>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>

            <div class="table-footer">
                <div class="pagination-info">1 - 10 of 100</div>
                <div class="pagination-controls">
                    <span>Rows per page: 10 <i class="fa-solid fa-chevron-down"></i></span>
                    <div class="pager">
                        <button><i class="fa-solid fa-chevron-left"></i></button>
                        <button class="active">1</button>
                        <button>2</button>
                        <button><i class="fa-solid fa-chevron-right"></i></button>
                    </div>
                </div>
            </div>
        </div>

        <footer class="footer">
            <p>&copy; <?= date("Y"); ?> WisnuTriSatria. All Rights Reserved.</p>
        </footer>
    </main>
</nav>

        <a href="logout.php" class="logout-link"><i class="fa-solid fa-arrow-right-from-bracket"></i> Log out</a>
    </aside>
</body>
</html>