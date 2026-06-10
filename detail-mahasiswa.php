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

$id_mahasiswa = (int)$_GET['id_mahasiswa'];
$hasil = query("SELECT * FROM mahasiswa WHERE id_mahasiswa = $id_mahasiswa");
$mahasiswa = $hasil[0] ?? null;

include 'layout/header.php';
?>

<div class="container mt-5">
    <h1>Data <?= $mahasiswa['Nama'] ?? '-'; ?></h1>
    <hr>
    <table class="table table-bordered table-striped mt-3">
        <tr>
            <th>Nama</th>
            <td><?= $mahasiswa['Nama'] ?? '-'; ?></td>
        </tr>
        <tr>
            <th>Email</th>
            <td><?= $mahasiswa['email'] ?? '-'; ?></td>
        </tr>
        <tr>
            <th>Jenis Kelamin</th>
            <td><?= $mahasiswa['jk'] ?? '-'; ?></td>
        </tr>
        <tr>
            <th>Prodi</th>
            <td><?= $mahasiswa['prodi'] ?? '-'; ?></td>
        </tr>
        <tr>
            <th>Telepon</th>
            <td><?= $mahasiswa['telpon'] ?? '-'; ?></td>
        </tr>
        <tr>
            <th>Alamat</th>
            <td><?php echo html_entity_decode($mahasiswa['alamat'] ?? '-'); ?></td>
        </tr>
        <tr>
            <th>Foto</th>
            <td><img src="assets/img/<?= $mahasiswa['foto'] ?? ''; ?>" alt="<?= $mahasiswa['Nama'] ?? ''; ?>" width="150"></td>
        </tr>
    </table>
    <a href="mahasiswa.php" class="btn btn-secondary" style="float: left;">Kembali</a>
</div>

<?php include 'layout/footer.php'; ?>