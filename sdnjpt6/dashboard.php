<?php
session_start();
include('db.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if ($_SESSION['role'] == 'admin') {
    // Dashboard untuk Admin
    echo "Selamat datang, Admin!<br>";
    echo "<a href='create_template.php'>Buat Template Sertifikat</a><br>";
    echo "<a href='manage_certificates.php'>Kelola Sertifikat</a><br>";
    echo "<a href='view_certificates.php'>Lihat Sertifikat</a><br>";
} else {
    // Dashboard untuk User
    echo "Selamat datang, User!<br>";
    echo "<a href='view_certificates.php'>Lihat Sertifikat</a><br>";
}
?>