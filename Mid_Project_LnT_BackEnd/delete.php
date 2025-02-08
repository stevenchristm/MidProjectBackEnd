<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "user_management";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    $id = intval($_POST['id']);

    $stmt = $conn->prepare("SELECT photo FROM users WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (!empty($row['photo'])) {
            unlink("uploads/" . $row['photo']);
        }

        $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();

        echo "<script>alert('Data berhasil dihapus!'); window.location.href='Dashboardd.php';</script>";
    } else {
        echo "<script>alert('Data tidak ditemukan!'); window.location.href='Dashboardd.php';</script>";
    }

    $stmt->close();
}

$conn->close();
?>
