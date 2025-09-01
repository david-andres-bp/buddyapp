<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<h1 class="text-4xl font-serif text-slate-900 mb-6">My Account</h1>

<div class="bg-white p-6 rounded-lg shadow-md">
    <h2 class="text-2xl font-serif text-slate-800 border-b pb-2 mb-4">Account Information</h2>
    <p class="text-slate-600 mb-4">
        This is where you would update your account settings, like your email and password.
        This functionality is handled by CodeIgniter Shield and is not yet fully integrated into this theme's account page.
    </p>

    <form>
        <div class="space-y-4">
            <div>
                <label for="email" class="block text-sm font-medium text-slate-700">Email Address</label>
                <input type="email" name="email" id="email" class="mt-1 block w-full rounded-md border-slate-300 shadow-sm bg-slate-100" value="<?= esc($user->email) ?>" readonly>
            </div>
            <div>
                <label for="username" class="block text-sm font-medium text-slate-700">Username</label>
                <input type="text" name="username" id="username" class="mt-1 block w-full rounded-md border-slate-300 shadow-sm bg-slate-100" value="<?= esc($user->username) ?>" readonly>
            </div>
            <div>
                <button type="submit" class="btn btn-primary" disabled>Update Account (Not Implemented)</button>
            </div>
        </div>
    </form>
</div>

<?= $this->endSection() ?>
