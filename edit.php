<?php
session_start();
if (!isset($_SESSION["login"])) {
    header("Location: index.php");
    exit;
}

$id = $_GET["id"] ?? -1;

if (!isset($_SESSION["kontak"][$id])) {
    header("Location: dashboard.php");
    exit;
}

$kontak = $_SESSION["kontak"][$id];
$err = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nama    = trim($_POST["nama"]);
    $email   = trim($_POST["email"]);
    $telepon = trim($_POST["telepon"]);

    if ($nama === "") {
        $err = "Nama wajib diisi!";
    } else {
        $_SESSION["kontak"][$id] = [
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
<title>Edit Kontak</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<div class="box">
    <h2>Edit Kontak</h2>

    <?php if($err): ?><p class="error"><?= $err ?></p><?php endif; ?>

    <form method="post">
        <label>Nama</label>
        <input type="text" name="nama" value="<?= $kontak['nama'] ?>" required>

        <label>Email</label>
        <input type="email" name="email" value="<?= $kontak['email'] ?>">

        <label>Telepon</label>
        <input type="text" name="telepon" value="<?= $kontak['telepon'] ?>" required>

        <button type="submit">Simpan Perubahan</button>
        <a href="dashboard.php" class="btn red">Batal</a>
    </form>
</div>
</body>
</html>
