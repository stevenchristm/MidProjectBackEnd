<?php
session_start();
$conn = new mysqli("localhost", "root", "", "user_registration");

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

if (!isset($_SESSION['user_id'])) {
    header("Location: FormLogin.html");
    exit();
}

$logged_in_user_id = $_SESSION['user_id']; 

$query = "SELECT id, first_name, last_name, email, photo FROM users WHERE id != ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $logged_in_user_id);
$stmt->execute();
$result = $stmt->get_result();
?>