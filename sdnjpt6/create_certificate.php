<?php
session_start();
include('db.php'); // Menyertakan koneksi database

// Pastikan admin dapat mengakses halaman ini
if ($_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari form
    $template_id = $_POST['template_id'];
    $certificate_name = $_POST['certificate_name'];
    $recipient_name = $_POST['recipient_name'];

    // Simpan sertifikat ke dalam database
    $stmt = $pdo->prepare("INSERT INTO certificates (certificate_name, recipient_name, template_id) VALUES (?, ?, ?)");
    $stmt->execute([$certificate_name, $recipient_name, $template_id]);

    echo "Sertifikat berhasil dibuat!<br><a href='view_certificates.php'>Lihat Sertifikat</a>";
} else {
    // Ambil semua template dari database
    $stmt = $pdo->query("SELECT * FROM certificate_templates");
    $templates = $stmt->fetchAll();
    ?>

    <form method="POST">
        <label for="template_id">Pilih Template:</label>
        <select id="template_id" name="template_id" required>
            <?php foreach ($templates as $template): ?>
                <option value="<?php echo $template['id']; ?>"><?php echo $template['template_name']; ?></option>
            <?php endforeach; ?>
        </select><br><br>

        <label for="certificate_name">Nama Sertifikat:</label>
        <input type="text" id="certificate_name" name="certificate_name" required><br><br>

        <label for="recipient_name">Nama Penerima:</label>
        <input type="text" id="recipient_name" name="recipient_name" required><br><br>

        <button type="submit">Buat Sertifikat</button>
    </form>

    <?php
}
?>