<?= $this->extend('layout') ?>

<?= $this->section('title') ?>Discover People<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="max-w-7xl mx-auto">
    <h1 class="text-3xl font-bold text-slate-800 mb-6">Discover People</h1>

    <!-- Search and Filter Bar -->
    <div class="bg-white p-4 rounded-lg shadow-sm mb-8">
        <form action="<?= site_url('discover') ?>" method="get" class="grid md:grid-cols-4 gap-4 items-end">
            <div>
                <label for="location" class="block text-sm font-medium text-slate-700">Location</label>
                <input type="text" name="location" id="location" value="<?= esc($filters['location'] ?? '', 'attr') ?>" placeholder="e.g., New York" class="mt-1 block w-full border-slate-300 rounded-md focus:ring-sky-500 focus:border-sky-500">
            </div>
            <div>
                <label for="age_min" class="block text-sm font-medium text-slate-700">Min Age</label>
                <input type="number" name="age_min" id="age_min" value="<?= esc($filters['age_min'] ?? '', 'attr') ?>" min="18" placeholder="18" class="mt-1 block w-full border-slate-300 rounded-md focus:ring-sky-500 focus:border-sky-500">
            </div>
            <div>
                <label for="age_max" class="block text-sm font-medium text-slate-700">Max Age</label>
                <input type="number" name="age_max" id="age_max" value="<?= esc($filters['age_max'] ?? '', 'attr') ?>" min="18" placeholder="99" class="mt-1 block w-full border-slate-300 rounded-md focus:ring-sky-500 focus:border-sky-500">
            </div>
            <div>
                <button type="submit" class="w-full bg-sky-500 text-white font-semibold px-6 py-2 rounded-full hover:bg-sky-600 transition">Search</button>
            </div>
        </form>
    </div>

    <!-- Profile Grid -->
    <div class="grid md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        <?php if (!empty($users)): ?>
            <?php foreach ($users as $user): ?>
                <div class="bg-white rounded-lg shadow-sm overflow-hidden text-center">
                    <a href="<?= site_url('profile/' . ($user->username ?? $user->id)) ?>">
                        <div class="h-24 bg-sky-400"></div>
                        <div class="p-4 -mt-12">
                            <img src="<?= esc($user->meta->profile_photo ?? 'https://placehold.co/96x96/FFFFFF/38BDF8?text=' . substr($user->username, 0, 1)) ?>" alt="<?= esc($user->username) ?>" class="w-24 h-24 rounded-full mx-auto border-4 border-white">
                        </div>
                    </a>
                    <div class="p-4 pt-0">
                        <h3 class="text-xl font-bold text-slate-800">
                            <a href="<?= site_url('profile/' . ($user->username ?? $user->id)) ?>" class="hover:underline"><?= esc($user->username) ?></a>
                        </h3>
                        <p class="text-slate-500 text-sm mb-2"><?= esc($user->meta->location ?? 'Unknown') ?></p>
                        <p class="text-slate-600 text-sm"><?= esc(mb_strimwidth($user->meta->bio ?? '', 0, 100, '...')) ?></p>
                        <div class="mt-4">
                            <button class="bg-slate-800 text-white text-sm font-semibold px-4 py-1.5 rounded-full hover:bg-slate-900">Follow</button>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-slate-500 col-span-full text-center py-10">No users found. Try refining your search criteria.</p>
        <?php endif; ?>
    </div>

    <!-- Pagination -->
    <div class="mt-8">
        <?= $pager->links() ?>
    </div>
</div>
<?= $this->endSection() ?>
