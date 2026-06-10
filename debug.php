<?php
echo "<h2>Debug Info</h2>";

echo "<h3>1. Cek koneksi database:</h3>";
$db = mysqli_connect("localhost:3306", "root", "");
if ($db) {
    echo "✓ Koneksi MySQL OK<br>";
} else {
    echo "✗ Koneksi MySQL GAGAL: " . mysqli_connect_error() . "<br>";
}

echo "<h3>2. Cek database 'crud-dinata':</h3>";
$result = mysqli_query($db, "SHOW DATABASES LIKE 'crud-dinata'");
if (mysqli_num_rows($result) > 0) {
    echo "✓ Database 'crud-dinata' ada<br>";
} else {
    echo "✗ Database 'crud-dinata' TIDAK ada<br>";
    echo "Membuat database...<br>";
    if (mysqli_query($db, "CREATE DATABASE `crud-dinata`")) {
        echo "✓ Database berhasil dibuat<br>";
    }
}

echo "<h3>3. Cek tabel 'barang':</h3>";
mysqli_select_db($db, "crud-dinata");
$result = mysqli_query($db, "SHOW TABLES LIKE 'barang'");
if (mysqli_num_rows($result) > 0) {
    echo "✓ Tabel 'barang' ada<br>";
} else {
    echo "✗ Tabel 'barang' TIDAK ada<br>";
}

echo "<h3>4. Cek file-file project:</h3>";
$files = ['database.php', 'index.php', 'tambah-barang.php', 'config/controller.php', 'config/app.php', 'layout/header.php'];
foreach ($files as $file) {
    $path = __DIR__ . '/' . $file;
    if (file_exists($path)) {
        echo "✓ " . $file . "<br>";
    } else {
        echo "✗ " . $file . " TIDAK ADA<br>";
    }
}

echo "<br><a href='index.php'>← Kembali ke aplikasi</a>";
?>
