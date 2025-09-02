<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Serendipity - Meaningful Connections Await</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;700&family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet">

    <!-- Stylesheets -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="<?= service('theme')->asset('css/main.css') ?>">

</head>
<body class="bg-off-white text-slate-800 flex flex-col min-h-screen">

    <!-- Header -->
    <header class="bg-white shadow-md">
        <div class="container py-4 flex justify-between items-center">
            <a href="<?= route_to('home') ?>" class="text-3xl font-bold text-ruby font-serif">
                Serendipity
            </a>
            <nav class="hidden md:flex items-center space-x-6">
                <?php $current_path = uri_string() === '/' ? '' : uri_string(); ?>
                <a href="<?= site_url(route_to('home')) ?>" class="<?= ($current_path === '' || $current_path === 'discover') ? 'active' : '' ?> text-slate-700 hover:text-ruby transition font-medium">Discover</a>
                <a href="<?= site_url(route_to('feed')) ?>" class="<?= str_starts_with($current_path, 'feed') ? 'active' : '' ?> text-slate-700 hover:text-ruby transition font-medium">Feed</a>
                <a href="<?= site_url(route_to('connections')) ?>" class="<?= str_starts_with($current_path, 'connections') ? 'active' : '' ?> text-slate-700 hover:text-ruby transition font-medium">Connections</a>
                <a href="<?= site_url(route_to('messages')) ?>" class="<?= str_starts_with($current_path, 'messages') ? 'active' : '' ?> text-slate-700 hover:text-ruby transition font-medium">Messages</a>
                <a href="<?= site_url(route_to('account-info')) ?>" class="<?= str_starts_with($current_path, 'account') ? 'active' : '' ?> text-slate-700 hover:text-ruby transition font-medium">My Account</a>
                <a href="<?= site_url(route_to('logout')) ?>" class="btn btn-primary">Logout</a>
            </nav>
        </div>
    </header>

    <!-- Main Content -->
    <main class="container py-8 flex-grow">
        <?= $this->renderSection('content') ?>
    </main>

    <!-- Footer -->
    <footer class="bg-white py-8 border-t border-slate-200">
        <div class="container text-center text-gray-500">
            <p>&copy; <?= date('Y') ?> Serendipity. All Rights Reserved.</p>
            <div class="mt-4 flex justify-center space-x-6">
                <a href="#" class="hover:text-ruby"><i class="fab fa-twitter"></i></a>
                <a href="#" class="hover:text-ruby"><i class="fab fa-instagram"></i></a>
                <a href="#" class="hover:text-ruby"><i class="fab fa-facebook"></i></a>
            </div>
        </div>
    </footer>

    <?= $this->renderSection('scripts') ?>
</body>
</html>
