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

// Ambil query pencarian dari parameter URL
$searchQuery = isset($_GET['query']) ? $_GET['query'] : '';

// Menyusun query SQL untuk mencari user berdasarkan first_name, last_name, atau email
$sql = "SELECT * FROM users WHERE first_name LIKE ? OR last_name LIKE ? OR email LIKE ?";
$stmt = $conn->prepare($sql);
$searchText = "%" . $searchQuery . "%";
$stmt->bind_param("sss", $searchText, $searchText, $searchText);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results</title>
    <link rel="stylesheet" href="CSS/tabel.css">
</head>
<body>
    <header align="center">
        <h1>Hasil Pencarian untuk: <?php echo htmlspecialchars($searchQuery); ?></h1>
    </header>

    <table border="1" align="center">
        <tr>
            <th>No</th>
            <th>Foto</th>
            <th>Full Name</th>
            <th>Email</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            $no = 1;
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$no}</td>
                        <td><img src='uploads/{$row['photo']}' width='50'></td>
                        <td>" . htmlspecialchars($row['first_name'] . " " . $row['last_name']) . "</td>
                        <td>" . htmlspecialchars($row['email']) . "</td>
                    </tr>";
                $no++;
            }
        } else {
            echo "<tr><td colspan='4'>Tidak ada hasil ditemukan.</td></tr>";
        }
        ?>
    </table>

    <footer align="center">
        Copyright &copy; 2024; Eric Gunawan & Steven Christopher Martin
    </footer>

</body>
</html>

<?php
// Tutup koneksi
$stmt->close();
$conn->close();
?>