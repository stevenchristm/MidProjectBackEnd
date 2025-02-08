<?php
$conn = new mysqli("localhost", "root", "", "user_registration");

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = trim($_POST['nama']);
    $tanggal_lahir = $_POST['tanggal'];
    $umur = $_POST['umur'];
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $email = trim($_POST['email']);
    $jenis_kelamin = isset($_POST['jenis_kelamin']) ? $_POST['jenis_kelamin'] : ''; 
    if (isset($_POST['hobi']) && is_array($_POST['hobi'])) {
        $hobi = implode(", ", $_POST['hobi']);
    } else {
        $hobi = ""; // Jika tidak ada hobi yang dipilih
    }
    $biografi = trim($_POST['biografi']);

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $cek_user = $conn->prepare("SELECT id FROM users WHERE username=? OR email=?");
    $cek_user->bind_param("ss", $username, $email);
    $cek_user->execute();
    $cek_user->store_result();

    if ($cek_user->num_rows > 0) {
        echo "Username atau Email sudah terdaftar. Silakan gunakan yang lain.";
    } else {
        $stmt = $conn->prepare("INSERT INTO users (nama, tanggal_lahir, umur, username, password, email, jenis_kelamin, hobi, biografi) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssissssss", $nama, $tanggal_lahir, $umur, $username, $hashed_password, $email, $jenis_kelamin, $hobi, $biografi);
        
        if ($stmt->execute()) {
            echo "<script>alert('Registrasi berhasil! Silakan login.'); window.location.href='FormLogin.html';</script>";
        } else {
            echo "Terjadi kesalahan saat menyimpan data.";
        }
        $stmt->close();
    }
    $cek_user->close();
}
$conn->close();
?>