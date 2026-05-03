<?php
// Ambil data Docker untuk menampilkan angka di badge sidebar
$docker_ps = shell_exec("/usr/bin/docker ps -a --format '{{.Names}}' 2>&1");
$containers = array_filter(explode("\n", trim($docker_ps)));
$total_vps = count($containers);
$server_ip = $_SERVER['SERVER_ADDR'] ?? '103.250.11.220';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Global Settings - XcodeHoster</title>
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
                <span class="ml-auto bg-gray-800 text-[10px] px-2 py-0.5 rounded-md border border-gray-700"><?= $total_vps ?></span>
            </a>
            
            <p class="px-4 pt-6 py-2 text-[10px] font-black text-gray-600 uppercase tracking-widest">Advanced Tools</p>
            <a href="/console/" class="flex items-center space-x-3 p-3 hover:bg-gray-800 transition text-gray-400">
                <i class="fas fa-terminal w-5 text-center"></i><span>Virtual Console</span>
            </a>
            <a href="/firewall/" class="flex items-center space-x-3 p-3 hover:bg-gray-800 transition text-gray-400">
                <i class="fas fa-shield-alt w-5 text-center"></i><span>Security Firewall</span>
            </a>
            <a href="/settings/" class="sidebar-active flex items-center space-x-3 p-3 rounded-xl transition text-white">
                <i class="fas fa-cog w-5 text-center"></i><span>Global Settings</span>
            </a>
        </nav>

        <div class="p-6 border-t border-gray-800 bg-gray-900/20 text-xs">
            <p class="text-white font-bold truncate">Administrator</p>
            <p class="text-blue-400 font-mono text-[10px]"><?= $server_ip ?></p>
        </div>
    </aside>

    <main class="flex-1 overflow-y-auto p-8 relative">
        <div class="absolute top-0 right-0 w-96 h-96 bg-blue-600/5 rounded-full blur-[100px] -z-10"></div>

        <header class="flex justify-between items-end mb-10">
            <div>
                <nav class="text-[10px] uppercase font-bold text-gray-500 mb-2 tracking-widest">Home / Settings</nav>
                <h2 class="text-4xl font-black text-white tracking-tight uppercase">Global Settings</h2>
            </div>
        </header>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="glass p-8 rounded-3xl border border-gray-800/50 shadow-2xl">
                <div class="flex items-center space-x-3 mb-6">
                    <i class="fas fa-user-circle text-blue-500 text-xl"></i>
                    <h3 class="text-white font-black uppercase text-xs tracking-widest">Profile Information</h3>
                </div>
                <div class="space-y-4">
                    <div class="flex justify-between items-center text-sm border-b border-gray-800/50 pb-3">
                        <span class="text-gray-500 font-bold uppercase text-[10px]">Current Username</span>
                        <span class="text-white font-mono bg-gray-800 px-3 py-1 rounded-lg">Admin</span>
                    </div>
                    <div class="flex justify-between items-center text-sm">
                        <span class="text-gray-500 font-bold uppercase text-[10px]">Access Level</span>
                        <span class="text-green-500 font-black uppercase text-[10px] tracking-tighter">Super Admin Privilege</span>
                    </div>
                </div>
            </div>

            <div class="glass p-8 rounded-3xl border border-red-500/20 shadow-2xl">
                <div class="flex items-center space-x-3 mb-6">
                    <i class="fas fa-exclamation-triangle text-red-500 text-xl"></i>
                    <h3 class="text-red-500 font-black uppercase text-xs tracking-widest">Danger Zone</h3>
                </div>
                <p class="text-gray-500 text-xs mb-6 italic">Tindakan di bawah ini bersifat permanen dan tidak dapat dibatalkan.</p>
                <button class="w-full bg-red-600/10 border border-red-500/50 hover:bg-red-600 hover:text-white transition-all text-red-500 p-4 rounded-2xl text-[10px] font-black uppercase tracking-[0.2em] shadow-lg shadow-red-900/10">
                    <i class="fas fa-trash-alt mr-2"></i> Clear All System Logs
                </button>
            </div>
        </div>
    </main>

</body>
</html>
