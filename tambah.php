<?php
session_start();
if (!isset($_SESSION["login"])) {
    header("Location: index.php");
    exit;
}

$err = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nama    = trim($_POST["nama"]);
    $email   = trim($_POST["email"]);
    $telepon = trim($_POST["telepon"]);

    if ($nama === "") {
        $err = "Nama wajib diisi!";
    } else {
        $_SESSION["kontak"][] = [
            "nama" => $nama,
            "email" => $email,
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

    <?php if($err): ?><p class="error"><?= $err ?></p><?php endif; ?>

    <form method="post">
        <label>Nama</label>
        <input type="text" name="nama" required>

        <label>Email</label>
        <input type="email" name="email">

        <label>Telepon</label>
        <input type="text" name="telepon" required>

        <button type="submit">Simpan</button>
        <a href="dashboard.php" class="btn red">Batal</a>
    </form>
</div>
</body>
</html>
