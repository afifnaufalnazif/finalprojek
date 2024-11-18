<?php
session_start();
include('db.php'); // Menghubungkan ke database

// Pastikan hanya user yang dapat mengakses halaman ini
if ($_SESSION['role'] != 'user') {
    header("Location: login.php");
    exit;
}

// Ambil semua sertifikat
$stmt = $pdo->query("SELECT * FROM certificates");
$certificates = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Sertifikat (User)</title>
</head>
<body>
<h1>Daftar Sertifikat (User)</h1>
<table border="1">
    <tr>
        <th>ID Sertifikat</th>
        <th>Nama Sertifikat</th>
        <th>Nama Penerima</th>
        <th>Template</th>
        <th>Download</th>
    </tr>
    <?php foreach ($certificates as $certificate): ?>
        <tr>
            <td><?php echo $certificate['id']; ?></td>
            <td><?php echo $certificate['certificate_name']; ?></td>
            <td><?php echo $certificate['recipient_name']; ?></td>
            <td><?php echo $certificate['template_name']; ?></td>
            <td><a href="download_certificate.php?id=<?php echo $certificate['id']; ?>">Download</a></td>
        </tr>
    <?php endforeach; ?>
</table>
<p><a href="dashboard_user.php">Kembali ke Dashboard User</a></p>
</body>
</html>