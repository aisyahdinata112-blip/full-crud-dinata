<?php
session_start();
if (!isset($_SESSION['id_akun'])) {
    header("Location: login.php");
    exit;
}
if (isset($_POST['tambah'])) {
    include 'config/controller.php';
    if(create_mahasiswa($_POST) > 0) {
        echo "<script>alert('data berhasil ditambahkan'); window.location.href='mahasiswa.php';</script>";
        exit;
    } else {
        echo "<script>alert('data gagal ditambahkan');</script>";
    }
}

include_once 'layout/header.php';
?>

<div class="container mt-4">
    <h1>Tambah mahasiswa</h1>
    <hr>
    <form id="formTambah" action="tambah-mahasiswa.php" method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label class="form-label">Nama Mahasiswa</label>
            <input type="text" class="form-control" name="nama" required>
        </div>
        <div class="row mb-3">
            <div class="col">
                <label class="form-label">Program Studi</label>
                <input type="text" class="form-control" name="prodi" required>
            </div>
            <div class="col">
                <label class="form-label">Jenis Kelamin</label>
                <input type="text" class="form-control" name="jk" required>
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label">Telepon</label>
            <input type="text" class="form-control" name="telpon" required>
        </div>
        <div class="mb-3">
            <label for="alamat" class="form-label">Alamat</label>
            <textarea name="alamat" id="alamat" class="form-control"></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" class="form-control" name="email" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Foto</label>
            <input type="file" class="form-control" name="foto">
        </div>
        <div class="d-flex justify-content-end">
            <button type="submit" name="tambah" class="btn btn-primary">+ Tambah</button>
        </div>
    </form>
</div>
<?php include_once 'layout/footer.php'; ?>