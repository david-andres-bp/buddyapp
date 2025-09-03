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
            <p class="text-slate-500">
                <!-- Member list will go here -->
                Member list coming soon.
            </p>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
