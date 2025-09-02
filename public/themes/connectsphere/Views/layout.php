<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->renderSection('title') ?> - ConnectSphere</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .main-grid { display: grid; grid-template-columns: 25% 1fr 25%; gap: 1.5rem; }
    </style>
</head>
<body class="bg-slate-100">
    <div id="app" x-data="{}" class="min-h-screen">
        <!-- Header -->
        <header class="bg-white/80 backdrop-blur-md shadow-sm sticky top-0 z-40">
            <div class="container mx-auto px-4">
                <div class="flex justify-between items-center py-3">
                    <a href="#" class="text-2xl font-bold text-sky-500">ConnectSphere</a>
                    <div class="w-full max-w-md">
                        <input type="text" placeholder="Search ConnectSphere" class="w-full bg-slate-200 border border-slate-300 rounded-full px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500">
                    </div>
                    <div class="flex items-center space-x-4">
                        <a href="<?= site_url('/') ?>" class="text-slate-600 hover:text-sky-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                        </a>
                        <a href="<?= site_url('notifications') ?>" class="text-slate-600 hover:text-sky-500">
                             <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 10-12 0v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                        </a>
                         <a href="<?= site_url('messages') ?>" class="text-slate-600 hover:text-sky-500">
                           <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        </a>
                        <a href="<?= site_url('account') ?>">
                            <img src="https://placehold.co/40x40/38BDF8/FFFFFF?text=A" alt="User Avatar" class="w-10 h-10 rounded-full cursor-pointer">
                        </a>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="container mx-auto px-4 py-6">
            <?= $this->renderSection('content') ?>
        </main>
    </div>
</body>
</html>
