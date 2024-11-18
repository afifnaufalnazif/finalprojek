<?php
session_start();
include('db.php'); // Menyertakan koneksi database

// Pastikan hanya admin yang dapat mengakses halaman ini
if ($_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit;
}

$username = $_SESSION['username'];  // Ambil username dari session

// Ambil data profil admin dari database
$stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username AND role = 'admin'");
$stmt->execute(['username' => $username]);
$admin = $stmt->fetch();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Admin</title>
</head>
<body>

<h1>Profil Admin</h1>

<p><strong>Username:</strong> <?php echo $admin['username']; ?></p>
<p><strong>Email:</strong> <?php echo $admin['email']; ?></p>
<!-- Anda bisa menambahkan data lain sesuai kebutuhan -->

<!-- Opsi untuk kembali ke Dashboard Admin -->
<p><a href="dashboard_admin.php">Kembali ke Dashboard Admin</a></p>

</body>
</html>