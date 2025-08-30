<div class="max-w-2xl mx-auto">
    <h1 class="text-3xl font-bold font-serif text-indigo mb-6">My Account</h1>

    <div class="bg-white p-8 rounded-lg shadow-md">
        <!-- Display Info -->
        <div class="space-y-4">
            <div>
                <label class="block text-gray-700 font-semibold">Username</label>
                <p class="text-gray-900"><?= esc($user->username) ?></p>
            </div>
            <div>
                <label class="block text-gray-700 font-semibold">Email Address</label>
                <p class="text-gray-900"><?= esc($user->getIdentities()[0]->secret ?? '') ?></p>
            </div>
            <div>
                <label class="block text-gray-700 font-semibold">Member Since</label>
                <p class="text-gray-900"><?= date('M j, Y', strtotime($user->created_at)) ?></p>
            </div>
        </div>

        <!-- Edit Forms -->
        <div class="mt-6 border-t pt-6">
            <h2 class="text-2xl font-semibold mb-4">Edit Profile</h2>

            <!-- Update Profile Form -->
            <form action="<?= site_url('account/update-profile') ?>" method="post" class="space-y-4">
                <?= csrf_field() ?>
                <div>
                    <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                    <input type="text" id="username" name="username" value="<?= esc($user->username) ?>" class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                    <input type="email" id="email" name="email" value="<?= esc($user->getIdentities()[0]->secret ?? '') ?>" class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="bg-indigo-600 text-white font-semibold py-2 px-4 rounded-lg hover:bg-indigo-700 transition-colors">Update Profile</button>
                </div>
            </form>

            <!-- Update Bio Form -->
            <form action="<?= site_url('account/update-bio') ?>" method="post" class="mt-8 pt-8 border-t space-y-4">
                <?= csrf_field() ?>
                <div>
                    <label for="bio" class="block text-sm font-medium text-gray-700">Your Bio</label>
                    <textarea id="bio" name="bio" rows="4" class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"><?= esc($bio) ?></textarea>
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="bg-indigo-600 text-white font-semibold py-2 px-4 rounded-lg hover:bg-indigo-700 transition-colors">Update Bio</button>
                </div>
            </form>
        </div>
    </div>
</div>
