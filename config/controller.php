<?php

include __DIR__ . '/../database.php';

function query($query) {
    global $db;
    $result = mysqli_query($db, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}

function generate_barcode() {
    return 'BRG' . date('YmdHis') . rand(10, 99);
}

function upload_barang_image() {
    if (empty($_FILES['gambar']['name'])) {
        return null;
    }
    
    $namaFile = $_FILES['gambar']['name'];
    $ukuranFile = $_FILES['gambar']['size'];
    $tmpName = $_FILES['gambar']['tmp_name'];
    $error = $_FILES['gambar']['error'];

    if ($error === 4) {
        return null;
    }

    $extensifileValid = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    $extensifile = explode('.', $namaFile);
    $extensifile = strtolower(end($extensifile));

    if (!in_array($extensifile, $extensifileValid)) {
        echo "<script>alert('Format File Tidak Valid. Gunakan JPG, PNG, GIF, atau WEBP'); document.location.href = document.referrer;</script>";
        die();
    }

    if ($ukuranFile > 5242880) {
        echo "<script>alert('Ukuran File Terlalu Besar (Max 5MB)'); document.location.href = document.referrer;</script>";
        die();
    }

    $namaFileBaru = uniqid() . '.' . $extensifile;
    move_uploaded_file($tmpName, 'assets/barang/' . $namaFileBaru);
    return $namaFileBaru;
}

function create_barang($data) {
    global $db;

    // AMAN: Tidak pakai strip_tags agar format CKEditor di nama barang tersimpan
    $nama = $data['nama'] ?? '';
    $jumlah = (int)($data['jumlah'] ?? 0);
    $harga = (int)($data['harga'] ?? 0);
    $barcode = trim(strip_tags($data['barcode'] ?? ''));
    if ($barcode === '') {
        $barcode = time() . rand(100, 999);
    }
    $gambar = upload_barang_image();
    $tanggal = strip_tags($data['tanggal'] ?? '');

    $nama = mysqli_real_escape_string($db, $nama);
    $barcode = mysqli_real_escape_string($db, $barcode);
    $gambar = mysqli_real_escape_string($db, $gambar ?? '');
    $tanggal = mysqli_real_escape_string($db, $tanggal);

    $query = "INSERT INTO barang (nama, jumlah, harga, barcode, gambar, tanggal) VALUES ('$nama', $jumlah, $harga, '$barcode', '$gambar', '$tanggal')";

    if (mysqli_query($db, $query)) {
        return mysqli_affected_rows($db);
    } else {
        return 0;
    }
}

function update_barang($data) {
    global $db;

    $id_barang = (int)$data['id_barang'];
    
    // BERHASIL DIPERBAIKI: Menghapus strip_tags agar modifikasi CKEditor tidak hilang
    $nama = trim($data['nama'] ?? ''); 
    
    $jumlah = (int)($data['jumlah'] ?? 0);
    $harga = (int)($data['harga'] ?? 0);
    $barcode = trim(strip_tags($data['barcode'] ?? ''));
    if ($barcode === '') {
        $barcode = generate_barcode();
    }
    
    $nama = mysqli_real_escape_string($db, $nama);
    $barcode = mysqli_real_escape_string($db, $barcode);
    $tanggal = mysqli_real_escape_string($db, trim(strip_tags($data['tanggal'] ?? '')));

    $gambar_baru = upload_barang_image();
    if ($gambar_baru) {
        $hasil = query("SELECT gambar FROM barang WHERE id_barang = $id_barang");
        $gambar_lama = $hasil[0]['gambar'] ?? '';
        if (!empty($gambar_lama) && file_exists('assets/barang/' . $gambar_lama)) {
            unlink('assets/barang/' . $gambar_lama);
        }
        $gambar = $gambar_baru;
    } else {
        $gambar = $data['gambar_lama'] ?? '';
    }
    $gambar = mysqli_real_escape_string($db, $gambar);

    $query = "UPDATE barang SET nama='$nama', jumlah=$jumlah, harga=$harga, barcode='$barcode', gambar='$gambar', tanggal='$tanggal' WHERE id_barang=$id_barang";

    if (mysqli_query($db, $query)) {
        return mysqli_affected_rows($db);
    } else {
        return 0;
    }
}

function upload_file() {
    if (empty($_FILES['foto']['name'])) {
        return null;
    }

    $namaFile   = $_FILES['foto']['name'];
    $ukuranFile = $_FILES['foto']['size'];
    $tmpName    = $_FILES['foto']['tmp_name'];

    $extensifileValid = ['jpg', 'jpeg', 'png'];
    $extensifile = explode('.', $namaFile);
    $extensifile = strtolower(end($extensifile));

    if (!in_array($extensifile, $extensifileValid)) {
        echo "<script>alert('Format File Tidak Valid'); document.location.href = document.referrer;</script>";
        die();
    }

    if ($ukuranFile > 2048000) {
        echo "<script>alert('Ukuran File Terlalu Besar'); document.location.href = document.referrer;</script>";
        die();
    }

    $namaFileBaru = uniqid() . '.' . $extensifile;
    move_uploaded_file($tmpName, 'assets/img/' . $namaFileBaru);
    return $namaFileBaru;
}

function upload_gambar_alamat() {
    if (empty($_FILES['gambar_alamat']['name'])) {
        return null;
    }

    $namaFile   = $_FILES['gambar_alamat']['name'];
    $ukuranFile = $_FILES['gambar_alamat']['size'];
    $tmpName    = $_FILES['gambar_alamat']['tmp_name'];

    $extensifileValid = ['jpg', 'jpeg', 'png'];
    $extensifile = explode('.', $namaFile);
    $extensifile = strtolower(end($extensifile));

    if (!in_array($extensifile, $extensifileValid)) {
        echo "<script>alert('Format File Tidak Valid'); document.location.href = document.referrer;</script>";
        die();
    }

    if ($ukuranFile > 2048000) {
        echo "<script>alert('Ukuran File Terlalu Besar'); document.location.href = document.referrer;</script>";
        die();
    }

    $namaFileBaru = uniqid() . '.' . $extensifile;
    move_uploaded_file($tmpName, 'assets/img/' . $namaFileBaru);
    return $namaFileBaru;
}

function create_mahasiswa($data) {
    global $db;

    $nama = strip_tags($data['nama']);
    $prodi = strip_tags($data['prodi']);
    $jk = strip_tags($data['jk']);
    $telpon = strip_tags($data['telpon']);
    
    // BERHASIL DIPERBAIKI: Menghapus strip_tags agar tag gambar <img> dari CKFinder mau disimpan
    $alamat = $data['alamat']; 
    
    $email = strip_tags($data['email']);
    $foto = upload_file();
    $gambar_alamat = upload_gambar_alamat();

    $nama = mysqli_real_escape_string($db, $nama);
    $prodi = mysqli_real_escape_string($db, $prodi);
    $jk = mysqli_real_escape_string($db, $jk);
    $telpon = mysqli_real_escape_string($db, $telpon);
    $alamat = mysqli_real_escape_string($db, $alamat);
    $email = mysqli_real_escape_string($db, $email);
    $foto = mysqli_real_escape_string($db, $foto ?? '');
    $gambar_alamat = mysqli_real_escape_string($db, $gambar_alamat ?? '');

    $query = "INSERT INTO mahasiswa (Nama, prodi, jk, telpon, alamat, email, foto, gambar_alamat) VALUES ('$nama', '$prodi', '$jk', '$telpon', '$alamat', '$email', '$foto', '$gambar_alamat')";

    if (mysqli_query($db, $query)) {
        return mysqli_affected_rows($db);
    } else {
        return 0;
    }
}

function delete_barang($id_barang) {
    global $db;

    $id_barang = (int)$id_barang;
    
    $hasil = query("SELECT gambar FROM barang WHERE id_barang = $id_barang");
    $gambar = $hasil[0]['gambar'] ?? '';
    
    $query = "DELETE FROM barang WHERE id_barang = $id_barang";

    if (mysqli_query($db, $query)) {
        if (!empty($gambar) && file_exists('assets/barang/' . $gambar)) {
            unlink('assets/barang/' . $gambar);
        }
        return mysqli_affected_rows($db);
    } else {
        return 0;
    }
}

function delete_mahasiswa($id_mahasiswa) {
    global $db;

    $id_mahasiswa = (int)$id_mahasiswa;

    $hasil = query("SELECT foto FROM mahasiswa WHERE id_mahasiswa = $id_mahasiswa");
    $foto = $hasil[0]['foto'] ?? '';

    $query = "DELETE FROM mahasiswa WHERE id_mahasiswa = $id_mahasiswa";

    if (mysqli_query($db, $query)) {
        if (!empty($foto) && file_exists('assets/img/' . $foto)) {
            unlink('assets/img/' . $foto);
        }
        return mysqli_affected_rows($db);
    } else {
        return 0;
    }
}

function update_mahasiswa($data) {
    global $db;

    $id_mahasiswa = (int)$data['id_mahasiswa'];
    $nama = mysqli_real_escape_string($db, strip_tags($data['nama']));
    $prodi = mysqli_real_escape_string($db, strip_tags($data['prodi']));
    $jk = mysqli_real_escape_string($db, strip_tags($data['jk']));
    $telpon = mysqli_real_escape_string($db, strip_tags($data['telpon']));
    
    // BERHASIL DIPERBAIKI: Menghapus strip_tags agar data text/gambar update-an dari CKEditor tersimpan utuh
    $alamat = $data['alamat']; 
    
    $email = mysqli_real_escape_string($db, strip_tags($data['email']));

    if (!empty($_FILES['foto']['name'])) {
        $foto = upload_file();
    } else {
        $foto = $data['foto_lama'];
    }

    if (!empty($_FILES['gambar_alamat']['name'])) {
        $gambar_alamat = upload_gambar_alamat();
    } else {
        $gambar_alamat = $data['gambar_alamat_lama'];
    }

    $foto = mysqli_real_escape_string($db, $foto ?? '');
    $gambar_alamat = mysqli_real_escape_string($db, $gambar_alamat ?? '');
    $alamat = mysqli_real_escape_string($db, $alamat);

    $query = "UPDATE mahasiswa SET Nama='$nama', prodi='$prodi', jk='$jk', telpon='$telpon', alamat='$alamat', email='$email', foto='$foto', gambar_alamat='$gambar_alamat' WHERE id_mahasiswa=$id_mahasiswa";

    if (mysqli_query($db, $query)) {
        return mysqli_affected_rows($db);
    } else {
        return 0;
    }
}

function create_akun($data) {
    global $db;

    $nama = mysqli_real_escape_string($db, strip_tags($data['nama']));
    $username = mysqli_real_escape_string($db, strip_tags($data['username']));
    $email = mysqli_real_escape_string($db, strip_tags($data['email']));
    $password = password_hash($data['password'], PASSWORD_DEFAULT);
    $level = (int)$data['level'];

    $query = "INSERT INTO akun (nama, username, email, password, level) VALUES ('$nama', '$username', '$email', '$password', $level)";

    if (mysqli_query($db, $query)) {
        return mysqli_affected_rows($db);
    } else {
        return 0;
    }
}

function delete_akun($id_akun) {
    global $db;

    $id_akun = (int)$id_akun;
    $query = "DELETE FROM akun WHERE id_akun = $id_akun";

    if (mysqli_query($db, $query)) {
        return mysqli_affected_rows($db);
    } else {
        return 0;
    }
}
?>