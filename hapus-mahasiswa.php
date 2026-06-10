<?php
session_start();
if (!isset($_SESSION['id_akun'])) {
    header("Location: login.php");
    exit;
}
include 'config/controller.php';

if (!isset($_GET['id_mahasiswa']) || empty($_GET['id_mahasiswa'])) {
    header("Location: mahasiswa.php");
    exit;
}

$id_mahasiswa = $_GET['id_mahasiswa'];

if (delete_mahasiswa($id_mahasiswa) > 0) {
    echo "<script>
            alert('data berhasil dihapus');
            document.location.href = 'mahasiswa.php';
          </script>";
    exit;
} else {
    echo "<script>
            alert('data gagal dihapus');
            document.location.href = 'mahasiswa.php';
          </script>";
}
?>