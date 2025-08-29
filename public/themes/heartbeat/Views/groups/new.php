<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="max-w-2xl mx-auto">
    <h1 class="text-3xl font-bold font-serif text-indigo mb-6">Create a New Group</h1>

    <div class="bg-white p-8 rounded-lg shadow-md">
        <form action="<?= site_url('groups/create') ?>" method="post">
            <?= csrf_field() ?>

            <!-- Group Name -->
            <div class="mb-4">
                <label for="name" class="block text-gray-700 font-semibold mb-2">Group Name</label>
                <input type="text" id="name" name="name" class="w-full p-3 border border-gray-300 rounded-lg" value="<?= old('name') ?>" required>
            </div>

            <!-- Group Description -->
            <div class="mb-4">
                <label for="description" class="block text-gray-700 font-semibold mb-2">Description</label>
                <textarea id="description" name="description" class="w-full p-3 border border-gray-300 rounded-lg" rows="5" required><?= old('description') ?></textarea>
            </div>

            <!-- Group Status -->
            <div class="mb-6">
                <label for="status" class="block text-gray-700 font-semibold mb-2">Privacy</label>
                <select id="status" name="status" class="w-full p-3 border border-gray-300 rounded-lg">
                    <option value="public" <?= old('status') === 'public' ? 'selected' : '' ?>>Public</option>
                    <option value="private" <?= old('status') === 'private' ? 'selected' : '' ?>>Private</option>
                    <option value="hidden" <?= old('status') === 'hidden' ? 'selected' : '' ?>>Hidden</option>
                </select>
            </div>

            <!-- Submit Button -->
            <div class="text-right">
                <button type="submit" class="bg-coral text-white font-semibold px-8 py-3 rounded-full hover:bg-coral-dark transition">Create Group</button>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>
