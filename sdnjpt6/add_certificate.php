<?php
session_start();
include('db.php');  // Menghubungkan dengan database

// Pastikan hanya admin yang dapat mengakses halaman ini
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit;
}

// Proses menambah sertifikat
if (isset($_POST['add_certificate'])) {
    $certificate_name = $_POST['certificate_name'];
    $template_id = $_POST['template_id'];
    
    // Ambil template berdasarkan template_id
    $stmt = $pdo->prepare("SELECT * FROM certificate_templates WHERE id = :template_id");
    $stmt->execute(['template_id' => $template_id]);
    $template = $stmt->fetch();
    
    // Buat sertifikat dengan konten template
    $certificate_content = $template['template_content'];  // Misalnya, Anda bisa mengubah konten di sini jika perlu
    $stmt = $pdo->prepare("INSERT INTO certificates (certificate_name, certificate_content) VALUES (:certificate_name, :certificate_content)");
    $stmt->execute([
        'certificate_name' => $certificate_name,
        'certificate_content' => $certificate_content
    ]);
    echo "Sertifikat berhasil dibuat!";
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Sertifikat</title>
</head>
<body>

<h1>Tambah Sertifikat</h1>
<form action="" method="post">
    <label for="certificate_name">Nama Sertifikat:</label><br>
    <input type="text" name="certificate_name" id="certificate_name" required><br><br>
    
    <label for="template_id">Pilih Template:</label><br>
    <select name="template_id" id="template_id" required>
        <?php
        // Ambil semua template dari database
        $stmt = $pdo->query("SELECT * FROM certificate_templates");
        while ($row = $stmt->fetch()) {
            echo "<option value='".$row['id']."'>".$row['template_name']."</option>";
        }
        ?>
    </select><br><br>
    
    <input type="submit" name="add_certificate" value="Tambah Sertifikat">
</form>

</body>
</html>