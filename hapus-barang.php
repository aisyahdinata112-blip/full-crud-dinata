<?php
session_start();
if (!isset($_SESSION['id_akun'])) {
    header("Location: login.php");
    exit;
}
include 'config/controller.php';

// Cek apakah id_barang ada di URL
if (!isset($_GET['id_barang']) || empty($_GET['id_barang'])) {
    header("Location: index.php");
    exit;
}

// mengambil id_barang dari URL
$id_barang = $_GET['id_barang'];

if (delete_barang($id_barang) > 0) {
    echo "<script>
            alert('data berhasil dihapus');
            document.location.href = 'index.php';
          </script>";
    exit;
} else {
    echo "<script>
            alert('data gagal dihapus');
            document.location.href = 'index.php';
          </script>";
}
?>