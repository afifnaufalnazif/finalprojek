<?php
session_start();
include('db.php');

// Pastikan hanya admin yang bisa mengakses halaman ini
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit;
}

// Logika untuk menambahkan template ke database
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $template_name = $_POST['template_name'];
    $template_content = $_POST['template_content'];

    $stmt = $pdo->prepare("INSERT INTO certificate_templates (template_name, template_content) VALUES (:template_name, :template_content)");
    $stmt->execute([
        'template_name' => $template_name,
        'template_content' => $template_content
    ]);

    echo "Template berhasil ditambahkan!";
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Template Sertifikat</title>
</head>
<body>

<h1>Tambah Template Sertifikat</h1>
<form method="post" action="">
    <label>Nama Template:</label><br>
    <input type="text" name="template_name" required><br><br>
    <label>Konten Template:</label><br>
    <textarea name="template_content" rows="10" cols="30" required></textarea><br><br>
    <button type="submit">Tambahkan Template</button>
</form>

<!-- Opsi kembali ke dashboard admin -->
<p><a href="dashboard_admin.php">Kembali ke Dashboard Admin</a></p>

</body>
</html>