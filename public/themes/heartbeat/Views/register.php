<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8 bg-white p-10 rounded-lg shadow-md">
        <div>
            <h2 class="mt-6 text-center text-3xl font-extrabold text-indigo font-serif">
                Create your account
            </h2>
        </div>

        <?php if (session('errors')) : ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <ul>
                <?php foreach (session('errors') as $error) : ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach ?>
                </ul>
            </div>
        <?php endif ?>

        <form class="mt-8 space-y-6" action="<?= site_url(route_to('register')) ?>" method="post">
            <?= csrf_field() ?>

            <div>
                <label for="username" class="sr-only">Username</label>
                <input id="username" name="username" type="text" autocomplete="username" required class="appearance-none rounded-md relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Username" value="<?= old('username') ?>">
            </div>

            <div>
                <label for="email" class="sr-only">Email address</label>
                <input id="email" name="email" type="email" autocomplete="email" required class="appearance-none rounded-md relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Email address" value="<?= old('email') ?>">
            </div>

            <div>
                <label for="password" class="sr-only">Password</label>
                <input id="password" name="password" type="password" autocomplete="new-password" required class="appearance-none rounded-md relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Password">
            </div>

            <div>
                <label for="password_confirm" class="sr-only">Confirm Password</label>
                <input id="password_confirm" name="password_confirm" type="password" autocomplete="new-password" required class="appearance-none rounded-md relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Confirm Password">
            </div>

            <div>
                <button type="submit" class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-coral hover:bg-coral-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Create Account
                </button>
            </div>

            <p class="mt-2 text-center text-sm text-gray-600">
                Already have an account?
                <a href="<?= site_url(route_to('login')) ?>" class="font-medium text-indigo hover:text-indigo-500">
                    Sign in
                </a>
            </p>
        </form>
    </div>
</div>

<?= $this->endSection() ?>
