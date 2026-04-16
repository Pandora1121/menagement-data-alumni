<?php
session_start();
include 'koneksi.php';

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = mysqli_query($koneksi, "SELECT * FROM users WHERE username='$username'");
    $user = mysqli_fetch_assoc($query);

    if ($user) {
        // ✅ pakai perbandingan biasa (karena DB masih plain text)
        if ($password == $user['password']) {
            $_SESSION['login'] = true;
            $_SESSION['id'] = $user['user_id']; // ✅ fix sesuai kolom
            $_SESSION['role'] = $user['role'];

            // redirect sesuai role
            if ($user['role'] == 'superadmin') {
                header("Location: dashboard_superadmin.php");
            } else if ($user['role'] == 'admin') {
                header("Location: dashboard_admin.php");
            } else {
                header("Location: dashboard_user.php");
            }
            exit;
        } else {
            echo "Password salah";
        }
    } else {
        echo "User tidak ditemukan";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style/index.css">
</head>
<body>
    <div style="text-align:center; margin-bottom:15px;">
    <img src="https://cdn-icons-png.flaticon.com/512/5087/5087579.png" width="80">
</div>
    <h2>Login</h2>
<form method="POST">
    Username: <input type="text" name="username" required><br><br>
    Password: <input type="password" name="password" required><br><br>
   <button type="submit" name="login" class="user-profile">
  <div class="user-profile-inner">
    <svg
      aria-hidden="true"
      xmlns="http://www.w3.org/2000/svg"
      viewBox="0 0 24 24"
    >
      <path
        d="m15.626 11.769a6 6 0 1 0 -7.252 0 9.008 9.008 0 0 0 -5.374 8.231 3 3 0 0 0 3 3h12a3 3 0 0 0 3-3 9.008 9.008 0 0 0 -5.374-8.231zm-7.626-4.769a4 4 0 1 1 4 4 4 4 0 0 1 -4-4zm10 14h-12a1 1 0 0 1 -1-1 7 7 0 0 1 14 0 1 1 0 0 1 -1 1z"
      ></path>
    </svg>
    <p>Log In</p>
  </div>
</button>
</form>

</body>
</html>