<?php
session_start();
if (!isset($_SESSION['id_akun'])) {
    header("Location: login.php");
    exit;
}
include_once 'config/controller.php';

if (!isset($_GET['id_mahasiswa']) || empty($_GET['id_mahasiswa'])) {
    header("Location: mahasiswa.php");
    exit;
}

$id_mahasiswa = $_GET['id_mahasiswa'];
$hasil = query("SELECT * FROM mahasiswa WHERE id_mahasiswa = $id_mahasiswa");
$data = $hasil[0] ?? null;

if (isset($_POST['ubah'])) {
    if (update_mahasiswa($_POST) > 0) {
        echo "<script>
                alert('data berhasil diubah');
                document.location.href = 'mahasiswa.php';
              </script>";
        exit;
    } else {
        echo "<script>
                alert('data gagal diubah');
                document.location.href = 'mahasiswa.php';
              </script>";
    }
}

include_once 'layout/header.php';
?>

<div class="container mt-4">
    <h1>Ubah Mahasiswa</h1>
    <hr>
    <form id="formUbah" action="ubah-mahasiswa.php?id_mahasiswa=<?= $id_mahasiswa ?>" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id_mahasiswa" value="<?= $id_mahasiswa ?>">
        <input type="hidden" name="foto_lama" value="<?= $data['foto'] ?? ''; ?>">
        <div class="mb-3">
            <label class="form-label">Nama</label>
            <input type="text" class="form-control" name="nama" value="<?= $data['Nama'] ?? ''; ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Prodi</label>
            <input type="text" class="form-control" name="prodi" value="<?= $data['prodi'] ?? ''; ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Jenis Kelamin</label>
            <select class="form-control" name="jk" required>
                <option value="laki-laki" <?= $data['jk'] == 'laki-laki' ? 'selected' : ''; ?>>Laki-laki</option>
                <option value="perempuan" <?= $data['jk'] == 'perempuan' ? 'selected' : ''; ?>>Perempuan</option>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Telepon</label>
            <input type="text" class="form-control" name="telpon" value="<?= $data['telpon'] ?? ''; ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Alamat</label>
            <textarea name="alamat" id="alamat" class="form-control"><?= $data['alamat'] ?? ''; ?></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" class="form-control" name="email" value="<?= $data['email'] ?? ''; ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Foto</label>
            <input type="file" class="form-control" name="foto" id="foto" onchange="previewImage()">
            <small>Kosongkan jika tidak ingin mengganti foto</small><br>
            <img src="assets/img/<?= $data['foto'] ?? ''; ?>" id="preview" width="150" class="mt-2">
        </div>
        <script>
            function previewImage() {
                const foto = document.getElementById('foto');
                const preview = document.getElementById('preview');
                preview.src = URL.createObjectURL(foto.files[0]);
            }
        </script>
        <button type="submit" name="ubah" class="btn btn-primary">Simpan</button>
    </form>
</div>
<?php include_once 'layout/footer.php'; ?>