k<?php $server_ip = $_SERVER['SERVER_ADDR'] ?? '103.250.11.220'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Console - XcodeHoster</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { background-color: #0b0e14; color: #94a3b8; font-family: 'Inter', sans-serif; }
        .glass { background: rgba(22, 27, 34, 0.8); backdrop-filter: blur(12px); border: 1px solid rgba(48, 54, 61, 0.5); }
        .sidebar-active { background: linear-gradient(90deg, #1d4ed8 0%, transparent 100%); border-left: 4px solid #3b82f6; color: white; }
    </style>
</head>
<body class="flex h-screen overflow-hidden">
    <aside class="w-72 glass border-r border-gray-800 flex flex-col z-20">
        <div class="p-8">
            <div class="flex items-center space-x-3">
                <div class="bg-blue-600 p-2 rounded-xl text-white font-bold text-xl">XC</div>
                <div>
                    <h1 class="text-white font-black text-lg leading-none">XcodeHoster</h1>
                    <span class="text-[9px] text-blue-500 font-bold uppercase tracking-[0.2em]">Enterprise Panel</span>
                </div>
            </div>
        </div>
        <nav id="sidebar-nav" class="flex-1 px-4 space-y-1 text-sm">
            <p class="px-4 py-2 text-[10px] font-black text-gray-600 uppercase tracking-widest">Main Overview</p>
            <a href="/index.php" class="nav-link flex items-center space-x-3 p-3 hover:bg-gray-800 transition text-gray-400">
                <i class="fas fa-th-large w-5 text-center"></i><span>Dashboard</span>
            </a>
            <a href="/containers/" class="nav-link flex items-center space-x-3 p-3 hover:bg-gray-800 transition text-gray-400">
                <i class="fas fa-server w-5 text-center"></i><span>VPS Containers</span>
            </a>
            <p class="px-4 pt-6 py-2 text-[10px] font-black text-gray-600 uppercase tracking-widest">Advanced Tools</p>
            <a href="/console/" class="nav-link sidebar-active flex items-center space-x-3 p-3 rounded-xl transition text-white">
                <i class="fas fa-terminal w-5 text-center"></i><span>Virtual Console</span>
            </a>
            <a href="/firewall/" class="nav-link flex items-center space-x-3 p-3 hover:bg-gray-800 transition text-gray-400">
                <i class="fas fa-shield-alt w-5 text-center"></i><span>Security Firewall</span>
            </a>
            <a href="/settings/" class="nav-link flex items-center space-x-3 p-3 hover:bg-gray-800 transition text-gray-400">
                <i class="fas fa-cog w-5 text-center"></i><span>Global Settings</span>
            </a>
        </nav>
    </aside>

    <main class="flex-1 flex flex-col p-8">
        <header class="mb-6"><h2 class="text-2xl font-black text-white uppercase"><i class="fas fa-terminal mr-3 text-blue-500"></i> Root Console</h2></header>
        <div class="flex-1 rounded-3xl overflow-hidden border border-gray-800 shadow-2xl bg-black">
            <iframe id="terminal-iframe" src="/terminal/" style="width:100%; height:100%; border:none; background:black;"></iframe>
        </div>
    </main>

    <script>
        // Langkah 1: Paksa matikan fungsi onbeforeunload pada level window induk
        window.onbeforeunload = null;

        // Langkah 2: Intervensi semua klik pada link navigasi
        // Kita akan menghapus iframe terlebih dahulu sebelum pindah halaman
        // agar iframe tidak sempat mengirimkan sinyal "protes" ke browser.
        document.querySelectorAll('.nav-link').forEach(link => {
            link.addEventListener('click', function(e) {
                const targetUrl = this.getAttribute('href');
                
                // Cek jika link bukan halaman console itu sendiri
                if (targetUrl !== '/console/') {
                    e.preventDefault(); // Hentikan navigasi normal sebentar
                    
                    // Matikan proteksi unload secara paksa
                    window.onbeforeunload = null;
                    
                    // Hapus elemen iframe dari DOM agar koneksi terputus seketika
                    const iframe = document.getElementById('terminal-iframe');
                    if (iframe) {
                        iframe.parentNode.removeChild(iframe);
                    }
                    
                    // Pindah halaman dengan delay sangat singkat
                    setTimeout(() => {
                        window.location.href = targetUrl;
                    }, 10);
                }
            });
        });

        // Langkah 3: Tambahan proteksi global
        window.addEventListener('beforeunload', function (e) {
            e.stopImmediatePropagation();
            delete e['returnValue'];
        }, true);
    </script>
</body>
</html>
