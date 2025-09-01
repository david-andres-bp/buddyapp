<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<h1 class="text-4xl font-serif text-slate-900 mb-6">My Connections</h1>

<!-- Pending Connection Requests -->
<div class="bg-white p-6 rounded-lg shadow-md mb-8">
    <h2 class="text-2xl font-serif text-slate-800 border-b pb-2 mb-4">Pending Requests</h2>
    <?php if (!empty($pendingReceived)): ?>
        <div class="space-y-4">
            <?php foreach ($pendingReceived as $request): ?>
                <div class="flex items-center justify-between p-3 bg-pink-light rounded-lg">
                    <div>
                        <a href="<?= site_url('profile/' . $request->user->username) ?>" class="font-semibold text-ruby hover:underline">
                            <?= esc($request->user->username) ?>
                        </a>
                        <span class="text-slate-600">wants to connect with you.</span>
                    </div>
                    <div class="flex space-x-2">
                        <form action="<?= site_url(route_to('connection-accept', $request->id)) ?>" method="post">
                            <?= csrf_field() ?>
                            <button type="submit" class="btn btn-primary text-sm">Accept</button>
                        </form>
                        <form action="<?= site_url(route_to('connection-decline', $request->id)) ?>" method="post">
                            <?= csrf_field() ?>
                            <button type="submit" class="bg-slate-300 text-slate-800 font-semibold px-4 py-2 rounded-full hover:bg-slate-400 transition text-sm">Decline</button>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p class="text-slate-500">You have no pending connection requests.</p>
    <?php endif; ?>
</div>

<!-- Current Connections -->
<div class="bg-white p-6 rounded-lg shadow-md">
    <h2 class="text-2xl font-serif text-slate-800 border-b pb-2 mb-4">Your Connections</h2>
    <?php if (!empty($currentConnections)): ?>
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php foreach ($currentConnections as $connection): ?>
                <div class="flex items-center space-x-4 bg-slate-50 p-3 rounded-lg">
                    <img src="<?= esc($connection->friend->meta->profile_photo ?? 'https://placehold.co/80x80/FBCFE8/9D174D?text=S') ?>" alt="<?= esc($connection->friend->username) ?>" class="w-16 h-16 rounded-full object-cover">
                    <div>
                        <a href="<?= site_url('profile/' . $connection->friend->username) ?>" class="font-semibold text-ruby hover:underline">
                            <?= esc($connection->friend->username) ?>
                        </a>
                        <p class="text-sm text-slate-500"><?= esc($connection->friend->meta->location ?? 'Unknown') ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p class="text-slate-500">You haven't made any connections yet. Go discover some people!</p>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>
