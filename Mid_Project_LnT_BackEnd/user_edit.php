<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "user_management";

// Koneksi database
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil data user
$result = $conn->query("SELECT * FROM users");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Daftar Pengguna</title>
    <link rel="stylesheet" href="CSS/update_delete.css">
</head>
<body>
    <h2>Daftar Pengguna</h2>
    <table border="1">
        <tr>
            <th>No</th>
            <th>Foto</th>
            <th>Nama</th>
            <th>Email</th>
            <th>Action</th>
        </tr>
        <?php $no = 1; while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?php echo $no++; ?></td>
            <td><img src="uploads/<?php echo htmlspecialchars($row['photo']); ?>" width="50"></td>
            <td><?php echo htmlspecialchars($row['first_name'] . " " . $row['last_name']); ?></td>
            <td><?php echo htmlspecialchars($row['email']); ?></td>
            <td>
                <a href="edit_user.php?id=<?php echo $row['id']; ?>">Edit</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
<?php $conn->close(); ?>
