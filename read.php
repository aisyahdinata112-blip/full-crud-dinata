<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

include '../config/controller.php';

$data = query("SELECT * FROM barang");
echo json_encode([
    'status' => 200,
    'message' => 'success',
    'data' => $data
]);