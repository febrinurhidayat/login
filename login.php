<?php
// login.php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username_or_email = $_POST['username_or_email'];
    $password = $_POST['password'];

    // Placeholder untuk koneksi ke database Anda
    $conn = new mysqli('localhost', 'username', 'password', 'database');

    if ($conn->connect_error) {
        die("Koneksi gagal: " . $conn->connect_error);
    }

    // Escape input untuk keamanan
    $username_or_email = $conn->real_escape_string($username_or_email);
    $password = $conn->real_escape_string($password);

    // Cek apakah input adalah email atau username
    if (filter_var($username_or_email, FILTER_VALIDATE_EMAIL)) {
        // Input adalah email
        $sql = "SELECT * FROM users WHERE email='$username_or_email'";
    } else {
        // Input adalah username
        $sql = "SELECT * FROM users WHERE username='$username_or_email'";
    }

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        // Verifikasi password
        if (password_verify($password, $user['password'])) {
            echo "Login berhasil!";
            // Redirect ke halaman utama atau lakukan tindakan lainnya
        } else {
            echo "Password salah!";
        }
    } else {
        echo "Username atau email tidak ditemukan!";
    }

    $conn->close();
}
?>
