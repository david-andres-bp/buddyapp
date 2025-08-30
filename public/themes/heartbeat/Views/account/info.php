<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="max-w-2xl mx-auto">
    <h1 class="text-3xl font-bold font-serif text-indigo mb-6">My Account</h1>

    <div class="bg-white p-8 rounded-lg shadow-md">
        <div class="space-y-4">
            <div>
                <label class="block text-gray-700 font-semibold">Username</label>
                <p class="text-gray-900"><?= esc($user->username) ?></p>
            </div>
            <div>
                <label class="block text-gray-700 font-semibold">Email Address</label>
                <p class="text-gray-900"><?= esc($user->email) ?></p>
            </div>
            <div>
                <label class="block text-gray-700 font-semibold">Member Since</label>
                <p class="text-gray-900"><?= date('M j, Y', strtotime($user->created_at)) ?></p>
            </div>
        </div>

        <div class="mt-6 border-t pt-6">
            <h2 class="text-2xl font-semibold mb-4">Account Settings</h2>
            <p class="text-gray-600">
                In a full implementation, this section would contain forms to update profile information, change password, etc.
            </p>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
