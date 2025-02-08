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

$id = intval($_GET['id']);

// Ambil data user berdasarkan ID
$stmt = $conn->prepare("SELECT first_name, last_name, email, bio, photo FROM users WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    echo "<script> window.location.href='user_edit.php';</script>";
    exit();
}

$user = $result->fetch_assoc();
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit User</title>
    <link rel="stylesheet" href="CSS/edit_hapus.css">
</head>
<body>
    <h2>Edit Data Pengguna</h2>
    <form method="POST" action="update_user.php" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo $id; ?>">

        <label>First Name:</label>
        <input type="text" name="first_name" value="<?php echo $user['first_name']; ?>" required><br>

        <label>Last Name:</label>
        <input type="text" name="last_name" value="<?php echo $user['last_name']; ?>" required><br>

        <label>Email:</label>
        <input type="email" name="email" value="<?php echo $user['email']; ?>" required><br>

        <label>Bio:</label>
        <textarea name="bio" required><?php echo $user['bio']; ?></textarea><br>

        <label>Foto:</label>
        <input type="file" name="photo"><br>
        <img src="uploads/<?php echo $user['photo']; ?>" width="100"><br>

        <button type="submit">Update</button>
        <a href="user_edit.php">Batal</a>
    </form>
</body>
</html>
