<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "user_management";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

if (isset($_POST['submit'])) {
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $email = trim($_POST['email']);
    $bio = trim($_POST['bio']);

    $cek_email = $conn->prepare("SELECT id FROM users WHERE email=?");
    $cek_email->bind_param("s", $email);
    $cek_email->execute();
    $cek_email->store_result();

    if ($cek_email->num_rows > 0) {
        echo "<script>alert('Email sudah terdaftar, gunakan email lain!'); window.location.href='create_user.html';</script>";
        exit();
    }

    $target_dir = "uploads/";
    $photo_name = basename($_FILES["photo"]["name"]);
    $target_file = $target_dir . $photo_name;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    $allowed_types = array("jpg", "jpeg", "png", "gif");
    if (!in_array($imageFileType, $allowed_types)) {
        echo "<script>alert('Hanya file JPG, JPEG, PNG, dan GIF yang diperbolehkan.'); window.location.href='create_user.html';</script>";
        exit();
    }

    if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
        // Simpan data ke database
        $stmt = $conn->prepare("INSERT INTO users (photo, first_name, last_name, email, bio) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $photo_name, $first_name, $last_name, $email, $bio);

        if ($stmt->execute()) {
            echo "<script>alert('Data berhasil ditambahkan!'); window.location.href='Dashboardd.php';</script>";
            exit();
        } else {
            echo "Terjadi kesalahan dalam menyimpan data.";
        }
        $stmt->close();
    } else {
        echo "Gagal mengunggah foto.";
    }
}
$conn->close();
?>
