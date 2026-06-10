<?php

// Connect tanpa pilih database dulu
$db_temp = mysqli_connect("localhost:3306", "root", "");
if (!$db_temp) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Buat database jika belum ada
mysqli_query($db_temp, "CREATE DATABASE IF NOT EXISTS `crud-dinata` DEFAULT CHARACTER SET utf8mb4");
mysqli_close($db_temp);

// Connect ke database
$db = mysqli_connect("localhost:3306", "root", "", "crud-dinata");
if (!$db) {
    echo "Koneksi database gagal: " . mysqli_connect_error();
    exit;
}

// Buat tabel jika belum ada
$sql = "CREATE TABLE IF NOT EXISTS `barang` (
    `id_barang` INT AUTO_INCREMENT PRIMARY KEY,
    `nama` VARCHAR(100) NOT NULL,
    `jumlah` INT,
    `harga` INT,
    `barcode` VARCHAR(50) NOT NULL DEFAULT '',
    `gambar` VARCHAR(255) DEFAULT NULL,
    `tanggal` DATETIME
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";

mysqli_query($db, $sql);
// Buat tabel mahasiswa jika belum ada
$sql_mahasiswa = "CREATE TABLE IF NOT EXISTS `mahasiswa` (
    `id_mahasiswa` INT AUTO_INCREMENT PRIMARY KEY,
    `Nama` VARCHAR(100) NOT NULL,
    `prodi` VARCHAR(100),
    `jk` VARCHAR(20),
    `telpon` VARCHAR(20),
    `alamat` TEXT,
    `email` VARCHAR(100),
    `foto` VARCHAR(255)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";

mysqli_query($db, $sql_mahasiswa);
// Tambah kolom gambar jika belum ada
$check_column = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME='barang' AND COLUMN_NAME='gambar' AND TABLE_SCHEMA='crud-dinata'";
$result = mysqli_query($db, $check_column);
if (mysqli_num_rows($result) == 0) {
    mysqli_query($db, "ALTER TABLE barang ADD COLUMN gambar VARCHAR(255) DEFAULT NULL");
}
