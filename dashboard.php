<?php
session_start();
if (!isset($_SESSION["login"])) {
    header("Location: index.php");
    exit;
}

$kontak_list = $_SESSION["kontak"] ?? [];
$favorit_kontak = [];
$biasa_kontak = [];

foreach ($kontak_list as $i => $k) {
    $k['original_id'] = $i; 
    if (isset($k['favorit']) && $k['favorit'] === true) {
        $favorit_kontak[] = $k;
    } else {
        $biasa_kontak[] = $k;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Dashboard - Synconnect</title>
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
<body class="min-h-screen pl-32" style="background-image:url('tm.png'); background-size:cover; background-position:fixed;">

<nav class="glass sticky top-0 z-50 shadow-md shadow-blue-100 border-b border-blue-100 -ml-32"> <div class="container mx-auto flex justify-between items-center p-4">
        <a href="dashboard.php" class="text-2xl font-extrabold text-slate-800">Synconnect</a>
        
        <div class="hidden md:flex space-x-4 items-center">
            <a href="dashboard.php" class="text-sm font-semibold text-blue-600">Daftar Kontak</a>
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

<div class="w-full md:w-4/2 md:-ml-14 flex py-8">

    <div class="w-full md:w-2/5 space-y-6">

        <div class="flex flex-row gap-4 items-center">
        
            <div class="glass border border-blue-100 shadow-lg shadow-blue-200 rounded-2xl p-4 w-full flex-1">
                 <input type="text" id="search-bar" 
                 class="w-full py-2.5 px-3 rounded-lg bg-[#f0f6ff] border border-blue-200 text-slate-800 placeholder-slate-400 focus:ring-2 focus:ring-blue-300 focus:border-blue-400 transition" 
                 placeholder="Cari nama atau telepon...">
            </div>

            <a href="tambah.php" 
               class="flex-shrink-0 w-14 h-14 bg-gradient-to-r from-blue-500 to-indigo-500 hover:from-blue-600 hover:to-indigo-600 text-white font-semibold rounded-lg shadow-md shadow-blue-300 transition flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"></path>
                </svg>
            </a>
        </div>

        <div class="space-y-6">
            
            <?php if (!empty($favorit_kontak)): ?>
                <h3 class="text-xl font-bold text-white mb-4 drop-shadow-md">Favorit</h3>
                <div id="contact-grid-fav" class="space-y-4">
                    <?php foreach ($favorit_kontak as $k): ?>
                        <div class="glass border border-yellow-200 shadow-lg shadow-yellow-100 rounded-2xl p-4 flex flex-col md:flex-row md:items-center md:justify-between contact-card" data-name="<?= strtolower(htmlspecialchars($k["nama"])) ?>" data-telepon="<?= htmlspecialchars($k["telepon"]) ?>">
                            <div class="flex-grow">
                                <div class="flex items-center gap-2">
                                    <a href="toggle_favorit.php?id=<?= $k['original_id'] ?>" class="text-yellow-400 hover:text-yellow-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" /></svg>
                                    </a>
                                    <h4 class="text-lg font-semibold text-slate-800"><?= htmlspecialchars($k["nama"]) ?></h4>
                                </div>
                                <div class="pl-7 mt-1 space-y-0.5">
                                    <?php if(!empty($k["email"])): ?><p class="text-slate-600 truncate text-sm" title="<?= htmlspecialchars($k["email"]) ?>">📧 <?= htmlspecialchars($k["email"]) ?></p><?php endif; ?>
                                    <p class="text-slate-600 truncate text-sm">📞 <?= htmlspecialchars($k["telepon"]) ?></p>
                                </div>
                            </div>
                            <div class="flex-shrink-0 flex space-x-3 mt-4 md:mt-0 md:pl-4 self-end md:self-center">
                                <a href="edit.php?id=<?= $k['original_id'] ?>" class="text-blue-600 hover:underline font-medium text-sm">Edit</a>
                                <a href="hapus.php?id=<?= $k['original_id'] ?>" class="text-red-500 hover:underline font-medium text-sm" onclick="return confirm('Hapus kontak ini?')">Hapus</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <h3 class="text-xl font-bold text-white mb-4 drop-shadow-md">Semua Kontak</h3>
            <?php if (empty($biasa_kontak) && empty($favorit_kontak)): ?>
                <div class="glass border border-blue-100 shadow-lg shadow-blue-200 rounded-2xl p-8 text-center">
                    <p class="text-slate-700">Belum ada kontak. Silakan tambah kontak baru.</p>
                </div>
            <?php elseif (empty($biasa_kontak) && !empty($favorit_kontak)): ?>
                 <?php else: ?>
                <div id="contact-grid-biasa" class="space-y-4">
                    <?php foreach ($biasa_kontak as $k): ?>
                        <div class="glass border border-blue-100 shadow-lg shadow-blue-200 rounded-2xl p-4 flex flex-col md:flex-row md:items-center md:justify-between contact-card" data-name="<?= strtolower(htmlspecialchars($k["nama"])) ?>" data-telepon="<?= htmlspecialchars($k["telepon"]) ?>">
                            <div class="flex-grow">
                                <div class="flex items-center gap-2">
                                    <a href="toggle_favorit.php?id=<?= $k['original_id'] ?>" class="text-gray-400 hover:text-yellow-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" /></svg>
                                    </a>
                                    <h4 class="text-lg font-semibold text-slate-800"><?= htmlspecialchars($k["nama"]) ?></h4>
                                </div>
                                <div class="pl-7 mt-1 space-y-0.5">
                                    <?php if(!empty($k["email"])): ?><p class="text-slate-600 truncate text-sm" title="<?= htmlspecialchars($k["email"]) ?>">📧 <?= htmlspecialchars($k["email"]) ?></p><?php endif; ?>
                                    <p class="text-slate-600 truncate text-sm">📞 <?= htmlspecialchars($k["telepon"]) ?></p>
                                </div>
                            </div>
                            <div class="flex-shrink-0 flex space-x-3 mt-4 md:mt-0 md:pl-4 self-end md:self-center">
                                <a href="edit.php?id=<?= $k['original_id'] ?>" class="text-blue-600 hover:underline font-medium text-sm">Edit</a>
                                <a href="hapus.php?id=<?= $k['original_id'] ?>" class="text-red-500 hover:underline font-medium text-sm" onclick="return confirm('Hapus kontak ini?')">Hapus</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <p id="no-results" class="glass border border-blue-100 shadow-lg shadow-blue-200 rounded-2xl p-8 text-center text-slate-700 hidden mt-6">
                    Tidak ada kontak yang cocok dengan pencarian Anda.
                </p>
            <?php endif; ?>
        </div>

    </div>

    <div class="hidden md:block md:flex-1"></div>

</div>
</body>
</html>