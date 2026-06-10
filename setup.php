<?php
// Setup database otomatis
$db = mysqli_connect("localhost", "root", "");

if (!$db) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Create database
$sql = "CREATE DATABASE IF NOT EXISTS `crud-dinata` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";
if (mysqli_query($db, $sql)) {
    echo "✓ Database created<br>";
} else {
    echo "✗ Database error: " . mysqli_error($db) . "<br>";
}

// Select database
mysqli_select_db($db, "crud-dinata");

// Create table
$sql = "CREATE TABLE IF NOT EXISTS `barang` (
    `id_barang` INT AUTO_INCREMENT PRIMARY KEY,
    `nama` VARCHAR(100) NOT NULL,
    `jumlah` INT,
    `harga` INT,
    `barcode` VARCHAR(50) NOT NULL DEFAULT '',
    `gambar` VARCHAR(255) DEFAULT NULL,
    `tanggal` DATETIME
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";

if (mysqli_query($db, $sql)) {
    echo "✓ Table created<br>";
} else {
    echo "✗ Table error: " . mysqli_error($db) . "<br>";
}

// Tambah kolom gambar jika belum ada
$check_column = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME='barang' AND COLUMN_NAME='gambar' AND TABLE_SCHEMA='crud-dinata'";
$result = mysqli_query($db, $check_column);
if (mysqli_num_rows($result) == 0) {
    if (mysqli_query($db, "ALTER TABLE barang ADD COLUMN gambar VARCHAR(255) DEFAULT NULL")) {
        echo "✓ Column gambar added<br>";
    }
}

echo "<br><a href='index.php'>← Kembali ke aplikasi</a>";
mysqli_close($db);
?>
