<?php
session_start();
if (!isset($_SESSION["login"])) {
    header("Location: index.php");
    exit;
}

$id = $_GET["id"] ?? -1;

if (isset($_SESSION["kontak"][$id])) {

    if (!isset($_SESSION["kontak"][$id]['favorit'])) {
        $_SESSION["kontak"][$id]['favorit'] = true;
    } else {
        $_SESSION["kontak"][$id]['favorit'] = !$_SESSION["kontak"][$id]['favorit'];
    }
}

header("Location: dashboard.php");
exit;
?>