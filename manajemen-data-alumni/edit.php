<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['login']) || $_SESSION['role'] != 'admin' && $_SESSION['role'] != 'superadmin') {
    header("Location: dashboard_user.php");
    exit;
}

$id = $_GET['id'];
$data = mysqli_query($koneksi, "SELECT * FROM alumni WHERE id_alumni='$id'");
$d = mysqli_fetch_array($data);

if (isset($_POST['submit'])) {
    $nama = $_POST['nama'];
    $angkatan = $_POST['angkatan'];
    $jurusan = $_POST['jurusan'];

    mysqli_query($koneksi, "UPDATE alumni SET 
        nama='$nama',
        angkatan='$angkatan',
        jurusan='$jurusan'
        WHERE id_alumni='$id'
    ");

    header("Location: dashboard_admin.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style/edit.css">
</head>
<body>
    <h2>Edit Data</h2>
<form method="POST">
    Nama: <input type="text" name="nama" value="<?= $d['nama'] ?>"><br>
    Angkatan: <input type="text" name="angkatan" value="<?= $d['angkatan'] ?>"><br>
    Jurusan: <input type="text" name="jurusan" value="<?= $d['jurusan'] ?>"><br>
    <button type="submit" name="submit">Update</button>
</form>
</body>
</html>
