<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="CSS/update_delete.css">
</head>
<body>
    <h2>Daftar Pengguna</h2>
    <table border="1">
        <tr>
            <th>No</th>
            <th>Foto</th>
            <th>Nama Lengkap</th>
            <th>Email</th>
            <th>Bio</th>
            <th>Aksi</th>
        </tr>

        <?php
        $conn = new mysqli("localhost", "root", "", "user_management");

        if ($conn->connect_error) {
            die("Koneksi gagal: " . $conn->connect_error);
        }

        $sql = "SELECT * FROM users";
        $result = $conn->query($sql);
        $no = 1;

        while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $no++; ?></td>
                <td><img src="uploads/<?php echo $row['photo']; ?>" width="50"></td>
                <td><?php echo $row['first_name'] . " " . $row['last_name']; ?></td>
                <td><?php echo $row['email']; ?></td>
                <td><?php echo $row['bio']; ?></td>
                <td>
                    <a href="delete_confirm.php?id=<?php echo $row['id']; ?>">Hapus</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
