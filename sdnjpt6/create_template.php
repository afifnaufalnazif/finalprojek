<?php
session_start();
include('db.php'); // Menyertakan koneksi database

// Pastikan admin dapat mengakses halaman ini
if ($_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data template dari form
    $template_name = $_POST['template_name'];
    $template_description = $_POST['template_description'];

    // Simpan template ke dalam database
    $stmt = $pdo->prepare("INSERT INTO certificate_templates (template_name, template_description) VALUES (?, ?)");
    $stmt->execute([$template_name, $template_description]);

    echo "Template berhasil ditambahkan!<br><a href='create_certificate.php'>Buat Sertifikat</a>";
} else {
    ?>
    <form method="POST">
        <label for="template_name">Nama Template:</label>
        <input type="text" id="template_name" name="template_name" required><br><br>

        <label for="template_description">Deskripsi Template:</label>
        <textarea id="template_description" name="template_description" required></textarea><br><br>

        <button type="submit">Tambahkan Template</button>
    </form>
    <?php
}
?>