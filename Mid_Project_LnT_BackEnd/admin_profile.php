<?php
// Koneksi ke database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "user_registration";

$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil data admin langsung dari database
$sql = "SELECT id, nama, tanggal_lahir, umur, username, password, email, jenis_kelamin, hobi, biografi FROM users WHERE id = 1"; // Anggap admin memiliki ID 1
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Jika data ditemukan
    $admin = $result->fetch_assoc();
} else {
    echo "Admin tidak ditemukan!";
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Profile</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            background-color: white;
            padding: 20px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        table {
            width: 100%;
            margin: 20px 0;
            border-collapse: collapse;
        }

        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }

        .bio {
            padding: 10px;
            background-color: #f9f9f9;
            border-radius: 5px;
            margin-top: 10px;
        }

        .back-link {
            text-align: center;
            margin-top: 20px;
        }

        .back-link a {
            text-decoration: none;
            color: #007bff;
            font-weight: bold;
        }

        .back-link a:hover {
            color: #0056b3;
        }
    </style>
</head>
<body>
    <h1>Admin Profile</h1>
    <div class="container">
        <h2>Informasi Admin</h2>
        <table>
            <tr>
                <th>ID</th>
                <td><?php echo $admin['id']; ?></td>
            </tr>
            <tr>
                <th>Nama</th>
                <td><?php echo $admin['nama']; ?></td>
            </tr>
            <tr>
                <th>Tanggal Lahir</th>
                <td><?php echo $admin['tanggal_lahir']; ?></td>
            </tr>
            <tr>
                <th>Umur</th>
                <td><?php echo $admin['umur']; ?></td>
            </tr>
            <tr>
                <th>Username</th>
                <td><?php echo $admin['username']; ?></td>
            </tr>
            <tr>
                <th>Password (Hashed)</th>
                <td><?php echo $admin['password']; ?></td>
            </tr>
            <tr>
                <th>Email</th>
                <td><?php echo $admin['email']; ?></td>
            </tr>
            <tr>
                <th>Jenis Kelamin</th>
                <td><?php echo $admin['jenis_kelamin']; ?></td>
            </tr>
            <tr>
                <th>Hobi</th>
                <td><?php echo $admin['hobi']; ?></td>
            </tr>
        </table>
        <div class="bio">
            <strong>Bio:</strong>
            <p><?php echo $admin['biografi']; ?></p>
        </div>

        <div class="back-link">
            <a href="Dashboardd.php">Kembali ke Dashboard</a>
        </div>
    </div>
</body>
</html>
