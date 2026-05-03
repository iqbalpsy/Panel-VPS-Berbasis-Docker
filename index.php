<?php
// Ambil data Docker Real-time
$docker_ps = shell_exec("/usr/bin/docker ps -a --format '{{.Names}}|{{.Image}}|{{.Status}}|{{.Ports}}' 2>&1");
$containers = array_filter(explode("\n", trim($docker_ps)));
$total_vps = count($containers);

// Logika hitung running
$running_vps = 0;
if (!empty($docker_ps)) {
    $running_vps = substr_count(strtolower($docker_ps), 'up');
}

// Info Server & Resource
$server_ip = $_SERVER['SERVER_ADDR'] ?? '103.250.11.220';
$php_version = phpversion();
$load = sys_getloadavg();
$mem_info = shell_exec("free -m");
preg_match('/Mem:\s+(\d+)\s+(\d+)/', $mem_info, $matches);
$mem = isset($matches[1]) ? ($matches[2] / $matches[1]) * 100 : 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>XcodeHoster Pro - Control Center</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body { background-color: #0b0e14; color: #94a3b8; font-family: 'Inter', sans-serif; }
        .glass { background: rgba(22, 27, 34, 0.8); backdrop-filter: blur(12px); border: 1px solid rgba(48, 54, 61, 0.5); }
        .sidebar-active { background: linear-gradient(90deg, #1d4ed8 0%, transparent 100%); border-left: 4px solid #3b82f6; color: white; }
        .card-stat { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); position: relative; overflow: hidden; }
        .card-stat:hover { transform: translateY(-5px); border-color: #3b82f6; }
        .status-pulse { position: relative; }
        .status-pulse::after { content: ''; position: absolute; width: 100%; height: 100%; background: inherit; border-radius: 50%; opacity: 0.6; animation: pulse 2s infinite; }
        @keyframes pulse { 0% { transform: scale(1); opacity: 0.6; } 100% { transform: scale(2.5); opacity: 0; } }
        .card-icon-bg { position: absolute; right: -10px; bottom: -10px; font-size: 5rem; opacity: 0.05; transform: rotate(-15deg); pointer-events: none; transition: 0.3s; }
        .card-stat:hover .card-icon-bg { opacity: 0.1; transform: rotate(0deg) scale(1.1); }
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
            <a href="/index.php" class="sidebar-active flex items-center space-x-3 p-3 rounded-xl transition">
                <i class="fas fa-th-large w-5 text-center"></i><span>Dashboard</span>
            </a>
            <a href="/containers/" class="flex items-center space-x-3 p-3 hover:bg-gray-800/50 rounded-xl transition text-gray-400">
                <i class="fas fa-server w-5 text-center"></i><span>VPS Containers</span>
                <span class="ml-auto bg-gray-800 text-[10px] px-2 py-0.5 rounded-md border border-gray-700"><?= $total_vps ?></span>
            </a>
            
            <p class="px-4 pt-6 py-2 text-[10px] font-black text-gray-600 uppercase tracking-widest">Advanced Tools</p>
            <a href="/console/" class="flex items-center space-x-3 p-3 hover:bg-gray-800/50 rounded-xl transition text-gray-400">
                <i class="fas fa-terminal w-5 text-center"></i><span>Virtual Console</span>
            </a>
            <a href="/firewall/" class="flex items-center space-x-3 p-3 hover:bg-gray-800/50 rounded-xl transition text-gray-400 hover:text-white">
                <i class="fas fa-shield-alt w-5 text-center"></i><span>Security Firewall</span>
            </a>
            <a href="/settings/" class="flex items-center space-x-3 p-3 hover:bg-gray-800/50 rounded-xl transition text-gray-400 hover:text-white">
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
                <nav class="text-[10px] uppercase font-bold text-gray-500 mb-2 tracking-widest">Home / Dashboard</nav>
                <h2 class="text-4xl font-black text-white tracking-tight">Control Center</h2>
            </div>
            <div class="glass px-4 py-2 rounded-2xl flex items-center space-x-3 border-gray-700/50">
                <div class="text-right">
                    <p class="text-[10px] text-gray-500 uppercase font-black">System Time</p>
                    <p class="text-xs text-white font-mono" id="current-time"><?= date('H:i:s') ?></p>
                </div>
                <div class="h-8 w-[1px] bg-gray-700"></div>
                <div class="flex flex-col items-center">
                    <span class="w-2 h-2 bg-green-500 rounded-full status-pulse"></span>
                </div>
            </div>
        </header>

        <div id="stats-grid" class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-10">
            <div class="glass p-6 rounded-3xl card-stat group">
                <i class="fas fa-server card-icon-bg"></i>
                <p class="text-[10px] font-black text-gray-500 uppercase tracking-[0.15em] mb-1">Total VPS</p>
                <h3 class="text-3xl font-black text-white"><?= $total_vps ?></h3>
                <div class="flex items-center mt-3 space-x-2">
                    <div class="w-full h-1 bg-gray-800 rounded-full overflow-hidden"><div class="h-full bg-blue-600 w-1/3"></div></div>
                    <span class="text-[9px] text-gray-500 font-bold whitespace-nowrap uppercase italic">Container Terdaftar</span>
                </div>
            </div>
            <div class="glass p-6 rounded-3xl card-stat group">
                <i class="fas fa-play card-icon-bg"></i>
                <p class="text-[10px] font-black text-gray-500 uppercase tracking-[0.15em] mb-1">Active</p>
                <h3 class="text-3xl font-black text-white"><?= $running_vps ?></h3>
                <div class="flex items-center mt-3 space-x-2">
                    <div class="w-full h-1 bg-gray-800 rounded-full overflow-hidden"><div class="h-full bg-green-600 w-1/4"></div></div>
                    <span class="text-[9px] text-gray-500 font-bold whitespace-nowrap uppercase italic">Sedang Berjalan</span>
                </div>
            </div>
            <div class="glass p-6 rounded-3xl card-stat group">
                <i class="fas fa-microchip card-icon-bg"></i>
                <p class="text-[10px] font-black text-gray-500 uppercase tracking-[0.15em] mb-1">CPU Load</p>
                <h3 class="text-3xl font-black text-white"><?= round($load[0] ?? 0, 2) ?></h3>
                <div class="flex items-center mt-3 space-x-2">
                    <div class="w-full h-1 bg-gray-800 rounded-full overflow-hidden"><div class="h-full bg-purple-600 w-1/2"></div></div>
                    <span class="text-[9px] text-gray-500 font-bold whitespace-nowrap uppercase italic">System Load 1m</span>
                </div>
            </div>
            <div class="glass p-6 rounded-3xl card-stat group">
                <i class="fas fa-memory card-icon-bg"></i>
                <p class="text-[10px] font-black text-gray-500 uppercase tracking-[0.15em] mb-1">RAM Usage</p>
                <h3 class="text-3xl font-black text-white"><?= round((float)$mem, 1) ?>%</h3>
                <div class="flex items-center mt-3 space-x-2">
                    <div class="w-full h-1 bg-gray-800 rounded-full overflow-hidden"><div class="h-full bg-orange-600 w-2/3"></div></div>
                    <span class="text-[9px] text-gray-500 font-bold whitespace-nowrap uppercase italic">Memory Terpakai</span>
                </div>
            </div>
        </div>

        <section class="glass rounded-3xl overflow-hidden shadow-2xl border border-gray-800/50 mb-10">
            <div class="p-6 bg-gray-900/40 border-b border-gray-800/50 flex justify-between items-center">
                <div class="flex items-center space-x-3">
                    <div class="w-1 h-6 bg-blue-600 rounded-full shadow-[0_0_10px_#2563eb]"></div>
                </div>
                <button onclick="openModal()" class="bg-blue-600 hover:bg-blue-500 text-white px-5 py-2 rounded-xl text-xs font-black transition-all shadow-lg active:scale-95">
                    <i class="fas fa-plus-circle mr-2"></i> DEPLOY NEW VPS
                </button>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-gray-800/20 text-gray-500 text-[10px] uppercase font-black tracking-widest border-b border-gray-800/50">
                        <tr>
                            <th class="p-5">Name & ID</th>
                            <th class="p-5">Deployment Info</th>
                            <th class="p-5">Network / Port</th>
                            <th class="p-5">Health Status</th>
                            <th class="p-5 text-center">Power Control</th>
                        </tr>
                    </thead>
                    <tbody id="vps-table-body" class="divide-y divide-gray-800/50">
                        <?php foreach ($containers as $line): if(empty($line)) continue; 
                            list($name, $image, $status, $ports) = explode("|", $line);
                            $isRunning = (stripos($status, 'Up') !== false);
                        ?>
                        <tr class="hover:bg-blue-600/5 transition-colors group">
                            <td class="p-5">
                                <div class="flex items-center space-x-3">
                                    <div class="bg-gray-800 p-2 rounded-lg text-blue-400 group-hover:bg-blue-600 transition"><i class="fas fa-cube"></i></div>
                                    <div>
                                        <p class="font-black text-white text-sm"><?= $name ?></p>
                                        <p class="text-[10px] text-gray-600 font-mono">ID: <?= substr(md5($name), 0, 8) ?></p>
                                    </div>
                                </div>
                            </td>
                            <td class="p-5 text-[11px] text-gray-300 font-bold"><?= $image ?></td>
                            <td class="p-5 font-mono text-xs text-blue-500 font-bold">1362 <span class="text-gray-700 mx-1">→</span> <span class="text-gray-400"><?= $name ?>.xcode.id</span></td>
                            <td class="p-5">
                                <div class="flex items-center space-x-2">
                                    <span class="w-2 h-2 rounded-full <?= $isRunning ? 'bg-green-500 shadow-[0_0_8px_#22c55e]' : 'bg-red-500' ?>"></span>
                                    <span class="<?= $isRunning ? 'text-green-500' : 'text-red-500' ?> text-[10px] font-black uppercase tracking-widest">
                                        <?= $isRunning ? 'RUNNING' : 'OFFLINE' ?>
                                    </span>
                                </div>
                                <p class="text-[9px] text-gray-600 mt-1 uppercase"><?= $status ?></p>
                            </td>
                            <td class="p-5 text-center">
                                <div class="flex justify-center items-center space-x-2">
                                    <a href="/action.php?do=start&name=<?= $name ?>" class="action-btn w-8 h-8 flex items-center justify-center bg-gray-800 hover:bg-green-600 rounded-lg text-white shadow-md active:scale-75 transition-all"><i class="fas fa-play text-[10px]"></i></a>
                                    <a href="/action.php?do=stop&name=<?= $name ?>" class="action-btn w-8 h-8 flex items-center justify-center bg-gray-800 hover:bg-red-600 rounded-lg text-white shadow-md active:scale-75 transition-all"><i class="fas fa-stop text-[10px]"></i></a>
                                    <a href="/action.php?do=restart&name=<?= $name ?>" class="action-btn w-8 h-8 flex items-center justify-center bg-gray-800 hover:bg-blue-600 rounded-lg text-white shadow-md active:scale-75 transition-all"><i class="fas fa-sync-alt text-[10px]"></i></a>
                                    <a href="/action.php?do=delete&name=<?= $name ?>" class="action-btn w-8 h-8 flex items-center justify-center bg-gray-800 hover:bg-red-500 rounded-lg text-white shadow-md active:scale-75 transition-all"><i class="fas fa-trash text-[10px]"></i></a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </section>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-10">
            <div class="glass p-8 rounded-3xl lg:col-span-1 border border-gray-800/50">
                <div class="flex items-center justify-between mb-8">
                    <h3 class="font-black text-white text-lg tracking-tight uppercase">Node Engine</h3>
                    <i class="fas fa-microchip text-blue-500"></i>
                </div>
                <div class="space-y-4 text-xs font-bold text-left">
                    <div class="flex justify-between border-b border-gray-800 pb-2">
                        <span class="text-gray-500 uppercase tracking-widest text-[9px]">Server IP</span>
                        <span class="text-white font-mono"><?= $server_ip ?></span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500 uppercase tracking-widest text-[9px]">PHP Env</span>
                        <span class="text-blue-500"><?= $php_version ?></span>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <div id="deployModal" class="fixed inset-0 bg-black/90 backdrop-blur-md hidden z-[100] flex items-center justify-center p-4">
        <div class="glass w-full max-w-md p-8 rounded-[2rem] border-blue-500/30 shadow-2xl">
            <h3 class="text-2xl font-black text-white mb-6 flex items-center uppercase tracking-tight">
                <i class="fas fa-rocket mr-3 text-blue-500"></i> Deploy New VPS
            </h3>
            <form action="/deploy.php" method="POST" class="space-y-5">
                <div>
                    <label class="text-[10px] font-black uppercase text-gray-500 tracking-[0.2em] block mb-2 px-1 text-left">Instance Name</label>
                    <input type="text" name="vps_name" placeholder="e.g. server-pro-01" required 
                           class="w-full bg-gray-900 border border-gray-800 p-4 rounded-2xl text-white focus:border-blue-500 outline-none transition font-mono text-sm">
                </div>
                <div>
                    <label class="text-[10px] font-black uppercase text-gray-500 tracking-[0.2em] block mb-2 px-1 text-left">Select OS Image</label>
                    <select name="os_image" class="w-full bg-gray-900 border border-gray-800 p-4 rounded-2xl text-white focus:border-blue-500 outline-none transition font-bold text-sm">
                        <option value="ubuntu:latest">Ubuntu 24.04 LTS</option>
                        <option value="debian:latest">Debian 12 Bookworm</option>
                        <option value="nginx:latest">Nginx Web Server</option>
                    </select>
                </div>
                <div class="flex space-x-3 pt-4">
                    <button type="button" onclick="closeModal()" class="flex-1 bg-gray-800 text-white p-4 rounded-2xl font-black uppercase tracking-widest text-[10px] hover:bg-gray-700 transition">Cancel</button>
                    <button type="submit" class="flex-1 bg-blue-600 text-white p-4 rounded-2xl font-black uppercase tracking-widest text-[10px] hover:bg-blue-500 transition">Launch VPS</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openModal() { $('#deployModal').removeClass('hidden').addClass('flex'); }
        function closeModal() { $('#deployModal').addClass('hidden').removeClass('flex'); }

        setInterval(() => {
            const now = new Date();
            $('#current-time').text(now.toLocaleTimeString('en-GB'));
        }, 1000);

        $(document).on('click', '.action-btn', function(e) {
            e.preventDefault();
            const url = $(this).attr('href');
            const $row = $(this).closest('tr');
            if (url.includes('do=delete') && !confirm('Hapus VPS ini secara permanen?')) return false;
            $row.addClass('opacity-50 pointer-events-none');
            $.get(url, function() { setTimeout(refreshData, 1500); }).fail(function() { alert("Gagal menghubungi server."); }).always(() => { setTimeout(() => $row.removeClass('opacity-50 pointer-events-none'), 2000); });
        });

        function refreshData() {
            $('#vps-table-body').load(window.location.href + ' #vps-table-body > *');
            $('#stats-grid').load(window.location.href + ' #stats-grid > *');
        }
        setInterval(refreshData, 5000);
    </script>
</body>
</html>
