<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - ConnectSphere</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-slate-100">
    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="w-full max-w-md space-y-8">
            <div>
                <h1 class="text-center text-3xl font-bold text-sky-500">
                    ConnectSphere
                </h1>
                <h2 class="mt-2 text-center text-lg text-slate-600">
                    Create your new account
                </h2>
            </div>
            <div class="bg-white p-8 rounded-xl shadow-lg space-y-6">
                <form class="space-y-6" action="<?= site_url('register') ?>" method="POST">
                    <?= csrf_field() ?>
                    <div>
                        <label for="full-name" class="sr-only">Full Name</label>
                        <input id="full-name" name="name" type="text" autocomplete="name" required
                               class="w-full px-4 py-3 border border-slate-300 rounded-lg placeholder-slate-400 text-slate-900 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500"
                               placeholder="Full Name">
                    </div>
                     <div>
                        <label for="username" class="sr-only">Username</label>
                        <input id="username" name="username" type="text" autocomplete="username" required
                               class="w-full px-4 py-3 border border-slate-300 rounded-lg placeholder-slate-400 text-slate-900 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500"
                               placeholder="Username">
                    </div>
                    <div>
                        <label for="email-address" class="sr-only">Email address</label>
                        <input id="email-address" name="email" type="email" autocomplete="email" required
                               class="w-full px-4 py-3 border border-slate-300 rounded-lg placeholder-slate-400 text-slate-900 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500"
                               placeholder="Email address">
                    </div>
                    <div>
                        <label for="password" class="sr-only">Password</label>
                        <input id="password" name="password" type="password" autocomplete="new-password" required
                               class="w-full px-4 py-3 border border-slate-300 rounded-lg placeholder-slate-400 text-slate-900 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500"
                               placeholder="Password">
                    </div>
                     <div>
                        <label for="confirm-password" class="sr-only">Confirm Password</label>
                        <input id="confirm-password" name="password_confirm" type="password" autocomplete="new-password" required
                               class="w-full px-4 py-3 border border-slate-300 rounded-lg placeholder-slate-400 text-slate-900 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500"
                               placeholder="Confirm Password">
                    </div>

                    <div>
                        <button type="submit"
                                class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-sky-600 hover:bg-sky-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sky-500">
                            Sign up
                        </button>
                    </div>
                </form>
            </div>
            <p class="mt-4 text-center text-sm text-slate-600">
                Already have an account?
                <a href="<?= url_to('login') ?>" class="font-medium text-sky-600 hover:text-sky-500">
                    Sign in
                </a>
            </p>
        </div>
    </div>
</body>
</html>
