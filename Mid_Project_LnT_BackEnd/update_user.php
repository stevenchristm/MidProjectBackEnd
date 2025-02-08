<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "user_management";

// Koneksi ke database
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Cek metode request
if ($_SERVER["REQUEST_METHOD"] != "POST") {
    echo "<script>alert('Akses tidak valid!'); window.location.href='user_edit.php';</script>";
    exit();
}

// Pastikan ID tersedia
if (!isset($_POST['id']) || empty($_POST['id'])) {
    echo "<script>alert('ID tidak valid!'); window.location.href='user_edit.php';</script>";
    exit();
}

$id = intval($_POST['id']);
$first_name = trim($_POST['first_name']);
$last_name = trim($_POST['last_name']);
$email = trim($_POST['email']);
$bio = trim($_POST['bio']);

// Ambil foto lama
$stmt = $conn->prepare("SELECT photo FROM users WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$old_photo = $user['photo'];
$stmt->close();

// Jika ada file baru, upload
if (!empty($_FILES['photo']['name'])) {
    $target_dir = "uploads/";
    $photo_name = basename($_FILES["photo"]["name"]);
    $target_file = $target_dir . $photo_name;

    // Validasi ekstensi
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $allowed_types = ["jpg", "png", "jpeg", "gif"];
    if (!in_array($imageFileType, $allowed_types)) {
        echo "<script>alert('Format foto tidak didukung!'); window.location.href='edit_user.php?id=$id';</script>";
        exit();
    }

    // Pindahkan file
    if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
        if (!empty($old_photo) && file_exists("uploads/" . $old_photo)) {
            unlink("uploads/" . $old_photo);
        }
    } else {
        echo "<script>alert('Gagal mengupload foto!'); window.location.href='edit_user.php?id=$id';</script>";
        exit();
    }

    // Update dengan foto baru
    $stmt = $conn->prepare("UPDATE users SET first_name=?, last_name=?, email=?, bio=?, photo=? WHERE id=?");
    $stmt->bind_param("sssssi", $first_name, $last_name, $email, $bio, $photo_name, $id);
} else {
    // Update tanpa ubah foto
    $stmt = $conn->prepare("UPDATE users SET first_name=?, last_name=?, email=?, bio=? WHERE id=?");
    $stmt->bind_param("ssssi", $first_name, $last_name, $email, $bio, $id);
}

// Eksekusi update
if ($stmt->execute()) {
    echo "<script>alert('Data berhasil diperbarui!'); window.location.href='Dashboardd.php';</script>";
} else {
    echo "<script>alert('Gagal memperbarui data!'); window.location.href='edit_user.php?id=$id';</script>";
}

// Tutup koneksi
$stmt->close();
$conn->close();
?>
