<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "user_management";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// if (!isset($_GET['id'])) {
//     echo "<script>alert('ID tidak valid!'); window.location.href='users.php';</script>";
//     exit();
// }

$id = intval($_GET['id']);

// Ambil data user berdasarkan ID
$stmt = $conn->prepare("SELECT first_name, last_name, photo FROM users WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    echo "<script> window.location.href='users.php';</script>";
    exit();
}

$user = $result->fetch_assoc();
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Konfirmasi Hapus</title>
    <link rel="stylesheet"href="CSS/edit_hapus.css">
</head>
<body>
    <h2>Konfirmasi Hapus Pengguna</h2>
    <p>Apakah Anda yakin ingin menghapus pengguna berikut?</p>
    <p><strong>Nama:</strong> <?php echo $user['first_name'] . " " . $user['last_name']; ?></p>
    <p><strong>Foto:</strong> <img src="uploads/<?php echo $user['photo']; ?>" width="100"></p>
    
    <form method="POST" action="delete.php">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <button type="submit">Ya, Hapus</button>
        <a href="users.php">Batal</a>
    </form>
</body>
</html>
