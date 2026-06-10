<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: Content-Type');

include 'config/controller.php';

$method = $_SERVER['REQUEST_METHOD'];
$request = explode('/', trim($_SERVER['PATH_INFO'] ?? '', '/'));

switch ($method) {
    case 'GET':
        $data = query("SELECT * FROM barang");
        echo json_encode($data);
        break;

    case 'POST':
        $input = json_decode(file_get_contents('php://input'), true);
        $nama = mysqli_real_escape_string($db, $input['nama']);
        $jumlah = (int)$input['jumlah'];
        $harga = (int)$input['harga'];
        $barcode = mysqli_real_escape_string($db, $input['barcode'] ?? '');
        $tanggal = mysqli_real_escape_string($db, $input['tanggal']);
        $query = "INSERT INTO barang (nama, jumlah, harga, barcode, tanggal) VALUES ('$nama', $jumlah, $harga, '$barcode', '$tanggal')";
        mysqli_query($db, $query);
        echo json_encode(['message' => 'Data berhasil ditambahkan']);
        break;

    case 'PUT':
        $input = json_decode(file_get_contents('php://input'), true);
        $id = (int)$input['id_barang'];
        $nama = mysqli_real_escape_string($db, $input['nama']);
        $jumlah = (int)$input['jumlah'];
        $harga = (int)$input['harga'];
        $barcode = mysqli_real_escape_string($db, $input['barcode'] ?? '');
        $tanggal = mysqli_real_escape_string($db, $input['tanggal']);
        $query = "UPDATE barang SET nama='$nama', jumlah=$jumlah, harga=$harga, barcode='$barcode', tanggal='$tanggal' WHERE id_barang=$id";
        mysqli_query($db, $query);
        echo json_encode(['message' => 'Data berhasil diubah']);
        break;

    case 'DELETE':
        $id = (int)($_GET['id'] ?? 0);
        $query = "DELETE FROM barang WHERE id_barang=$id";
        mysqli_query($db, $query);
        echo json_encode(['message' => 'Data berhasil dihapus']);
        break;
}
?>