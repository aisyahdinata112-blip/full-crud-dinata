<?php
session_start();
if (!isset($_SESSION['id_akun'])) {
    header("Location: login.php");
    exit;
}

include 'config/controller.php';

// Cek tipe export yang diminta
$tipe = $_GET['tipe'] ?? '';

if ($tipe == 'barang') {
    export_barang();
} elseif ($tipe == 'mahasiswa') {
    export_mahasiswa();
} else {
    die('Tipe export tidak valid');
}

function export_barang() {
    global $db;
    
    $data = query("SELECT * FROM barang");
    
    // Set header untuk Excel
    header("Content-Type: application/vnd.ms-excel; charset=UTF-8");
    header("Content-Disposition: attachment; filename=Laporan_Barang_" . date('d-m-Y_His') . ".xls");
    header("Pragma: no-cache");
    header("Expires: 0");
    
    // Mulai output
    echo "<table border='1' cellpadding='5' cellspacing='0'>";
    echo "<tr style='background-color: #4CAF50; color: white; font-weight: bold;'>";
    echo "<th>No</th>";
    echo "<th>Nama Barang</th>";
    echo "<th>Jumlah</th>";
    echo "<th>Harga</th>";
    echo "<th>Tanggal</th>";
    echo "</tr>";
    
    $no = 1;
    foreach ($data as $barang) {
        echo "<tr>";
        echo "<td>" . $no++ . "</td>";
        echo "<td>" . htmlspecialchars($barang['nama'] ?? '-') . "</td>";
        echo "<td>" . htmlspecialchars($barang['jumlah'] ?? '-') . "</td>";
        echo "<td>Rp. " . number_format($barang['harga'] ?? 0, 0, ',', '.') . "</td>";
        echo "<td>" . date("d/m/Y H:i:s", strtotime($barang['tanggal'] ?? '-')) . "</td>";
        echo "</tr>";
    }
    
    echo "</table>";
    exit;
}

function export_mahasiswa() {
    global $db;
    
    $data = query("SELECT * FROM mahasiswa");
    
    // Set header untuk Excel
    header("Content-Type: application/vnd.ms-excel; charset=UTF-8");
    header("Content-Disposition: attachment; filename=Laporan_Mahasiswa_" . date('d-m-Y_His') . ".xls");
    header("Pragma: no-cache");
    header("Expires: 0");
    
    // Mulai output
    echo "<table border='1' cellpadding='5' cellspacing='0'>";
    echo "<tr style='background-color: #2196F3; color: white; font-weight: bold;'>";
    echo "<th>No</th>";
    echo "<th>Nama</th>";
    echo "<th>Program Studi</th>";
    echo "<th>Jenis Kelamin</th>";
    echo "<th>Telepon</th>";
    echo "<th>Email</th>";
    echo "</tr>";
    
    $no = 1;
    foreach ($data as $mahasiswa) {
        echo "<tr>";
        echo "<td>" . $no++ . "</td>";
        echo "<td>" . htmlspecialchars($mahasiswa['Nama'] ?? '-') . "</td>";
        echo "<td>" . htmlspecialchars($mahasiswa['prodi'] ?? '-') . "</td>";
        echo "<td>" . htmlspecialchars($mahasiswa['jk'] ?? '-') . "</td>";
        echo "<td>" . htmlspecialchars($mahasiswa['telpon'] ?? '-') . "</td>";
        echo "<td>" . htmlspecialchars($mahasiswa['email'] ?? '-') . "</td>";
        echo "</tr>";
    }
    
    echo "</table>";
    exit;
}
?>
