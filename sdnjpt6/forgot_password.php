<?php
session_start();
include('db.php'); // Menyertakan koneksi ke database

// Cek apakah form sudah disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];

    // Validasi email
    if (empty($email)) {
        $error = "Email tidak boleh kosong.";
    } else {
        // Cek apakah email terdaftar di database
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch();

        if ($user) {
            // Membuat token reset password yang unik
            $token = bin2hex(random_bytes(50));
            $expiry = time() + 3600; // Link reset expired dalam 1 jam

            // Menyimpan token dan waktu expired di database
            $stmt = $pdo->prepare("UPDATE users SET reset_token = :token, reset_expiry = :expiry WHERE email = :email");
            $stmt->execute(['token' => $token, 'expiry' => $expiry, 'email' => $email]);

            // Kirim email berisi link reset password
            $resetLink = "http://localhost/sdnjpt6/reset_password.php?token=$token";
            $subject = "Reset Password Anda";
            $message = "Klik link berikut untuk mengganti password Anda: $resetLink";
            $headers = "From: no-reply@domain.com";

            // Mengirim email
            if (mail($email, $subject, $message, $headers)) {
                $success = "Link untuk mengganti password telah dikirim ke email Anda.";
            } else {
                $error = "Gagal mengirim email. Coba lagi nanti.";
            }
        } else {
            $error = "Email tidak ditemukan.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password</title>
</head>
<body>

<h1>Lupa Password</h1>

<?php
if (isset($error)) {
    echo "<p style='color: red;'>$error</p>";
}

if (isset($success)) {
    echo "<p style='color: green;'>$success</p>";
}
?>

<!-- Formulir untuk memasukkan email -->
<form action="forgot_password.php" method="POST">
    <label for="email">Masukkan Email Anda:</label><br>
    <input type="email" id="email" name="email" required><br><br>
    <input type="submit" value="Kirim Link Reset Password">
</form>

<p>Kembali ke <a href="login.php">Halaman Login</a></p>

</body>
</html>