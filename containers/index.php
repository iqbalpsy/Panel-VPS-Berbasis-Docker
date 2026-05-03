<?php
$docker_ps = shell_exec("/usr/bin/docker ps -a --format '{{.Names}}|{{.Image}}|{{.Status}}|{{.Ports}}' 2>&1");
$containers = array_filter(explode("\n", trim($docker_ps)));
$total_vps = count($containers);
$server_ip = $_SERVER['SERVER_ADDR'] ?? '103.250.11.220';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>VPS Containers - XcodeHoster</title>
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
        <div class="p-8"><div class="flex items-center space-x-3"><div class="bg-blue-600 p-2 rounded-xl text-white font-bold text-xl">XC</div><div><h1 class="text-white font-black text-lg leading-none">XcodeHoster</h1><span class="text-[9px] text-blue-500 font-bold uppercase tracking-[0.2em]">Enterprise Panel</span></div></div></div>
        <nav class="flex-1 px-4 space-y-1 text-sm">
            <p class="px-4 py-2 text-[10px] font-black text-gray-600 uppercase tracking-widest">Main Overview</p>
            <a href="/index.php" class="flex items-center space-x-3 p-3 hover:bg-gray-800 transition text-gray-400"><i class="fas fa-th-large w-5 text-center"></i><span>Dashboard</span></a>
            <a href="/containers/" class="sidebar-active flex items-center space-x-3 p-3 rounded-xl transition"><i class="fas fa-server w-5 text-center"></i><span>VPS Containers</span></a>
            <p class="px-4 pt-6 py-2 text-[10px] font-black text-gray-600 uppercase tracking-widest">Advanced Tools</p>
            <a href="/console/" class="flex items-center space-x-3 p-3 hover:bg-gray-800 transition text-gray-400"><i class="fas fa-terminal w-5 text-center"></i><span>Virtual Console</span></a>
            <a href="/firewall/" class="flex items-center space-x-3 p-3 hover:bg-gray-800 transition text-gray-400"><i class="fas fa-shield-alt w-5 text-center"></i><span>Security Firewall</span></a>
            <a href="/settings/" class="flex items-center space-x-3 p-3 hover:bg-gray-800 transition text-gray-400"><i class="fas fa-cog w-5 text-center"></i><span>Global Settings</span></a>
        </nav>
        <div class="p-6 border-t border-gray-800 bg-gray-900/20 text-xs truncate"><p class="text-white font-bold">Administrator</p><p class="text-blue-400 font-mono"><?= $server_ip ?></p></div>
    </aside>

    <main class="flex-1 overflow-y-auto p-8 relative">
        <header class="mb-10"><h2 class="text-4xl font-black text-white tracking-tight">VPS CONTAINERS</h2></header>
        <section class="glass rounded-3xl overflow-hidden shadow-2xl border border-gray-800/50">
            <div class="p-6 bg-gray-900/40 border-b border-gray-800/50 flex justify-between items-center"><h3 class="font-black text-white text-lg tracking-tight uppercase">Active Instances</h3></div>
            <div class="overflow-x-auto"><table class="w-full text-left border-collapse">
                <thead class="bg-gray-800/20 text-gray-500 text-[10px] uppercase font-black border-b border-gray-800/50"><tr><th class="p-5">Name</th><th class="p-5">Image</th><th class="p-5">Status</th><th class="p-5 text-center">Power Control</th></tr></thead>
                <tbody id="vps-table-body" class="divide-y divide-gray-800/50">
                    <?php foreach ($containers as $line): if(empty($line)) continue; list($name, $image, $status, $ports) = explode("|", $line); $isRunning = (stripos($status, 'Up') !== false); ?>
                    <tr class="hover:bg-blue-600/5 transition-colors group"><td class="p-5 font-bold text-white"><?= $name ?></td><td class="p-5 text-xs font-bold text-gray-500"><?= $image ?></td><td class="p-5"><span class="<?= $isRunning ? 'text-green-500' : 'text-red-500' ?> text-[10px] font-black"><?= $isRunning ? '● RUNNING' : '○ OFFLINE' ?></span></td>
                    <td class="p-5 text-center"><div class="flex justify-center items-center space-x-2">
                        <a href="/action.php?do=start&name=<?= $name ?>" class="action-btn w-8 h-8 flex items-center justify-center bg-gray-800 hover:bg-green-600 rounded-lg text-white"><i class="fas fa-play text-[10px]"></i></a>
                        <a href="/action.php?do=stop&name=<?= $name ?>" class="action-btn w-8 h-8 flex items-center justify-center bg-gray-800 hover:bg-red-600 rounded-lg text-white"><i class="fas fa-stop text-[10px]"></i></a>
                        <a href="/action.php?do=delete&name=<?= $name ?>" class="action-btn w-8 h-8 flex items-center justify-center bg-gray-800 hover:bg-red-500 rounded-lg text-white"><i class="fas fa-trash text-[10px]"></i></a>
                    </div></td></tr><?php endforeach; ?>
                </tbody></table></div></section>
    </main>
    <script>
        $(document).on('click', '.action-btn', function(e) { e.preventDefault(); const url = $(this).attr('href'); const $row = $(this).closest('tr'); if (url.includes('do=delete') && !confirm('Hapus VPS ini?')) return false; $row.addClass('opacity-50 pointer-events-none'); $.get(url, function() { $('#vps-table-body').load(window.location.href + ' #vps-table-body > *'); }).always(() => { $row.removeClass('opacity-50 pointer-events-none'); }); });
    </script>
</body>
</html>
