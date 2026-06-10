<?php
session_start();
if (!isset($_SESSION['id_akun'])) {
    header("Location: login.php");
    exit;
}
include 'config/controller.php';

if (!isset($_GET['id_akun']) || empty($_GET['id_akun'])) {
    header("Location: crud-modal.php");
    exit;
}

$id_akun = $_GET['id_akun'];

if (delete_akun($id_akun) > 0) {
    echo "<script>
            alert('data berhasil dihapus');
            document.location.href = 'crud-modal.php';
          </script>";
    exit;
} else {
    echo "<script>
            alert('data gagal dihapus');
            document.location.href = 'crud-modal.php';
          </script>";
}
?>