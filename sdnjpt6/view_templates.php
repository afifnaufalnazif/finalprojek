<?php
session_start();
include('db.php');  // Menghubungkan dengan database

// Pastikan hanya admin yang dapat mengakses halaman ini
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit;
}

$template_stmt = $pdo->query("SELECT * FROM certificate_templates");
$templates = $template_stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Template Sertifikat</title>
</head>
<body>

<h1>Daftar Template Sertifikat</h1>
<table border="1">
    <tr>
        <th>ID Template</th>
        <th>Nama Template</th>
        <th>File</th>
        <th>Action</th>
    </tr>
    <?php foreach ($templates as $template): ?>
        <tr>
            <td><?php echo $template['id']; ?></td>
            <td><?php echo $template['template_name']; ?></td>
            <td><a href="<?php echo $template['file_path']; ?>" target="_blank">Lihat File</a></td>
            <td><a href="delete_template.php?id=<?php echo $template['id']; ?>">Hapus</a></td>
        </tr>
    <?php endforeach; ?>
</table>

</body>
</html>