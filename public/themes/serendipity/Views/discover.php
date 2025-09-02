<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<h1 class="text-4xl font-serif text-slate-900 mb-6">Discover Your Match</h1>

<!-- Search and Filter Bar -->
<div class="bg-white p-6 rounded-lg shadow-md mb-8">
    <form action="<?= site_url(route_to('home')) ?>" method="get" class="grid md:grid-cols-4 gap-4 items-end">
        <div>
            <label for="location" class="block text-sm font-medium text-slate-700">Location</label>
            <input type="text" name="location" id="location" value="<?= esc($filters['location'] ?? '', 'attr') ?>" placeholder="e.g., New York" class="mt-1 block w-full">
        </div>
        <div>
            <label for="age_min" class="block text-sm font-medium text-slate-700">Min Age</label>
            <input type="number" name="age_min" id="age_min" value="<?= esc($filters['age_min'] ?? '', 'attr') ?>" min="18" placeholder="18" class="mt-1 block w-full">
        </div>
        <div>
            <label for="age_max" class="block text-sm font-medium text-slate-700">Max Age</label>
            <input type="number" name="age_max" id="age_max" value="<?= esc($filters['age_max'] ?? '', 'attr') ?>" min="18" placeholder="99" class="mt-1 block w-full">
        </div>
        <div>
            <button type="submit" class="w-full btn btn-primary py-2">Search</button>
        </div>
    </form>
</div>

<!-- Profile Grid -->
<div class="grid md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
    <?php if (!empty($users)): ?>
        <?php foreach ($users as $user): ?>
            <div class="bg-white rounded-lg shadow-lg overflow-hidden transform hover:-translate-y-2 transition-transform duration-300">
                <a href="<?= site_url('profile/' . ($user->username ?? $user->id)) ?>">
                    <img src="<?= esc($user->meta->profile_photo ?? 'https://placehold.co/400x400/FBCFE8/9D174D?text=No+Photo') ?>" alt="<?= esc($user->username) ?>" class="w-full h-64 object-cover">
                </a>
                <div class="p-4">
                    <h3 class="text-xl font-bold font-serif text-ruby">
                        <a href="<?= site_url('profile/' . ($user->username ?? $user->id)) ?>" class="hover:text-pink transition"><?= esc($user->username) ?></a>
                    </h3>
                    <p class="text-slate-600 text-sm mb-2"><?= esc($user->meta->age ?? 'N/A') ?> &bull; <?= esc($user->meta->location ?? 'Unknown') ?></p>
                    <p class="text-slate-700 text-sm"><?= esc(mb_strimwidth($user->meta->bio ?? '', 0, 80, '...')) ?></p>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p class="text-slate-600 col-span-full">No users found. Try refining your search criteria.</p>
    <?php endif; ?>
</div>

<!-- Pagination -->
<div class="mt-8">
    <?= $pager->only(array_keys(request()->getGet()))->links() ?>
</div>

<?= $this->endSection() ?>
