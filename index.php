<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>XcodeHoster - VPS Docker Panel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { background-color: #0d1117; color: #c9d1d9; font-family: sans-serif; }
        .sidebar { background-color: #161b22; }
        .card { background-color: #161b22; border: 1px solid #30363d; }
    </style>
</head>
<body class="flex h-screen">
    <div class="w-64 sidebar p-6 border-r border-gray-800">
        <h1 class="text-blue-400 font-bold text-xl mb-10 flex items-center">
            <span class="mr-2 text-2xl">XC</span> XcodeHoster
        </h1>
        <nav class="space-y-4">
            <a href="#" class="block p-3 bg-blue-600 text-white rounded-lg shadow-lg">Dashboard</a>
            <a href="#" class="block p-3 hover:bg-gray-800 rounded-lg transition">VPS Containers</a>
            <a href="#" class="block p-3 text-gray-500 cursor-not-allowed">Terminal (Maintenance)</a>
        </nav>
    </div>

    <div class="flex-1 p-10 overflow-y-auto">
        <div class="flex justify-between items-center mb-10">
            <h2 class="text-3xl font-bold text-white">Dashboard</h2>
            <div class="flex items-center space-x-2 bg-gray-800 px-4 py-2 rounded-full border border-gray-700">
                <span class="w-3 h-3 bg-green-500 rounded-full animate-pulse"></span>
                <span class="text-sm font-mono">103.250.11.220</span>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
            <div class="card p-6 rounded-xl">
                <p class="text-gray-400 text-sm uppercase font-semibold">Total VPS</p>
                <p class="text-4xl font-bold text-white mt-2">1</p>
            </div>
            <div class="card p-6 rounded-xl">
                <p class="text-gray-400 text-sm uppercase font-semibold">Status</p>
                <p class="text-4xl font-bold text-green-500 mt-2">Active</p>
            </div>
        </div>

        <div class="card rounded-xl overflow-hidden shadow-2xl">
            <div class="p-6 border-b border-gray-800 bg-gray-900/50">
                <h3 class="font-bold text-white">Active Containers</h3>
            </div>
            <table class="w-full text-left">
                <thead class="bg-gray-800/50 text-gray-400 text-sm">
                    <tr>
                        <th class="p-4 uppercase">Container Name</th>
                        <th class="p-4 uppercase">Image</th>
                        <th class="p-4 uppercase">Status</th>
                        <th class="p-4 uppercase text-center">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-800">
                    <tr class="hover:bg-gray-800/30 transition">
                        <td class="p-4 font-mono text-blue-400">vps-anak-buah</td>
                        <td class="p-4">ubuntu:latest</td>
                        <td class="p-4">
                            <span class="bg-green-900/50 text-green-400 px-3 py-1 rounded-full text-xs border border-green-800">Running</span>
                        </td>
                        <td class="p-4 text-center">
                            <button class="bg-gray-700 text-gray-400 px-4 py-2 rounded-lg text-sm cursor-not-allowed">Manage</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
