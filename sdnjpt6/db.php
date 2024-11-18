<?php
$host = 'localhost'; // Nama host
$dbname = 'sdntjp6'; // Nama database
$username = 'root'; // Username database
$password = ''; // Password database

try {
    // Membuat koneksi ke database menggunakan PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Koneksi gagal: " . $e->getMessage());
}
?>