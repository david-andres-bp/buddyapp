<?= $this->extend('layout') ?>

<?= $this->section('title') ?><?= esc($group->name) ?><?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="max-w-4xl mx-auto">
    <div class="bg-white p-6 rounded-lg shadow-sm">
        <div class="flex justify-between items-start">
            <div>
                <h1 class="text-3xl font-bold text-slate-800"><?= esc($group->name) ?></h1>
                <p class="text-lg text-slate-500 mt-1">
                    A <?= esc($group->status) ?> group
                </p>
            </div>
            <div>
                <?php if (auth()->loggedIn()): ?>
                    <?php if ($membership): ?>
                        <?php if ($group->creator_id != auth()->id()): ?>
                            <form action="<?= site_url('groups/' . $group->id . '/leave') ?>" method="post">
                                <?= csrf_field() ?>
                                <button type="submit" class="bg-slate-600 text-white font-semibold px-6 py-2 rounded-full hover:bg-slate-700 transition">Leave Group</button>
                            </form>
                        <?php else: ?>
                            <span class="text-sm text-slate-500 font-semibold">You are the creator</span>
                        <?php endif; ?>
                    <?php else: ?>
                        <form action="<?= site_url('groups/' . $group->id . '/join') ?>" method="post">
                            <?= csrf_field() ?>
                            <button type="submit" class="bg-sky-500 text-white font-semibold px-6 py-2 rounded-full hover:bg-sky-600 transition">Join Group</button>
                        </form>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>

        <div class="mt-6 border-t border-slate-200 pt-6">
            <h2 class="text-2xl font-bold text-slate-700 mb-4">Description</h2>
            <p class="text-slate-700 prose"><?= esc($group->description) ?></p>
        </div>

        <div class="mt-8 border-t border-slate-200 pt-6">
            <h2 class="text-2xl font-bold text-slate-700 mb-4">Members</h2>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                <?php if (!empty($members)): ?>
                    <?php foreach ($members as $member): ?>
                        <a href="<?= site_url('profile/' . $member->username) ?>" class="text-center p-2 rounded-lg hover:bg-slate-100">
                            <img src="https://placehold.co/96x96/38BDF8/FFFFFF?text=<?= esc(substr($member->username, 0, 1)) ?>" alt="<?= esc($member->username) ?>" class="w-24 h-24 rounded-full mx-auto">
                            <p class="mt-2 font-semibold text-slate-700"><?= esc($member->username) ?></p>
                        </a>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-slate-500 col-span-full">This group has no members yet.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
