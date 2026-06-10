<?php
session_start();
if (!isset($_SESSION['id_akun'])) {
    header("Location: login.php");
    exit;
}
if (isset($_POST['tambah'])) {
    include 'config/controller.php';
    if(create_barang($_POST) > 0) {
        echo "<script>alert('data berhasil ditambahkan'); window.location.href='index.php';</script>";
        exit;
    } else {
        echo "<script>alert('data gagal ditambahkan');</script>";
    }
}

include_once'layout/header.php';
?>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Tambah Data Barang</h1>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <form action="tambah-barang.php" method="post">
                        <div class="form-group">
                            <label>Nama Barang</label>
                            <input type="text" class="form-control" name="nama" required>
                        </div>
                        <div class="form-group">
                            <label>Jumlah</label>
                            <input type="number" class="form-control" name="jumlah" required>
                        </div>
                        <div class="form-group">
                            <label>Harga Barang</label>
                            <input type="number" class="form-control" name="harga" required>
                        </div>
                        <br>
                        <button type="submit" name="tambah" class="btn btn-primary">Tambah</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>

<?php include_once 'layout/footer.php'; ?>