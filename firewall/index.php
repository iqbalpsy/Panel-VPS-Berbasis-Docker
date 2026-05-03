<?php $server_ip = $_SERVER['SERVER_ADDR'] ?? '103.250.11.220'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Firewall - XcodeHoster</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
                <div class="bg-blue-600 p-2 rounded-xl text-white font-bold text-xl shadow-lg shadow-blue-900/20">XC</div>
                <div>
                    <h1 class="text-white font-black text-lg leading-none">XcodeHoster</h1>
                    <span class="text-[9px] text-blue-500 font-bold uppercase tracking-[0.2em]">Enterprise Panel</span>
                </div>
            </div>
        </div>

        <nav class="flex-1 px-4 space-y-1 text-sm">
            <p class="px-4 py-2 text-[10px] font-black text-gray-600 uppercase tracking-widest">Main Overview</p>
            <a href="/index.php" class="flex items-center space-x-3 p-3 hover:bg-gray-800 transition text-gray-400">
                <i class="fas fa-th-large w-5 text-center"></i><span>Dashboard</span>
            </a>
            <a href="/containers/" class="flex items-center space-x-3 p-3 hover:bg-gray-800 transition text-gray-400">
                <i class="fas fa-server w-5 text-center"></i><span>VPS Containers</span>
            </a>
            
            <p class="px-4 pt-6 py-2 text-[10px] font-black text-gray-600 uppercase tracking-widest">Advanced Tools</p>
            <a href="/console/" class="flex items-center space-x-3 p-3 hover:bg-gray-800 transition text-gray-400">
                <i class="fas fa-terminal w-5 text-center"></i><span>Virtual Console</span>
            </a>
            <a href="/firewall/" class="sidebar-active flex items-center space-x-3 p-3 rounded-xl transition text-white">
                <i class="fas fa-shield-alt w-5 text-center"></i><span>Security Firewall</span>
            </a>
            <a href="/settings/" class="flex items-center space-x-3 p-3 hover:bg-gray-800 transition text-gray-400 hover:text-white">
                <i class="fas fa-cog w-5 text-center"></i><span>Global Settings</span>
            </a>
        </nav>

        <div class="p-6 border-t border-gray-800 bg-gray-900/20">
            <div class="flex items-center space-x-3 p-2 rounded-xl hover:bg-gray-800 transition cursor-pointer">
                <div class="w-10 h-10 bg-gradient-to-br from-blue-600 to-purple-700 rounded-full flex items-center justify-center text-white font-bold border-2 border-gray-800">A</div>
                <div class="overflow-hidden">
                    <p class="text-xs text-white font-bold truncate">Administrator</p>
                    <p class="text-[10px] text-blue-400 font-mono"><?= $server_ip ?></p>
                </div>
            </div>
        </div>
    </aside>

    <main class="flex-1 overflow-y-auto p-8 relative">
        <div class="absolute top-0 right-0 w-96 h-96 bg-blue-600/5 rounded-full blur-[100px] -z-10"></div>

        <header class="flex justify-between items-end mb-10">
            <div>
                <nav class="text-[10px] uppercase font-bold text-gray-500 mb-2 tracking-widest">Tools / Security</nav>
                <h2 class="text-4xl font-black text-white tracking-tight uppercase">Security Firewall</h2>
            </div>
        </header>

        <div class="glass p-8 rounded-3xl max-w-lg border border-blue-500/20 shadow-2xl">
            <p class="text-sm mb-6 text-gray-400 italic">Konfigurasi izin port server Anda secara otomatis untuk menjaga keamanan instance.</p>
            
            <form class="space-y-6">
                <div>
                    <label class="text-[10px] font-black uppercase text-gray-500 tracking-widest block mb-2 px-1 text-left">Service Port</label>
                    <input type="text" placeholder="e.g. 8080" 
                           class="w-full bg-gray-900 border border-gray-800 p-4 rounded-2xl text-white outline-none focus:border-blue-500 transition font-mono">
                </div>
                
                <div>
                    <label class="text-[10px] font-black uppercase text-gray-500 tracking-widest block mb-2 px-1 text-left">Action Strategy</label>
                    <select class="w-full bg-gray-900 border border-gray-800 p-4 rounded-2xl text-white outline-none font-bold focus:border-blue-500 transition">
                        <option>ALLOW ACCESS</option>
                        <option>DENY ACCESS</option>
                    </select>
                </div>

                <div class="pt-4">
                    <button type="button" class="w-full bg-blue-600 hover:bg-blue-500 text-white p-4 rounded-2xl font-black uppercase tracking-widest text-[10px] shadow-lg shadow-blue-900/40 transition-all transform active:scale-95">
                        Apply Firewall Rules
                    </button>
                </div>
            </form>
        </div>
    </main>

</body>
</html>
