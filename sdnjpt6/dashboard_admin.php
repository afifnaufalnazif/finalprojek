<?php
session_start();
if ($_SESSION['role'] != 'admin') {
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
    <title>Dashboard Admin</title>
</head>
<body>

<h1>Selamat datang, <?php echo $username; ?>!</h1>
<p><a href="profile.php">Profil</a></p>
<p><a href="add_template.php">Tambahkan Template Sertifikat</a></p>
<p><a href="create_certificate.php">Buat Sertifikat</a></p>
<p><a href="view_certificates_admin.php">Lihat Sertifikat</a></p> <!-- Link diubah agar sesuai -->
<p><a href="logout.php">Logout</a></p>

</body>
</html>