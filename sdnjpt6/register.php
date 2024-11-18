<?php
session_start();
include('db.php'); // Menyertakan koneksi database

// Proses registrasi
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    // Validasi input
    if (empty($username) || empty($email) || empty($password)) {
        $error = "Semua kolom harus diisi.";
    } else {
        // Enkripsi password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        // Periksa apakah username atau email sudah ada di database
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username OR email = :email");
        $stmt->execute(['username' => $username, 'email' => $email]);
        $user = $stmt->fetch();
        
        if ($user) {
            $error = "Username atau email sudah digunakan.";
        } else {
            // Masukkan data ke database
            $stmt = $pdo->prepare("INSERT INTO users (username, email, password, role) VALUES (:username, :email, :password, 'user')");
            $stmt->execute(['username' => $username, 'email' => $email, 'password' => $hashed_password]);
            $_SESSION['username'] = $username;
            $_SESSION['role'] = 'user';
            header("Location: dashboard_user.php"); // Redirect ke dashboard user
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
</head>
<body>

<h1>Register</h1>

<?php if (isset($error)) { echo "<p style='color: red;'>$error</p>"; } ?>

<form action="register.php" method="POST">
    <label for="username">Username:</label><br>
    <input type="text" id="username" name="username" required><br><br>
    
    <label for="email">Email:</label><br>
    <input type="email" id="email" name="email" required><br><br>
    
    <label for="password">Password:</label><br>
    <input type="password" id="password" name="password" required><br><br>
    
    <input type="submit" value="Register">
</form>

<p>Sudah punya akun? <a href="login.php">Login</a></p>

</body>
</html>