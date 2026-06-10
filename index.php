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

<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Dashboard</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Dashboard</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <section class="content">
    <div class="container-fluid">

      <!-- 4 Kotak Dashboard -->
      <div class="row">
        <div class="col-lg-3 col-6">
          <div class="small-box bg-info">
            <div class="inner">
              <h3>150</h3>
              <p>New Orders</p>
            </div>
            <div class="icon"><i class="ion ion-bag"></i></div>
            <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <div class="col-lg-3 col-6">
          <div class="small-box bg-success">
            <div class="inner">
              <h3>53<sup style="font-size: 20px">%</sup></h3>
              <p>Bounce Rate</p>
            </div>
            <div class="icon"><i class="ion ion-stats-bars"></i></div>
            <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <div class="col-lg-3 col-6">
          <div class="small-box bg-warning">
            <div class="inner">
              <h3>44</h3>
              <p>User Registrations</p>
            </div>
            <div class="icon"><i class="ion ion-person-add"></i></div>
            <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <div class="col-lg-3 col-6">
          <div class="small-box bg-danger">
            <div class="inner">
              <h3>65</h3>
              <p>Unique Visitors</p>
            </div>
            <div class="icon"><i class="ion ion-pie-graph"></i></div>
            <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
      </div>

      <!-- Tabel Data Barang -->
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Data Barang</h3>
            </div>
            <div class="card-body">
              <a href="tambah-barang.php" class="btn btn-primary btn-sm mb-3">
                <i class="fas fa-plus"></i> Tambah Barang
              </a>
              <table id="tabel-barang" class="table table-bordered table-hover">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Jumlah</th>
                    <th>Harga</th>
                    <th>Barcode</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php $no = 1; foreach ($data_barang as $barang) : ?>
                  <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $barang['nama'] ?></td>
                    <td><?= $barang['jumlah'] ?></td>
                    <td>Rp. <?= number_format($barang['harga'], 0, ',', '.') ?></td>
                    <td>
                      <img src="barcode.php?code=<?= $barang['barcode'] ?>" alt="barcode">
                    </td>
                    <td><?= date('d/m/Y | H:i:s', strtotime($barang['tanggal'])) ?></td>
                    <td>
                      <a href="ubah-barang.php?id=<?= $barang['id_barang'] ?>" class="btn btn-success btn-sm">
                        <i class="fas fa-edit"></i> Ubah
                      </a>
                      <a href="hapus-barang.php?id=<?= $barang['id_barang'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')">
                        <i class="fas fa-trash"></i> Hapus
                      </a>
                    </td>
                  </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>

    </div>
  </section>
</div>

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">

<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>

<script>
  $(document).ready(function() {
    $('#tabel-barang').DataTable();
  });
</script>

<?php include 'layout/footer.php'; ?>