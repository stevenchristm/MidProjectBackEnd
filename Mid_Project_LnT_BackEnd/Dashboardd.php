<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "user_management";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$search = isset($_GET['query']) ? $_GET['query'] : '';
$sql = "SELECT * FROM users";
if (!empty($search)) {
    $sql = "SELECT * FROM users 
        WHERE CONCAT(first_name, ' ', last_name) LIKE ? 
        OR email LIKE ?";
}

$stmt = $conn->prepare($sql);
if (!empty($search)) {
    $search_param = "%$search%";
    $stmt->bind_param("ss", $search_param, $search_param);
}
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Dashboard</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        a {
            margin-left: 15px;
            margin-right: 15px;
            font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
            color: azure;
            font-weight: bolder;
            text-decoration: none;
        }
        a:hover, a:active {
            color: gold;
        }
        nav {
            background-image: url(Image/hitam.jpg); background-size: cover; opacity: 0.7;
            position: fixed;
            padding-top: 15px;
            padding-bottom: 15px;
            padding-left: 20%;
            padding-right: 20%;
            z-index: 999;
        }
        header {
            background-image: url(Image/hutan.jpg); background-size: cover;
            padding-top: 180px;
            padding-bottom: 330px;
            font-family: Georgia, 'Times New Roman', Times, serif;
            text-align: center;
        }
        footer {
            background-image: url(Image/hitam.jpg); background-size: cover;
            padding-top: 5px;
            padding-bottom: 5px;
            color: white;
            text-align: center;
        }
        #searchInput {
            width: 50%;
            height: 30px;
            font-size: 18px;
            padding: 10px;
            box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.2);
            border-radius: 50px;
            border: 1px solid #ccc;
        }
    </style>
</head>
<body>
    <nav>
        <a href="Dashboardd.php">Dashboard</a>
        <a href="admin_profile.php">Profile Page</a>
        <a href="create_user.html">Create User Page</a>
        <a href="edit_user.php">Update User Page</a>
        <a href="delete_confirm.php">Delete User Page</a>
    </nav>

    <header>
        <h1 style="font-size: 500%; color: coral;">Dashboard</h1>
        <form method="GET" action="">
            <input type="text" id="searchInput" name="query" placeholder="Cari User..." value="<?php echo htmlspecialchars($search); ?>">
        </form>
    </header>

    <table border="1" align="center">
        <link rel="stylesheet" href="CSS/tabel.css">
        <tr>
            <th>No</th>
            <th>Foto</th>
            <th>Full Name</th>
            <th>Email</th>
        </tr>
        <?php $no = 1; while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?php echo $no++; ?></td>
            <td>
                <?php if (!empty($row['photo'])): ?>
                    <img src="uploads/<?php echo $row['photo']; ?>" width="50">
                <?php else: ?>
                    <img src="uploads/default.png" width="50">
                <?php endif; ?>
            </td>
            <td><?php echo htmlspecialchars($row['first_name'] . " " . $row['last_name']); ?></td>
            <td><?php echo htmlspecialchars($row['email']); ?></td>
        </tr>
        <?php endwhile; ?>
    </table>

    <footer>
        Copyright &copy; 2024; Eric Gunawan & Steven Christopher Martin
    </footer>

    <script>
        $(document).ready(function(){
            $("#searchInput").on("keyup", function(event){
                if (event.key === "Enter") {
                    $(this).closest("form").submit();
                }
            });
        });
    </script>
</body>
</html>
