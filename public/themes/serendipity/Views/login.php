<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Serendipity</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;700&family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= service('theme')->asset('css/main.css') ?>">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-off-white">

    <div class="flex items-center justify-center min-h-screen">
        <div class="w-full max-w-md p-8 space-y-6 bg-white rounded-lg shadow-md">
            <div class="text-center">
                <a href="/" class="text-4xl font-bold text-ruby font-serif">Serendipity</a>
                <h2 class="mt-2 text-2xl font-semibold text-slate-800">Welcome Back</h2>
                <p class="text-slate-600">Login to continue your journey.</p>
            </div>

            <?php if (session('error') !== null) : ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <?= esc(session('error')) ?>
                </div>
            <?php elseif (session('errors') !== null) : ?>
                 <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <?php if (is_array(session('errors'))) : ?>
                        <?php foreach (session('errors') as $error) : ?>
                            <?= esc($error) ?><br>
                        <?php endforeach ?>
                    <?php else : ?>
                        <?= esc(session('errors')) ?>
                    <?php endif ?>
                </div>
            <?php endif ?>

            <form action="<?= url_to('login') ?>" method="post" class="space-y-4">
                <?= csrf_field() ?>

                <div>
                    <label for="email" class="block text-sm font-medium text-slate-700">Email Address</label>
                    <input type="email" name="email" id="email" class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-pink focus:ring-pink" value="<?= old('email') ?>" required>
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-slate-700">Password</label>
                    <input type="password" name="password" id="password" class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-pink focus:ring-pink" required>
                </div>

                <?php if (setting('Auth.sessionConfig')['allowRemembering']): ?>
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember" name="remember" type="checkbox" class="h-4 w-4 text-pink rounded border-slate-300 focus:ring-pink" <?php if (old('remember')): ?> checked<?php endif ?>>
                        <label for="remember" class="ml-2 block text-sm text-slate-900">Remember me</label>
                    </div>
                </div>
                <?php endif; ?>

                <div>
                    <button type="submit" class="w-full btn btn-primary py-2.5">Login</button>
                </div>
            </form>

            <p class="text-center text-sm text-slate-600">
                <?php if (setting('Auth.allowRegistration')) : ?>
                    Don't have an account? <a href="<?= url_to('register') ?>" class="font-medium text-ruby hover:underline">Sign up</a>
                <?php endif ?>
            </p>
        </div>
    </div>

</body>
</html>
