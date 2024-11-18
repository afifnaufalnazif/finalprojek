<?php
session_start();
include('db.php');

// Pastikan hanya user yang dapat mengakses halaman ini
if ($_SESSION['role'] != 'user') {
    header("Location: login.php"); // Redirect ke login jika bukan user
    exit;
}

// Ambil ID sertifikat dari query string
if (isset($_GET['id'])) {
    $certificate_id = $_GET['id'];

    // Ambil data sertifikat berdasarkan ID
    $stmt = $pdo->prepare("SELECT * FROM certificates WHERE id = :id AND username = :username");
    $stmt->execute(['id' => $certificate_id, 'username' => $_SESSION['username']]);
    $certificate = $stmt->fetch();

    if ($certificate) {
        // Set header untuk mendownload file PDF
        $file_path = 'certificates/' . $certificate['file_name']; // Pastikan file sertifikat tersimpan di folder 'certificates'
        
        if (file_exists($file_path)) {
            header('Content-Type: application/pdf');
            header('Content-Disposition: attachment; filename="' . basename($file_path) . '"');
            readfile($file_path);
            exit;
        } else {
            echo "File sertifikat tidak ditemukan.";
        }
    } else {
        echo "Sertifikat tidak ditemukan atau Anda tidak memiliki izin untuk mendownloadnya.";
    }
} else {
    echo "ID sertifikat tidak ditemukan.";
}
?>