<?php
session_start();
include('db.php'); // Menghubungkan dengan database

// Pastikan hanya user yang dapat mengakses halaman ini
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'user') {
    header("Location: login.php");
    exit;
}

$username = $_SESSION['username']; // Ambil username dari sesi

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard User</title>
</head>
<body>

<h1>Selamat datang, <?php echo $username; ?>!</h1>
<p><a href="profile.php">Profil</a> | <a href="view_certificates_user.php">Lihat Sertifikat</a> | <a href="logout.php">Logout</a></p>

</body>
</html>