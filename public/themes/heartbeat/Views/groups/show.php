<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="bg-white p-8 rounded-lg shadow-md">
    <div class="flex justify-between items-start">
        <div>
            <h1 class="text-4xl font-bold font-serif text-indigo"><?= esc($group->name) ?></h1>
            <p class="text-lg text-gray-500 mt-1">
                A <?= esc($group->status) ?> group
            </p>
        </div>
        <div>
            <?php if (auth()->loggedIn()): ?>
                <?php if ($membership): ?>
                    <?php if ($group->creator_id != auth()->id()): ?>
                        <form action="<?= site_url('groups/leave/' . $group->id) ?>" method="post">
                            <?= csrf_field() ?>
                            <button type="submit" class="bg-gray-500 text-white font-semibold px-6 py-2 rounded-full hover:bg-gray-600 transition">Leave Group</button>
                        </form>
                    <?php endif; ?>
                <?php else: ?>
                    <form action="<?= site_url('groups/join/' . $group->id) ?>" method="post">
                        <?= csrf_field() ?>
                        <button type="submit" class="bg-coral text-white font-semibold px-6 py-2 rounded-full hover:bg-coral-dark transition">Join Group</button>
                    </form>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>

    <div class="mt-6 border-t pt-6">
        <h2 class="text-2xl font-semibold mb-4">Description</h2>
        <p class="text-gray-700"><?= esc($group->description) ?></p>
    </div>

    <div class="mt-8">
        <h2 class="text-2xl font-semibold mb-4">Members</h2>
        <p class="text-gray-500">
            <!-- Member list will go here -->
            Member list coming soon.
        </p>
    </div>
</div>

<?= $this->endSection() ?>
