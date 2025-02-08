CREATE DATABASE user_registration;
USE user_registration;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    tanggal_lahir DATE NOT NULL,
    umur INT NOT NULL,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    jenis_kelamin ENUM('Laki-Laki', 'Perempuan') NOT NULL,
    hobi TEXT,
    biografi TEXT
);