<?php
session_start();

$err = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $u = $_POST["username"] ?? "";
    $p = $_POST["password"] ?? "";

    if ($u === "dimas" && $p === "dimas") {
        $_SESSION["login"] = true;

        if (!isset($_SESSION["kontak"])) {
            $_SESSION["kontak"] = [];
        }

        header("Location: dashboard.php");
        exit;
    } else {
        $err = "Username atau password salah!";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Login</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<div class="box">
    <h2>Login</h2>

    <?php if($err): ?>
        <p class="error"><?= $err ?></p>
    <?php endif; ?>

    <form method="post">
        <label>Username</label>
        <input type="text" name="username" required>

        <label>Password</label>
        <input type="password" name="password" required>

        <button type="submit">Masuk</button>
    </form>
</div>
</body>
</html>
