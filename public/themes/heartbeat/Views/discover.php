<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="space-y-8">
    <?= $this->include('partials/activity_composer') ?>

    <div>
        <h2 class="text-2xl font-bold font-serif text-indigo mb-4">Discover People</h2>

        <?php if (empty($usersByTag)) : ?>
            <div class="bg-white p-6 rounded-lg shadow-md">
                <p class="text-gray-500">No users to discover right now. Try posting some activities to build the community!</p>
            </div>
        <?php else : ?>
            <div class="space-y-8">
                <?php foreach ($usersByTag as $tag => $users) : ?>
                    <?php if (!empty($users)) : ?>
                        <div>
                            <h3 class="text-xl font-semibold text-gray-800 mb-3"><?= esc(ucfirst($tag)) ?></h3>
                            <div class="relative">
                                <div class="flex space-x-4 overflow-x-auto pb-4">
                                    <?php foreach ($users as $user) : ?>
                                        <div class="flex-shrink-0 w-48 bg-white rounded-lg shadow-md text-center p-4">
                                            <a href="<?= route_to('profile', $user->username) ?>">
                                                <img src="https://i.pravatar.cc/150?u=<?= esc($user->username) ?>" alt="<?= esc($user->username) ?>" class="w-24 h-24 rounded-full mx-auto mb-3">
                                                <h4 class="font-semibold text-indigo"><?= esc($user->username) ?></h4>
                                            </a>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection() ?>
