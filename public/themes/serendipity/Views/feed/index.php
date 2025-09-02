<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<h1 class="text-4xl font-serif text-slate-900 mb-6">Your Feed</h1>

<div class="max-w-2xl mx-auto space-y-6">
    <?php if (!empty($activities)): ?>
        <?php foreach ($activities as $activity): ?>
            <div class="bg-white p-4 rounded-lg shadow-md flex items-start space-x-4">
                <!-- User Avatar -->
                <a href="<?= site_url('profile/' . $activity->user->username) ?>">
                    <img src="<?= esc($activity->user->meta->profile_photo ?? 'https://placehold.co/80x80/FBCFE8/9D174D?text=S') ?>" alt="<?= esc($activity->user->username) ?>" class="w-12 h-12 rounded-full object-cover">
                </a>

                <!-- Activity Content -->
                <div class="flex-1">
                    <div class="prose max-w-none">
                        <?= $activity->content ?>
                    </div>
                    <div class="text-xs text-slate-500 mt-2">
                        <?= $activity->created_at->humanize() ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="bg-white p-6 rounded-lg shadow-md text-center">
            <p class="text-slate-500">Your feed is empty. When your connections are active, their updates will appear here.</p>
        </div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>
