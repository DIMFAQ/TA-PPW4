<?php
session_start();
if (!isset($_SESSION["login"])) {
    header("Location: index.php");
    exit;
}

$kontak = $_SESSION["kontak"];
?>
<!DOCTYPE html>
<html>
<head>
<title>Daftar Kontak</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<div class="box">
    <h2>Daftar Kontak</h2>

    <a href="tambah.php" class="btn">Tambah Kontak</a>
    <a href="logout.php" class="btn red">Logout</a>

    <br><br>

    <?php if (empty($kontak)): ?>
        <p>Belum ada kontak.</p>
    <?php else: ?>
        <table class="table">
            <tr>
                <th>Nama</th>
                <th>Email</th>
                <th>Telepon</th>
                <th>Aksi</th>
            </tr>

            <?php foreach ($kontak as $i => $k): ?>
            <tr>
                <td><?= htmlspecialchars($k["nama"]) ?></td>
                <td><?= htmlspecialchars($k["email"]) ?></td>
                <td><?= htmlspecialchars($k["telepon"]) ?></td>
                <td>
                    <a href="edit.php?id=<?= $i ?>" class="btn">Edit</a>
                    <a href="hapus.php?id=<?= $i ?>" class="btn red" onclick="return confirm('Hapus kontak ini?')">Hapus</a>
                </td>
            </tr>
            <?php endforeach; ?>

        </table>
    <?php endif; ?>
</div>
</body>
</html>
