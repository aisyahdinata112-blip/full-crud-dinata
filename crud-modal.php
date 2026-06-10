<?php
session_start();
if (!isset($_SESSION['id_akun'])) {
    header("Location: login.php");
    exit;
}
if ($_SESSION['level'] != 1) {
    header("Location: login.php");
    exit;
}
include 'config/controller.php';
$data_akun = query("SELECT * FROM akun");
include 'layout/header.php';
?>

<div class="container mt-4">
    <h1>Data Akun</h1>
    <hr>
    <a href="#" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalTambah"><i class="fas fa-plus-circle"></i> Tambah Data</a>
    <table id="dataTable" class="table table-bordered table-striped">
    <thead>
        <tr>
            <th scope="col">no</th>
            <th scope="col">nama</th>
            <th scope="col">username</th>
            <th scope="col">email</th>
            <th scope="col">level</th>
            <th scope="col">aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php $no = 1; foreach ($data_akun as $akun): ?>
        <tr>
            <th scope="row"><?= $no++; ?></th>
            <td><?= $akun['nama'] ?? '-'; ?></td>
            <td><?= $akun['username'] ?? '-'; ?></td>
            <td><?= $akun['email'] ?? '-'; ?></td>
            <td><?= $akun['level'] ?? '-'; ?></td>
            <td width="15%" class="text-center">
                <a href="#" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#modalUbah<?= $akun['id_akun'] ?>">Ubah</a>
                <a href="hapus-akun.php?id_akun=<?= $akun['id_akun'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
    </table>
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Tambah Akun</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="crud-modal.php" method="post">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama</label>
                        <input type="text" class="form-control" name="nama" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <input type="text" class="form-control" name="username" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" class="form-control" name="password" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Level</label>
                        <select class="form-control" name="level" required>
                            <option value="1">Admin</option>
                            <option value="2">Operator Barang</option>
                            <option value="3">Operator Mahasiswa</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kembali</button>
                    <button type="submit" name="tambah" class="btn btn-primary">Tambah</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Ubah -->
<?php foreach ($data_akun as $akun): ?>
<div class="modal fade" id="modalUbah<?= $akun['id_akun'] ?>" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">Ubah Akun</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="crud-modal.php" method="post">
                <input type="hidden" name="id_akun" value="<?= $akun['id_akun'] ?>">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama</label>
                        <input type="text" class="form-control" name="nama" value="<?= $akun['nama'] ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <input type="text" class="form-control" name="username" value="<?= $akun['username'] ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" value="<?= $akun['email'] ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" class="form-control" name="password">
                        <small>Kosongkan jika tidak ingin mengganti password</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Level</label>
                        <select class="form-control" name="level" required>
                            <option value="1" <?= $akun['level'] == 1 ? 'selected' : ''; ?>>Admin</option>
                            <option value="2" <?= $akun['level'] == 2 ? 'selected' : ''; ?>>Operator Barang</option>
                            <option value="3" <?= $akun['level'] == 3 ? 'selected' : ''; ?>>Operator Mahasiswa</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kembali</button>
                    <button type="submit" name="ubah" class="btn btn-success">Ubah</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php endforeach; ?>

<?php
if (isset($_POST['tambah'])) {
    if (create_akun($_POST) > 0) {
        echo "<script>alert('data berhasil ditambahkan'); document.location.href='crud-modal.php';</script>";
    } else {
        echo "<script>alert('data gagal ditambahkan');</script>";
    }
}

if (isset($_POST['ubah'])) {
    if (update_akun($_POST) > 0) {
        echo "<script>alert('data berhasil diubah'); document.location.href='crud-modal.php';</script>";
    } else {
        echo "<script>alert('data gagal diubah');</script>";
    }
}
?>

<?php include 'layout/footer.php'; ?>