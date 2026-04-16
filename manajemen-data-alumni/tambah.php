<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}

if (isset($_POST['submit'])) {
    $nama = $_POST['nama'];
    $angkatan = $_POST['angkatan'];
    $jurusan = $_POST['jurusan'];

    mysqli_query($koneksi, "INSERT INTO alumni VALUES ('', '$nama', '$angkatan', '$jurusan')");

    header("Location: dashboard_" . $_SESSION['role'] .".php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style/tambah.css">
</head>
<body>
    <h2>Tambah Data</h2>
<form method="POST">
    Nama: <input type="text" name="nama"><br>
    Angkatan: <input type="text" name="angkatan"><br>
    Jurusan: <input type="text" name="jurusan"><br>
    <button type="submit" name="submit">Simpan</button>
</form>
</body>
</html>