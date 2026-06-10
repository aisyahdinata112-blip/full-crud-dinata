<?php
session_start();
if (!isset($_SESSION['id_akun'])) {
    header("Location: login.php");
    exit;
}
include_once 'layout/header.php';
include_once 'config/controller.php';

// Cek apakah id_barang ada di URL
if (!isset($_GET['id_barang']) || empty($_GET['id_barang'])) {
    header("Location: index.php");
    exit;
}

// mengambil id_barang dari URL
$id_barang = $_GET['id_barang'];
$hasil = query("SELECT * FROM barang WHERE id_barang = $id_barang");
$data = $hasil[0] ?? null;

if (isset($_POST['ubah'])) {  

    if(update_barang($_POST) > 0) { 
        echo "<script>
                alert('data berhasil diubah');
                document.location.href = 'index.php';
              </script>";
        exit;
    } else {
        echo "<script>
                alert('data gagal diubah'); 
                document.location.href = 'index.php';
            </script>";
    }
}
?>

<div class="container mt-4">
    <h1>Ubah Barang</h1>
    <hr>
    <form action="ubah-barang.php?id_barang=<?= $id_barang ?>" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id_barang" value="<?= $id_barang ?>">
        
        <div class="mb-3">
            <label for="nama" class="form-label">Nama</label>
            <textarea class="form-control" id="nama" name="nama" required><?= htmlspecialchars($data['nama'] ?? '', ENT_QUOTES, 'UTF-8'); ?></textarea>
        </div>
        
        <div class="mb-3">
            <label for="jumlah" class="form-label">Jumlah</label>
            <input type="number" class="form-control" id="jumlah" name="jumlah" value="<?= $data['jumlah'] ?? ''; ?>" required>
        </div>
        
        <div class="mb-3">
            <label for="harga" class="form-label">Harga</label>
            <input type="number" class="form-control" id="harga" name="harga" value="<?= $data['harga'] ?? ''; ?>" required>
        </div>
        
        <div class="mb-3">
            <label for="barcode" class="form-label">Barcode</label>
            <input type="text" class="form-control" id="barcode" name="barcode" value="<?= $data['barcode'] ?? ''; ?>" placeholder="Kosongkan untuk auto-generate">
        </div>
        
        <div class="mb-3">
            <label for="gambar" class="form-label">Gambar (JPG, PNG, GIF, WEBP - Max 5MB)</label>
            <?php if (!empty($data['gambar'])): ?>
                <div class="mb-2">
                    <img src="assets/barang/<?= htmlspecialchars($data['gambar']); ?>" style="max-width: 200px; height: auto; border: 1px solid #ddd; padding: 5px;">
                    <input type="hidden" name="gambar_lama" value="<?= htmlspecialchars($data['gambar']); ?>">
                </div>
            <?php endif; ?>
            <input type="file" class="form-control" id="gambar" name="gambar" accept=".jpg,.jpeg,.png,.gif,.webp">
        </div>
        
        <div class="mb-3">
            <label for="tanggal" class="form-label">Tanggal</label>
            <input type="datetime-local" class="form-control" id="tanggal" name="tanggal" value="<?= $data['tanggal'] ?? ''; ?>" required>
        </div>
        
        <button type="submit" name="ubah" class="btn btn-primary">Simpan</button>
    </form>
</div>

<script>
    // Memastikan DOM siap / CKEDITOR tersedia sebelum dijalankan
    window.addEventListener('DOMContentLoaded', () => {
        if (typeof CKEDITOR !== 'undefined') {
            CKEDITOR.replace('nama', {
                height: 200,
                toolbar: [
                    ['Bold', 'Italic', 'Underline', '-', 'BulletedList', 'NumberedList']
                ]
            });
        }
    });
</script>   

<?php include_once 'layout/footer.php'; ?>