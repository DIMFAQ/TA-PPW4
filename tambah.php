<?php
session_start();
if (!isset($_SESSION["login"])) {
    header("Location: index.php");
    exit;
}

$errors = [];
$nama = "";
$email = "";
$telepon = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $nama    = trim($_POST["nama"]);
    $email   = trim($_POST["email"]);
    $telepon = trim($_POST["telepon"]);

    if ($nama === "") {
        $errors["nama"] = "Nama wajib diisi!";
    }

    if ($telepon === "") {
        $errors["telepon"] = "Nomor telepon wajib diisi!";
    } elseif (!preg_match('/^[0-9]+$/', $telepon)) {
        $errors["telepon"] = "Nomor telepon harus berupa angka saja!";
    }

    if ($email !== "" && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors["email"] = "Format email tidak valid!";
    }

    if (empty($errors)) {
        $_SESSION["kontak"][] = [
            "nama"    => $nama,
            "email"   => $email,
            "telepon" => $telepon
        ];

        header("Location: dashboard.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Tambah Kontak</title>
<link rel="stylesheet" href="style.css">
</head>
<body>

<div class="box">
    <h2>Tambah Kontak</h2>

    <form method="post">

        <label>Nama</label>
        <input type="text" name="nama" value="<?= htmlspecialchars($nama) ?>">
        <?php if(isset($errors["nama"])): ?>
            <p class="error"><?= $errors["nama"] ?></p>
        <?php endif; ?>

        <label>Email</label>
        <input type="text" name="email" value="<?= htmlspecialchars($email) ?>">
        <?php if(isset($errors["email"])): ?>
            <p class="error"><?= $errors["email"] ?></p>
        <?php endif; ?>

        <label>Telepon</label>
        <input type="text" name="telepon" value="<?= htmlspecialchars($telepon) ?>">
        <?php if(isset($errors["telepon"])): ?>
            <p class="error"><?= $errors["telepon"] ?></p>
        <?php endif; ?>

        <button type="submit">Simpan</button>
        <a href="dashboard.php" class="btn red">Batal</a>
    </form>
</div>

</body>
</html>
