<?php
session_start();
include('db.php');  // Menyertakan koneksi database

// Pastikan hanya admin yang dapat mengakses halaman ini
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit;
}

// Ambil daftar sertifikat
$stmt = $pdo->query("SELECT * FROM certificates");
$certificates = $stmt->fetchAll();

// Hapus sertifikat jika permintaan dikirim
if (isset($_POST['delete'])) {
    $certificate_id = $_POST['certificate_id'];
    $deleteStmt = $pdo->prepare("DELETE FROM certificates WHERE id = :id");
    $deleteStmt->execute(['id' => $certificate_id]);
    echo "Sertifikat berhasil dihapus!";
    header("Location: delete_certificate.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hapus Sertifikat</title>
</head>
<body>

<h1>Hapus Sertifikat</h1>
<table border="1">
    <tr>
        <th>ID Sertifikat</th>
        <th>Nama Sertifikat</th>
        <th>Penerima</th>
        <th>Aksi</th>
    </tr>
    <?php foreach ($certificates as $certificate): ?>
        <tr>
            <td><?php echo $certificate['id']; ?></td>
            <td><?php echo $certificate['certificate_name']; ?></td>
            <td><?php echo $certificate['recipient_name']; ?></td>
            <td>
                <form method="post" action="">
                    <input type="hidden" name="certificate_id" value="<?php echo $certificate['id']; ?>">
                    <button type="submit" name="delete">Hapus</button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

<p><a href="dashboard_admin.php">Kembali ke Dashboard Admin</a></p>

</body>
</html>