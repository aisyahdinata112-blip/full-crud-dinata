<?php
session_start();
if (!isset($_SESSION['id_akun'])) {
    header("Location: login.php");
    exit;
}
if ($_SESSION['level'] != 1 && $_SESSION['level'] != 2) {
    header("Location: login.php");
    exit;
}
include 'config/controller.php';
$data_barang = query("SELECT * FROM barang");
include 'layout/header.php';
?>
<div class="container mt-4">
    <h1>data barang</h1>
    <hr>
    <div class="mb-3">
        <a href="tambah-barang.php" class="btn btn-primary"><i class="fas fa-plus-circle"></i> Tambah</a>
        <a href="export-excel.php?tipe=barang" class="btn btn-success"><i class="fas fa-file-excel"></i> Export Excel</a>
        <a href="export-pdf.php?tipe=barang" class="btn btn-danger"><i class="fas fa-file-pdf"></i> Download PDF</a>
    </div>
    <table id="dataTable" class="table table-bordered table-striped">
    <thead>
        <tr>
        <th scope="col">no</th>
        <th scope="col">nama</th>
        <th scope="col">jumlah</th>
        <th scope="col">Harga</th>
        <th scope="col">Gambar</th>
        <th scope="col">Barcode</th>
        <th scope="col">tanggal</th>
        <th scope="col">aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php $no = 1; foreach ($data_barang as $barang): ?>
        <tr>
            <?php $barcodeText = trim($barang['barcode'] ?? ''); ?>
            <th scope="row"><?= $no++; ?></th>
            <td><?= isset($barang['nama']) && !empty(trim(strip_tags($barang['nama']))) ? substr(strip_tags($barang['nama']), 0, 50) : '-'; ?></td>
            <td><?= $barang['jumlah'] ?? '-'; ?></td>
            <td><?= 'Rp. ' . number_format($barang['harga'] ?? 0, 0, ',', '.'); ?></td>
            <td>
                <?php if (!empty($barang['gambar'])): ?>
                    <img src="assets/barang/<?= htmlspecialchars($barang['gambar']); ?>" style="max-width: 80px; height: auto; border: 1px solid #ddd; padding: 3px;">
                <?php else: ?>
                    <span class="text-muted">-</span>
                <?php endif; ?>
            </td>
            <td>
                <?php if ($barcodeText !== ''): ?>
                    <img
                        src="barcode.php?text=<?= urlencode($barcodeText); ?>&size=40&codetype=code128&print=true"
                        style="width:100px;height:40px;object-fit:contain;"
                        alt="Barcode">
                <?php else: ?>
                    <span class="text-muted">-</span>
                <?php endif; ?>
            </td>
            <td><?= date("d/m/Y | H:i:s", strtotime($barang['tanggal'] ?? '-')); ?></td>
            <td width="15%" class="text-center">
                <a href="ubah-barang.php?id_barang=<?= $barang['id_barang'] ?? '-'; ?>" class="btn btn-sm btn-success">Edit</a>
                <a href="hapus-barang.php?id_barang=<?= $barang['id_barang'] ?? '-'; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
</div>
<?php include 'layout/footer.php'; ?>