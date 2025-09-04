<?= $this->extend('layout') ?>

<?= $this->section('title') ?>Edit Profile<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="max-w-2xl mx-auto">
    <h1 class="text-3xl font-bold text-slate-800 mb-6">Edit Your Profile</h1>

    <div class="bg-white p-8 rounded-lg shadow-sm">
        <form action="<?= site_url('account/info') ?>" method="post">
            <?= csrf_field() ?>

            <div class="mb-4">
                <label for="bio" class="block text-slate-700 font-semibold mb-2">Bio</label>
                <textarea id="bio" name="bio" class="w-full p-3 border border-slate-300 rounded-lg focus:ring-sky-500 focus:border-sky-500" rows="4"><?= esc(old('bio', $user->meta->bio ?? '')) ?></textarea>
                <p class="text-sm text-slate-500 mt-1">Write a short biography about yourself.</p>
            </div>

            <div class="mb-4">
                <label for="location" class="block text-slate-700 font-semibold mb-2">Location</label>
                <input type="text" id="location" name="location" class="w-full p-3 border border-slate-300 rounded-lg focus:ring-sky-500 focus:border-sky-500" value="<?= esc(old('location', $user->meta->location ?? '')) ?>">
                <p class="text-sm text-slate-500 mt-1">Where are you located? (e.g., New York, USA)</p>
            </div>

            <div class="mb-4">
                <label for="profile_photo" class="block text-slate-700 font-semibold mb-2">Profile Photo URL</label>
                <input type="url" id="profile_photo" name="profile_photo" class="w-full p-3 border border-slate-300 rounded-lg focus:ring-sky-500 focus:border-sky-500" value="<?= esc(old('profile_photo', $user->meta->profile_photo ?? '')) ?>">
                <p class="text-sm text-slate-500 mt-1">URL to your profile picture.</p>
            </div>

            <div class="mb-6">
                <label for="cover_photo" class="block text-slate-700 font-semibold mb-2">Cover Photo URL</label>
                <input type="url" id="cover_photo" name="cover_photo" class="w-full p-3 border border-slate-300 rounded-lg focus:ring-sky-500 focus:border-sky-500" value="<?= esc(old('cover_photo', $user->meta->cover_photo ?? '')) ?>">
                <p class="text-sm text-slate-500 mt-1">URL to your cover photo.</p>
            </div>

            <div class="text-right">
                <a href="<?= site_url('profile/' . $user->username) ?>" class="text-slate-600 mr-4 hover:underline">Cancel</a>
                <button type="submit" class="bg-sky-500 text-white font-semibold px-8 py-3 rounded-full hover:bg-sky-600 transition">Save Changes</button>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
