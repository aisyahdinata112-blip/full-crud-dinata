<?php
session_start();
include 'config/controller.php';

if (isset($_POST['login'])) {
    $username = strip_tags($_POST['username']);
    $password = $_POST['password'];

    $hasil = query("SELECT * FROM akun WHERE username = '$username'");
    $akun = $hasil[0] ?? null;

    if ($akun && password_verify($password, $akun['password'])) {
        $_SESSION['id_akun'] = $akun['id_akun'];
        $_SESSION['nama'] = $akun['nama'];
        $_SESSION['level'] = $akun['level'];
        if ($_SESSION['level'] == 3) {
            header("Location: mahasiswa.php");
        } else {
            header("Location: index.php");
        }
        exit;
    } else {
        $error = "Username atau password salah!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        html, body { height: 100%; }
        body { display: flex; align-items: center; background-color: #f5f5f5; }
        .form-signin {
            width: 100%;
            max-width: 330px;
            padding: 15px;
            margin: auto;
        }
    </style>
</head>
<body>
    <div class="form-signin text-center">
        <img src="assets/img/foto.2.svg" width="72" height="57" class="mb-4">
        <h1 class="h3 mb-3 fw-normal">Login</h1>
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>
        <form action="login.php" method="post">
            <div class="form-floating mb-2">
                <input type="text" class="form-control" name="username" placeholder="Username" required>
                <label>Username</label>
            </div>
            <div class="form-floating mb-2">
                <input type="password" class="form-control" name="password" placeholder="Password" required>
                <label>Password</label>
            </div>
            <button type="submit" name="login" class="w-100 btn btn-lg btn-primary mt-2">Login</button>
        </form>
    </div>
</body>
</html>