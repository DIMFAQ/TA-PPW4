<?php
session_start();
if (!isset($_SESSION["login"])) { header("Location: index.php"); exit; }
$id = $_GET["id"] ?? -1;
if (!isset($_SESSION["kontak"][$id])) { header("Location: dashboard.php"); exit; }

$kontak = $_SESSION["kontak"][$id];
$err = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nama    = trim($_POST["nama"]);
    $email   = trim($_POST["email"]);
    $telepon = trim($_POST["telepon"]);
    $is_favorit = isset($_POST["favorit"]) ? true : false; 

    if ($nama === "") {
        $err = "Nama wajib diisi!";
    } else {
        $_SESSION["kontak"][$id] = ["nama" => $nama, "email" => $email, "telepon" => $telepon, "favorit" => $is_favorit];
        header("Location: dashboard.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Edit Kontak - Synconnect</title>
<script src="https://cdn.tailwindcss.com"></script>
<style>
    .glass {
      background: linear-gradient(180deg, rgba(247,251,255,0.85), rgba(243,248,255,0.75));
      -webkit-backdrop-filter: blur(6px);
      backdrop-filter: blur(6px);
    }
    input:focus {
      outline: none;
      box-shadow: 0 6px 18px rgba(56, 189, 248, 0.06);
    }
</style>
</head>
<body class="min-h-screen" style="background-image:url('tm.png'); background-size:cover; background-position:fixed;">

<nav class="glass sticky top-0 z-50 shadow-md shadow-blue-100 border-b border-blue-100">
    <div class="container mx-auto flex justify-between items-center p-4">
        <a href="dashboard.php" class="text-2xl font-extrabold text-slate-800">Synconnect</a>
        
        <div class="hidden md:flex space-x-4 items-center">
            <a href="dashboard.php" class="text-sm font-medium text-slate-600 hover:text-blue-600">Daftar Kontak</a>
            <a href="tambah.php" class="text-sm font-medium text-slate-600 hover:text-blue-600">Tambah Kontak</a>
            <a href="logout.php" class="text-sm font-semibold text-white bg-gradient-to-r from-red-500 to-pink-500 hover:from-red-600 hover:to-pink-600 px-4 py-2 rounded-lg shadow-md shadow-red-200 transition">Logout</a>
        </div>
        
        <div class="md:hidden">
            <button id="menu-toggle" class="focus:outline-none text-slate-800">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path></svg>
            </button>
        </div>
    </div>
</nav>

<div class="container mx-auto p-4 md:p-8 flex justify-center">
    
    <div class="glass border border-blue-100 shadow-lg shadow-blue-200 rounded-2xl p-8 w-full max-w-lg">
        <div class="text-center mb-6">
            <h1 class="text-2xl font-extrabold text-slate-800">Edit Kontak</h1>
            <p class="text-sm text-slate-500">Ubah detail kontak</p>
        </div>

        <?php if(!empty($err)): ?>
          <div class="mb-4 rounded-lg bg-red-50 border border-red-200 text-red-700 px-4 py-3 text-sm">
            <?= htmlspecialchars($err) ?>
          </div>
        <?php endif; ?>

        <form method="post" class="space-y-4">
            <div>
                <label for="nama" class="block text-sm font-medium text-slate-700 mb-1">Nama</label>
                <input id="nama" name="nama" type="text" value="<?= htmlspecialchars($kontak['nama']) ?>" required
                  class="w-full py-2.5 px-3 rounded-lg bg-[#f0f6ff] border <?php echo !empty($err) ? 'border-red-400' : 'border-blue-200'; ?> text-slate-800 placeholder-slate-400 focus:ring-2 focus:ring-blue-300 focus:border-blue-400 transition">
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-slate-700 mb-1">Email (Opsional)</label>
                <input id="email" name="email" type="email" value="<?= htmlspecialchars($kontak['email'] ?? '') ?>"
                  class="w-full py-2.5 px-3 rounded-lg bg-[#f0f6ff] border border-blue-200 text-slate-800 placeholder-slate-400 focus:ring-2 focus:ring-blue-300 focus:border-blue-400 transition">
            </div>
            
            <div>
                <label for="telepon" class="block text-sm font-medium text-slate-700 mb-1">Telepon</label>
                <input id="telepon" name="telepon" type="text" value="<?= htmlspecialchars($kontak['telepon']) ?>" required
                  class="w-full py-2.5 px-3 rounded-lg bg-[#f0f6ff] border border-blue-200 text-slate-800 placeholder-slate-400 focus:ring-2 focus:ring-blue-300 focus:border-blue-400 transition">
            </div>

            <div class="flex items-center justify-between text-sm pt-2">
                <label class="inline-flex items-center gap-2 text-slate-600">
                    <?php $checked = (isset($kontak['favorit']) && $kontak['favorit'] === true) ? 'checked' : ''; ?>
                    <input type="checkbox" name="favorit" class="h-4 w-4 text-blue-500 rounded border-slate-300 focus:ring-blue-300" <?= $checked ?>>
                    <span>Jadikan Favorit</span>
                </label>
            </div>

            <div class="flex items-center space-x-4 pt-4">
                <button type="submit" 
                  class="w-full bg-gradient-to-r from-blue-500 to-indigo-500 hover:from-blue-600 hover:to-indigo-600 text-white font-semibold py-2.5 rounded-lg shadow-md shadow-blue-300 transition">
                  Simpan Perubahan
                </button>
                <a href="dashboard.php" class="w-full text-center text-slate-600 hover:text-slate-800 font-medium py-2.5 rounded-lg">Batal</a>
            </div>
        </form>
    </div>
</div>

</body>
</html>