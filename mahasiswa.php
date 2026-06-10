<?php
session_start();
if (!isset($_SESSION['id_akun'])) {
    header("Location: login.php");
    exit;
}
if ($_SESSION['level'] != 1 && $_SESSION['level'] != 3) {
    header("Location: login.php");
    exit;
}
include 'config/controller.php';
$data_mahasiswa = query("SELECT * FROM mahasiswa");
include 'layout/header.php';
?>

<div class="container mt-4">
    <h1>Data Mahasiswa</h1>
    <hr>
    <div class="mb-3">
        <a href="tambah-mahasiswa.php" class="btn btn-primary"><i class="fas fa-plus-circle"></i> Tambah</a>
        <a href="export-excel.php?tipe=mahasiswa" class="btn btn-success"><i class="fas fa-file-excel"></i> Export Excel</a>
        <a href="export-pdf.php" class="btn btn-danger"><i class="fas fa-file-pdf"></i> Download PDF</a>
    </div>
    <table id="dataTable" class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>no</th>
            <th>nama</th>
            <th>prodi</th>
            <th>jenis kelamin</th>
            <th>telepon</th>
            <th>aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php $no = 1; foreach ($data_mahasiswa as $mahasiswa): ?>
        <tr>
            <td><?= $no++; ?></td>
            <td><?= $mahasiswa['Nama'] ?? '-'; ?></td>
            <td><?= $mahasiswa['prodi'] ?? '-'; ?></td>
            <td><?= $mahasiswa['jk'] ?? '-'; ?></td>
            <td><?= $mahasiswa['telpon'] ?? '-'; ?></td>
            <td width="20%" style="white-space: nowrap;">
                 <a href="detail-mahasiswa.php?id_mahasiswa=<?= $mahasiswa['id_mahasiswa'] ?>" class="btn btn-secondary btn-sm">Detail</a>
                 <a href="ubah-mahasiswa.php?id_mahasiswa=<?= $mahasiswa['id_mahasiswa'] ?>" class="btn btn-success btn-sm">Ubah</a>
                 <a href="hapus-mahasiswa.php?id_mahasiswa=<?= $mahasiswa['id_mahasiswa'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
    </table>
</div>
<?php include 'layout/footer.php'; ?>