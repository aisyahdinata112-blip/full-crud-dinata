<?php
session_start();
if (!isset($_SESSION['id_akun'])) {
    header("Location: login.php");
    exit;
}

require 'vendor/autoload.php';

use Spipu\Html2Pdf\Html2Pdf;

include 'config/controller.php';

$data = query("SELECT * FROM mahasiswa");

$html = '
<table border="1" cellpadding="5">
    <tr>
        <th>No</th>
        <th>Nama</th>
        <th>Prodi</th>
        <th>Jenis Kelamin</th>
        <th>Telepon</th>
        <th>Email</th>
    </tr>';

$no = 1;
foreach ($data as $m) {
    $html .= '<tr>
        <td>'.$no++.'</td>
        <td>'.$m['Nama'].'</td>
        <td>'.$m['prodi'].'</td>
        <td>'.$m['jk'].'</td>
        <td>'.$m['telpon'].'</td>
        <td>'.$m['email'].'</td>
    </tr>';
}
$html .= '</table>';

$html2pdf = new Html2Pdf();
$html2pdf->writeHTML($html);
$html2pdf->output('Laporan_Mahasiswa.pdf');
?>