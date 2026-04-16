<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['login']) || $_SESSION['role'] != 'superadmin') {
    header("Location: dashboard_admin.php");
    exit;
}

$id = $_GET['id'];

mysqli_query($koneksi, "DELETE FROM alumni WHERE id_alumni='$id'");

header("Location: dashboard_superadmin.php");
