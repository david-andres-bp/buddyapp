<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HeartBeat - Your Story Starts Here</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700&family=Lora:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #F8F9FA; }
        .font-serif { font-family: 'Lora', serif; }
        .text-coral { color: #FF6B6B; }
        .bg-coral { background-color: #FF6B6B; }
        .text-indigo { color: #4F46E5; }
        .bg-indigo { background-color: #4F46E5; }
        .text-yellow { color: #FFD166; }
        .bg-yellow { background-color: #FFD166; }
        .text-near-black { color: #212529; }
    </style>
</head>
<body class="text-near-black">

    <!-- Header -->
    <header class="bg-indigo text-white shadow-md">
        <div class="max-w-6xl mx-auto px-4 py-4 flex justify-between items-center">
            <a href="<?= route_to('home') ?>" class="flex items-center space-x-2">
                <i class="fas fa-heart text-white text-2xl"></i>
                <span class="text-3xl font-bold font-serif">HeartBeat</span>
            </a>
            <nav class="hidden md:flex items-center space-x-6">
                <a href="<?= route_to('home') ?>" class="hover:text-coral transition">Discover</a>
                <a href="<?= route_to('groups') ?>" class="hover:text-coral transition">Groups</a>
                <a href="<?= route_to('connections') ?>" class="hover:text-coral transition">Connections</a>
                <a href="<?= route_to('messages') ?>" class="hover:text-coral transition">Messages</a>
                <a href="<?= route_to('account-info') ?>" class="hover:text-coral transition">My Account</a>
                <a href="<?= route_to('logout') ?>" class="bg-coral text-white font-semibold px-5 py-2 rounded-full hover:bg-coral-dark transition">Logout</a>
            </nav>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-6xl mx-auto px-4 py-8">
        <?= $content ?? '' ?>
    </main>

    <!-- Footer -->
    <footer class="bg-white py-8 mt-16">
        <div class="max-w-6xl mx-auto px-4 text-center text-gray-500">
            <p>&copy; <?= date('Y') ?> HeartBeat. A new chapter in dating.</p>
        </div>
    </footer>

    <?= $this->renderSection('scripts') ?>
</body>
</html>
