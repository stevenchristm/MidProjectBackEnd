<?php
$conn = new mysqli("localhost", "root", "", "user_registration");

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login_input = trim($_POST['username_email']);  // Mengambil input dari username/email
    $password = $_POST['password'];

    // Query untuk mencari user berdasarkan username atau email
    $stmt = $conn->prepare("SELECT password FROM users WHERE username=? OR email=?");
    $stmt->bind_param("ss", $login_input, $login_input);  // Menggunakan parameter login_input untuk username atau email
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($hashed_password);
        $stmt->fetch();

        // Verifikasi password dengan password_hash
        if (password_verify($password, $hashed_password)) {
            echo "<script>window.location.href='Dashboardd.php';</script>";
            exit();
        } else {
            echo "<script>alert('Login Gagal. Password salah!'); window.location.href='FormLogin.html';</script>";
            exit();
        }
    } else {
        echo "<script>alert('Login Gagal. Username atau Email tidak ditemukan!'); window.location.href='FormLogin.html';</script>";
        exit();
    }
    $_SESSION['user_id'] = $user_id;
    $stmt->close();
}
$conn->close();
?>
