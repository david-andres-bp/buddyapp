<?= $this->extend('layout') ?>

<?= $this->section('title') ?>Create New Group<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="max-w-2xl mx-auto">
    <h1 class="text-3xl font-bold text-slate-800 mb-6">Create a New Group</h1>

    <div class="bg-white p-8 rounded-lg shadow-sm">
        <form action="<?= site_url('groups') ?>" method="post">
            <?= csrf_field() ?>

            <!-- Group Name -->
            <div class="mb-4">
                <label for="name" class="block text-slate-700 font-semibold mb-2">Group Name</label>
                <input type="text" id="name" name="name" class="w-full p-3 border border-slate-300 rounded-lg focus:ring-sky-500 focus:border-sky-500" value="<?= old('name') ?>" required>
            </div>

            <!-- Group Description -->
            <div class="mb-4">
                <label for="description" class="block text-slate-700 font-semibold mb-2">Description</label>
                <textarea id="description" name="description" class="w-full p-3 border border-slate-300 rounded-lg focus:ring-sky-500 focus:border-sky-500" rows="5" required><?= old('description') ?></textarea>
            </div>

            <!-- Group Status -->
            <div class="mb-6">
                <label for="status" class="block text-slate-700 font-semibold mb-2">Privacy</label>
                <select id="status" name="status" class="w-full p-3 border border-slate-300 rounded-lg focus:ring-sky-500 focus:border-sky-500">
                    <option value="public" <?= old('status') === 'public' ? 'selected' : '' ?>>Public</option>
                    <option value="private" <?= old('status') === 'private' ? 'selected' : '' ?>>Private</option>
                    <option value="hidden" <?= old('status') === 'hidden' ? 'selected' : '' ?>>Hidden</option>
                </select>
            </div>

            <!-- Submit Button -->
            <div class="text-right">
                <a href="<?= site_url('groups') ?>" class="text-slate-600 mr-4 hover:underline">Cancel</a>
                <button type="submit" class="bg-sky-500 text-white font-semibold px-8 py-3 rounded-full hover:bg-sky-600 transition">Create Group</button>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
