<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="space-y-8">
    <div class="flex justify-between items-center">
        <h1 class="text-3xl font-bold font-serif text-indigo">Groups</h1>
        <a href="<?= route_to('group-new') ?>" class="bg-coral text-white font-semibold px-6 py-2 rounded-full hover:bg-coral-dark transition">Create Group</a>
    </div>

    <div class="bg-white p-6 rounded-lg shadow-md">
        <?php if (empty($groups)) : ?>
            <p class="text-gray-500">There are no public groups yet. Why not create one?</p>
        <?php else : ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php foreach ($groups as $group) : ?>
                    <div class="border rounded-lg p-4 flex flex-col">
                        <h3 class="text-xl font-semibold text-indigo">
                            <a href="<?= route_to('group-show', $group->slug) ?>" class="hover:underline"><?= esc($group->name) ?></a>
                        </h3>
                        <p class="text-gray-600 mt-2 flex-grow"><?= esc($group->description) ?></p>
                        <div class="mt-4 text-sm text-gray-500">
                            <span>Public Group</span>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection() ?>
