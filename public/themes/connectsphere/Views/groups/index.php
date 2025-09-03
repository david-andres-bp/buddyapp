<?= $this->extend('layout') ?>

<?= $this->section('title') ?>Groups<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="max-w-7xl mx-auto space-y-6">
    <div class="flex justify-between items-center">
        <h1 class="text-3xl font-bold text-slate-800">Groups</h1>
        <a href="<?= site_url('groups/new') ?>" class="bg-sky-500 text-white font-semibold px-6 py-2 rounded-full hover:bg-sky-600 transition">Create Group</a>
    </div>

    <div class="bg-white p-6 rounded-lg shadow-sm">
        <?php if (empty($groups)) : ?>
            <p class="text-slate-500 text-center py-10">There are no public groups yet. Why not create one?</p>
        <?php else : ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php foreach ($groups as $group) : ?>
                    <div class="border border-slate-200 rounded-lg p-4 flex flex-col hover:shadow-md transition">
                        <h3 class="text-xl font-bold text-sky-600">
                            <a href="<?= site_url('groups/' . $group->slug) ?>" class="hover:underline"><?= esc($group->name) ?></a>
                        </h3>
                        <p class="text-slate-600 mt-2 flex-grow"><?= esc($group->description) ?></p>
                        <div class="mt-4 text-sm text-slate-400">
                            <span>Public Group</span>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>
<?= $this->endSection() ?>
